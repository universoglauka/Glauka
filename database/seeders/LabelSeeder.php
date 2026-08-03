<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Label;

class LabelSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $labels = [
      'Actor/actriz',
      'Director',
      'Maquillista',
      'Vestuarista',
      'Sonidista',
      'Escenógrafo',
    ];

    foreach ($labels as $label) {
      Label::create([
        'name' => $label
      ]);
    }
  }
}
