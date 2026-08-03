<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Adaptation;

class AdaptationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $adaptations = [
      'Auditiva',
      'Móvil',
      'Visual',
    ];

    foreach ($adaptations as $adaptation) {
      Adaptation::firstOrCreate(['name' => $adaptation]);
    }
  }
}
