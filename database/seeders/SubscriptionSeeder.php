<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $u = User::where('email', 'laraflorian@gmail.com')->first();

    Subscription::create([
      'user_id'    => $u->id,
      'plan_id'    => 4,
      'payment_id' => 'MP000001',
      'starts_at'  => now()->subMonths(5),
      'expires_at' => now()->addMonth(),
      'status'     => 'active',
    ]);
  }
}
