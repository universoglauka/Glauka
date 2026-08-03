<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;
use App\Models\User;
use App\Models\Productor;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $musical = Genre::where('name', 'Musical')->first();


    User::create([
      'name' => 'Admin',
      'email' => 'universoglauka@gmail.com',
      'userIcon' => 'GlaukaIcon.png',
      'password' => Hash::make('Admin'),
      'rol' => 'admin',
      'plan_id' => 1,
    ]);

    $p = User::create([
      'name' => 'Lara',
      'email' => 'laraflorian@gmail.com',
      'userIcon' => 'icon2.jpg',
      'password' => Hash::make('laraflorian'),
      'rol' => 'producer',
      'plan_id' => 4,
    ]);
    Productor::create([
      'user_id' => $p->id,
      'name_group' => 'Lara Florian',
      'description' => 'Productora de teatro independiente con más de 10 años de experiencia en la industria.',
      'genre_id' => $musical->id,
    ]);

    $u = User::create([
      'name' => 'May',
      'nicknameUser' => 'May',
      'email' => 'may@gmail.com',
      'userIcon' => 'icon1.jpg',
      'password' => Hash::make('may'),
      'rol' => 'user',
      'plan_id' => 2,
    ]);
    $u->labels()->attach([1, 3]);
  }
}
