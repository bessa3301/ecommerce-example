<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HistoricDataSeeder extends Seeder
{
    /**
     * Seed historic sales and customer data.
     */
    public function run(): void
    {
        
        $products = Product::all();
        
        if ($products->isEmpty()) {
            $this->command->warn('No products found. Please run ProductSeeder first.');
            return;
        }

        
        $customers = [];
        $customerNames = [
            'John Smith', 'Jane Doe', 'Michael Johnson', 'Sarah Williams', 'David Brown',
            'Emily Davis', 'Robert Miller', 'Jessica Wilson', 'William Moore', 'Ashley Taylor',
            'James Anderson', 'Amanda Thomas', 'Christopher Jackson', 'Melissa White', 'Daniel Harris',
            'Michelle Martin', 'Matthew Thompson', 'Stephanie Garcia', 'Andrew Martinez', 'Nicole Robinson',
        ];

        foreach ($customerNames as $name) {
            $email = strtolower(str_replace(' ', '.', $name)) . '@example.com';
            $customers[] = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now()->subDays(rand(30, 60)),
            ]);
        }

        $this->command->info('Created ' . count($customers) . ' historic customers.');

        
        $ordersCreated = 0;
        $today = now();
        
        
        for ($daysAgo = 0; $daysAgo < 60; $daysAgo++) {
            $orderDate = $today->copy()->subDays($daysAgo);
            
            
            
            
            
            if ($daysAgo <= 7) {
                $ordersPerDay = rand(2, 5);
            } elseif ($daysAgo <= 30) {
                $ordersPerDay = rand(1, 3);
            } else {
                $ordersPerDay = rand(0, 2);
            }

            for ($i = 0; $i < $ordersPerDay; $i++) {
                
                $customer = $customers[array_rand($customers)];
                
                
                $itemCount = rand(1, 5);
                $selectedProducts = $products->random(min($itemCount, $products->count()));
                
                $orderTotal = 0;
                $orderItems = [];
                
                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 3);
                    $price = $product->price;
                    $subtotal = $price * $quantity;
                    $orderTotal += $subtotal;
                    
                    $orderItems[] = [
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'subtotal' => $subtotal,
                    ];
                }
                
                
                $orderTime = $orderDate->copy()
                    ->setHour(rand(8, 20))
                    ->setMinute(rand(0, 59))
                    ->setSecond(rand(0, 59));
                
                $order = Order::create([
                    'user_id' => $customer->id,
                    'total' => $orderTotal,
                    'created_at' => $orderTime,
                    'updated_at' => $orderTime,
                ]);
                
                
                foreach ($orderItems as $itemData) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $itemData['product_id'],
                        'quantity' => $itemData['quantity'],
                        'price' => $itemData['price'],
                        'subtotal' => $itemData['subtotal'],
                        'created_at' => $orderTime,
                        'updated_at' => $orderTime,
                    ]);
                }
                
                $ordersCreated++;
            }
        }

        $this->command->info("Created {$ordersCreated} historic orders over the last 60 days.");
        $this->command->info('Historic data seeding completed!');
    }
}

