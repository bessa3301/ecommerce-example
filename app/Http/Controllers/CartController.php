<?php

namespace App\Http\Controllers;

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
            $subtotal = $item->quantity * $item->product->price;
            $vatRate = $item->product->vat_rate ?? 0;
            $vatAmount = $subtotal * ($vatRate / 100);
            
            return [
                'id' => $item->id,
                'product' => [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'price' => $item->product->price,
                    'vat_rate' => $vatRate,
                    'stock_quantity' => $item->product->stock_quantity,
                ],
                'quantity' => $item->quantity,
                'subtotal' => $subtotal,
                'vat_amount' => $vatAmount,
            ];
        });

        $subtotal = $items->sum('subtotal');
        $vatAmount = $items->sum('vat_amount');
        $total = $subtotal + $vatAmount;

        return Inertia::render('Cart/Index', [
            'cart' => [
                'id' => $cart->id,
                'items' => $items,
                'subtotal' => $subtotal,
                'vat_amount' => $vatAmount,
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
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    public function showCheckout()
    {
        $cart = auth()->user()->getOrCreateCart();
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors([
                'cart' => 'Your cart is empty.',
            ]);
        }

        $items = $cart->items->map(function ($item) {
            $subtotal = $item->quantity * $item->product->price;
            $vatRate = $item->product->vat_rate ?? 0;
            $vatAmount = $subtotal * ($vatRate / 100);
            
            return [
                'id' => $item->id,
                'product' => [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'price' => $item->product->price,
                    'vat_rate' => $vatRate,
                    'stock_quantity' => $item->product->stock_quantity,
                ],
                'quantity' => $item->quantity,
                'subtotal' => $subtotal,
                'vat_amount' => $vatAmount,
            ];
        });

        $subtotal = $items->sum('subtotal');
        $vatAmount = $items->sum('vat_amount');
        $total = $subtotal + $vatAmount;

        return Inertia::render('Checkout/Index', [
            'cart' => [
                'id' => $cart->id,
                'items' => $items,
                'subtotal' => $subtotal,
                'vat_amount' => $vatAmount,
                'total' => $total,
            ],
        ]);
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

        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->stock_quantity) {
                return redirect()->route('cart.index')->withErrors([
                    'stock' => "Not enough stock for {$item->product->name}. Available: {$item->product->stock_quantity}",
                ]);
            }
        }

        DB::transaction(function () use ($cart) {
            $items = $cart->items->map(function ($cartItem) {
                $subtotal = $cartItem->quantity * $cartItem->product->price;
                $vatRate = $cartItem->product->vat_rate ?? 0;
                $vatAmount = $subtotal * ($vatRate / 100);
                
                return [
                    'subtotal' => $subtotal,
                    'vat_amount' => $vatAmount,
                ];
            });
            
            $subtotal = $items->sum('subtotal');
            $vatAmount = $items->sum('vat_amount');
            $total = $subtotal + $vatAmount;
            
            $order = Order::create([
                'user_id' => auth()->id(),
                'subtotal' => $subtotal,
                'vat_amount' => $vatAmount,
                'total' => $total,
            ]);

            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                    'subtotal' => $cartItem->quantity * $cartItem->product->price,
                ]);

                $cartItem->product->decrement('stock_quantity', $cartItem->quantity);
            }

            $cart->items()->delete();
        });

        return redirect()->route('cart.index')->with('success', 'Order placed successfully!');
    }
}
