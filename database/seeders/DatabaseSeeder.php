<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  use WithoutModelEvents;

  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $this->call([
      LabelSeeder::class,
      GenreSeeder::class,
      AdaptationSeeder::class,
      PlanSeeder::class,
      UserSeeder::class,
      ProductorStatisticSeeder::class,
      ObraSeeder::class,
      AnnouncementSeeder::class,
      SubscriptionSeeder::class,
      SubscriptionPaymentSeeder::class,
    ]);
  }
}
