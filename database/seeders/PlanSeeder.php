<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'nombre' => 'Admin'
        ]);

        Plan::create([
            'nombre' => 'Basic'
        ]);

        Plan::create([
            'nombre' => 'Premium user',
            'precio' => 50
        ]);

        Plan::create([
            'nombre' => 'Premium producer',
            'precio' => 100
        ]);
    }
}
