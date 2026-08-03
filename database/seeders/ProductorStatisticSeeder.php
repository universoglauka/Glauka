<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductorStatistic;

class ProductorStatisticSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    ProductorStatistic::create([
      'user_id' => 2,
      'year' => 2025,
      'month' => 11,
      'total_revenue' => 120000,
      'total_tickets' => 340,
    ]);
    ProductorStatistic::create([
      'user_id' => 2,
      'year' => 2025,
      'month' => 12,
      'total_revenue' => 185000,
      'total_tickets' => 510,
    ]);

    ProductorStatistic::create([
      'user_id' => 2,
      'year' => 2026,
      'month' => 1,
      'total_revenue' => 210000,
      'total_tickets' => 620,
    ]);
  }
}
