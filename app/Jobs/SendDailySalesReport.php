<?php

namespace App\Jobs;

use App\Mail\DailySalesReport;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendDailySalesReport implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        if (!$admin) {
            return;
        }

        $today = now()->startOfDay();
        $tomorrow = now()->copy()->addDay()->startOfDay();

        $orders = Order::whereBetween('created_at', [$today, $tomorrow])
            ->with('items.product')
            ->get();

        $totalOrders = $orders->count();
        $totalRevenue = $orders->sum('total');
        $totalItemsSold = $orders->sum(function ($order) {
            return $order->items->sum('quantity');
        });

        $productSales = OrderItem::whereBetween('created_at', [$today, $tomorrow])
            ->selectRaw('product_id, SUM(quantity) as total_quantity, SUM(subtotal) as total_revenue')
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get();

        $salesData = [
            'date' => now()->format('F j, Y'),
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'total_items_sold' => $totalItemsSold,
            'top_products' => $productSales->map(function ($item) {
                return [
                    'name' => $item->product->name,
                    'quantity' => $item->total_quantity,
                    'revenue' => $item->total_revenue,
                ];
            })->toArray(),
        ];

        Mail::to($admin->email)->send(new DailySalesReport($salesData));
    }
}
