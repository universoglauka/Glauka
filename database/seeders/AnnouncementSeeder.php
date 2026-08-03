<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Productor;
use App\Models\Announcement;

class AnnouncementSeeder extends Seeder
{
  public function run(): void
  {
    $productor = Productor::where('user_id', 2)->first();

    if (!$productor) {
      return;
    }

    Announcement::create([
      'productor_id' => $productor->id,
      'title' => 'Casting abierto para nueva obra',
      'content' => 'Estamos buscando actores y actrices para una nueva producción. Los interesados pueden venir al teatro Colón el dia 10 de agosto a las 15hs.',
      'expires_at' => now()->addDays(30),
    ]);

    Announcement::create([
      'productor_id' => $productor->id,
      'title' => 'Encuentro de grupos teatrales',
      'content' => 'El próximo sábado realizaremos una reunión abierta para productores y elencos independientes. Nos encontraremos en plaza de Mayo este Lunes, de 9 a 15hs.',
      'expires_at' => now()->addDays(15),
    ]);
  }
}
