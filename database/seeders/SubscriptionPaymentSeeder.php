<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscription = Subscription::first();

        $payments = [
            [
                'payment_id'     => 'MP100001',
                'amount'         => 100,
                'payment_method' => 'Mercado Pago',
                'status'         => 'approved',
                'paid_at'        => now()->subMonths(5),
            ],
            [
                'payment_id'     => 'MP100002',
                'amount'         => 100,
                'payment_method' => 'Mercado Pago',
                'status'         => 'approved',
                'paid_at'        => now()->subMonths(4),
            ],
            [
                'payment_id'     => 'MP100003',
                'amount'         => 100,
                'payment_method' => 'Mercado Pago',
                'status'         => 'approved',
                'paid_at'        => now()->subMonths(3),
            ],
            [
                'payment_id'     => 'MP100004',
                'amount'         => 100,
                'payment_method' => 'Mercado Pago',
                'status'         => 'approved',
                'paid_at'        => now()->subMonths(2),
            ],
            [
                'payment_id'     => 'MP100005',
                'amount'         => 100,
                'payment_method' => 'Mercado Pago',
                'status'         => 'approved',
                'paid_at'        => now()->subMonth(),
            ],
        ];

        foreach ($payments as $payment){
            SubscriptionPayment::create([
                'subscription_id' => $subscription->id,
                ...$payment
            ]);
        }
    }
}
