<?php

namespace App\Jobs;

use App\Mail\LowStockNotification;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class NotifyLowStock implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     * Checks all products for low stock and sends notification to admin.
     */
    public function handle(): void
    {
        // Find admin user by is_admin flag
        $admin = User::where('is_admin', true)->first();

        if (!$admin) {
            return;
        }

        // Get all products with low stock (10 or under)
        $lowStockProducts = Product::where('stock_quantity', '<=', 10)
            ->orderBy('stock_quantity', 'asc')
            ->get();

        // Only send email if there are products with low stock
        if ($lowStockProducts->isNotEmpty()) {
            Mail::to($admin->email)->send(
                new LowStockNotification($lowStockProducts)
            );
        }
    }
}
