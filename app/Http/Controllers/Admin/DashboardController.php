<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::sum('total');
        $totalVat = Order::sum('vat_amount');
        $totalProfit = $totalRevenue - $totalVat;
        $totalOrders = Order::count();
        $totalCustomers = User::where('is_admin', false)->count();
        $totalProducts = Product::count();

        $recentOrders = Order::with('user', 'items.product')
            ->latest()
            ->limit(3)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'user_name' => $order->user ? $order->user->name : 'Deleted User',
                    'total' => (float) $order->total,
                    'items_count' => $order->items->sum('quantity'),
                    'created_at' => $order->created_at->format('M d, Y H:i'),
                ];
            });

        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as total_revenue'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(4)
            ->get()
            ->filter(function ($item) {
                return $item->product !== null;
            })
            ->map(function ($item) {
                return [
                    'name' => $item->product->name,
                    'total_sold' => (int) $item->total_sold,
                    'total_revenue' => (float) $item->total_revenue,
                ];
            })
            ->values();

        $lowStockProducts = Product::where('stock_quantity', '<=', 10)
            ->orderBy('stock_quantity')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'stock_quantity' => $product->stock_quantity,
                ];
            });

        $salesChartData = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as revenue'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'revenue' => (float) $item->revenue,
                ];
            });

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'total_revenue' => (float) $totalRevenue,
                'total_vat' => (float) $totalVat,
                'total_profit' => (float) $totalProfit,
                'total_orders' => (int) $totalOrders,
                'total_customers' => (int) $totalCustomers,
                'total_products' => (int) $totalProducts,
            ],
            'recent_orders' => $recentOrders->values(),
            'top_products' => $topProducts,
            'low_stock_products' => $lowStockProducts->values(),
            'sales_chart_data' => $salesChartData->values(),
        ]);
    }
}
