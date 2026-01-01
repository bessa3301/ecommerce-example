<?php

namespace App\Http\Controllers;

use App\Jobs\NotifyLowStock;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->getOrCreateCart();
        $cart->load('items.product');

        $items = $cart->items->map(function ($item) {
            return [
                'id' => $item->id,
                'product' => [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'price' => $item->product->price,
                    'stock_quantity' => $item->product->stock_quantity,
                ],
                'quantity' => $item->quantity,
                'subtotal' => $item->quantity * $item->product->price,
            ];
        });

        $total = $items->sum('subtotal');

        return Inertia::render('Cart/Index', [
            'cart' => [
                'id' => $cart->id,
                'items' => $items,
                'total' => $total,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = auth()->user()->getOrCreateCart();

        // Check stock availability
        $existingItem = $cart->items()->where('product_id', $product->id)->first();
        $requestedQuantity = $request->quantity;
        $currentQuantity = $existingItem ? $existingItem->quantity : 0;
        $totalQuantity = $currentQuantity + $requestedQuantity;

        if ($totalQuantity > $product->stock_quantity) {
            return back()->withErrors([
                'quantity' => 'Not enough stock available. Available: ' . $product->stock_quantity,
            ]);
        }

        if ($existingItem) {
            $existingItem->update(['quantity' => $totalQuantity]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        // Ensure the cart item belongs to the authenticated user
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = $cartItem->product;

        if ($request->quantity > $product->stock_quantity) {
            return back()->withErrors([
                'quantity' => 'Not enough stock available. Available: ' . $product->stock_quantity,
            ]);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    public function destroy(CartItem $cartItem)
    {
        // Ensure the cart item belongs to the authenticated user
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    public function checkout()
    {
        $cart = auth()->user()->getOrCreateCart();
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors([
                'cart' => 'Your cart is empty.',
            ]);
        }

        // Validate stock availability
        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->stock_quantity) {
                return redirect()->route('cart.index')->withErrors([
                    'stock' => "Not enough stock for {$item->product->name}. Available: {$item->product->stock_quantity}",
                ]);
            }
        }

        DB::transaction(function () use ($cart) {
            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => $cart->total,
            ]);

            // Create order items and reduce stock
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                    'subtotal' => $cartItem->subtotal,
                ]);

                // Reduce stock
                $cartItem->product->decrement('stock_quantity', $cartItem->quantity);

                // Check if product is now low stock and dispatch notification
                $cartItem->product->refresh();
                if ($cartItem->product->isLowStock()) {
                    NotifyLowStock::dispatch($cartItem->product);
                }
            }

            // Clear cart
            $cart->items()->delete();
        });

        return redirect()->route('cart.index')->with('success', 'Order placed successfully!');
    }
}
