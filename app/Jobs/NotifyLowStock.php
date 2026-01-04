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

    public function __construct(
        public Product $product
    ) {
    }

    public function handle(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        if ($admin && $this->product->isLowStock()) {
            Mail::to($admin->email)->send(
                new LowStockNotification($this->product)
            );
        }
    }
}
