<?php

namespace Database\Seeders;

use App\Models\Obra;
use App\Models\Performance;
use App\Models\Genre;
use App\Models\Adaptation;
use App\Models\MemberProduction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ObraSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $o = Obra::create([
      'productor_id' => 1,
      'nombre_obra' => 'Heathers, el musical',
      'autor' => 'Laurence O Keefe y Kevin Murphy',
      'clasificacion' => 'adultos',
      'precio' => 3000.00,
      'ubicacion' => 'Teatro Colón',
      'imagen' => 'ShZPrhKfC7kG196e4E3WjIIfEgWMtkDF5pU3WyPn.jpg',
      'sinopsis' => '“Heathers: The Musical” es una comedia oscura ambientada en una escuela secundaria de los años 80. La historia sigue a Veronica Sawyer, una chica inteligente pero impopular que logra entrar al grupo más popular del colegio: las Heathers, tres chicas ricas y crueles que dominan la escuela.
      Aunque al principio Veronica disfruta de su nueva popularidad, pronto se siente incómoda con la maldad del grupo. Entonces conoce a J.D. (Jason Dean), un chico misterioso y rebelde que desprecia el sistema escolar y la hipocresía de la sociedad.
      Lo que empieza como una historia de amor adolescente se vuelve oscuro cuando J.D. lleva su rebeldía demasiado lejos: los dos terminan involucrados en una serie de “muertes accidentales” de estudiantes tóxicos, mientras Veronica lucha por detenerlo y recuperar el control.',
      'slug' => 'Heathers-el-musical',
      'solo_compartido' => false,
    ]);

    $o->genres()->attach([1, 2, 4]);
    $o->adaptations()->attach([1]);

    $o->membersProduction()->createMany([
      ['label_id' => 1, 'name' => 'Julia Tozzi'],
      ['label_id' => 1, 'name' => 'Nico Di Pace'],
      ['label_id' => 1, 'name' => 'Sofía Morandi'],
      ['label_id' => 1, 'name' => 'Flor Anca'],
      ['label_id' => 1, 'name' => 'Martu Loyato'],
      ['label_id' => 1, 'name' => 'Rocío Caldes'],

      ['label_id' => 2, 'name' => 'Fer Dente'],

      ['label_id' => 4, 'name' => 'Caro Mandri'],

      ['label_id' => 6, 'name' => 'Gonzalo Córdoba Estévez'],
    ]);

    Performance::create([
      'obra_id' => $o->id,
      'fechaObra' => '2026-11-19',
      'horaObra' => '20:00:00',
      'stock' => 20,
    ]);

    Performance::create([
      'obra_id' => $o->id,
      'fechaObra' => '2026-11-21',
      'horaObra' => '20:00:00',
      'stock' => 30
    ]);


    $o = Obra::create([
      'productor_id' => 1,
      'nombre_obra' => 'Epic: El Musical',
      'autor' => 'Jorge Rivera-Herrans',
      'clasificacion' => 'todo publico',
      'precio' => 2500.00,
      'ubicacion' => 'AJO, Calle 47 395 Centro, B1900 La Plata, Provincia de Buenos Aires',
      'imagen' => 'HIRV336VJqnDesWGDgfxI4pPtCccsyleACtk7zzC.jpg',
      'sinopsis' => 'Es un musical inspirado en La Odisea de Homero, que narra el épico viaje de regreso de Odiseo a Ítaca después de la Guerra de Troya. La historia se cuenta completamente a través de canciones, divididas en nueve sagas que funcionan como capítulos. A lo largo de su travesía, Odiseo enfrenta numerosos desafíos, dioses y monstruos.',
      'slug' => 'Epic:El-Musical',
      'solo_compartido' => false,
    ]);
    $o->genres()->attach([1, 4]);
    $o->membersProduction()->createMany([
      ['label_id' => 1, 'name' => 'Jorge Rivera-Herrans'],
      ['label_id' => 1, 'name' => 'Teagan Earley'],
      ['label_id' => 1, 'name' => 'Armando Julián'],
      ['label_id' => 1, 'name' => 'Steven Dookie'],

      ['label_id' => 2, 'name' => 'Jorge Rivera-Herrans'],

      ['label_id' => 5, 'name' => 'Jorge Rivera-Herrans'],
      ['label_id' => 5, 'name' => 'J.P. Warner'],
    ]);

    Performance::create([
      'obra_id' => $o->id,
      'fechaObra' => '2026-11-23',
      'horaObra' => '18:00:00',
      'stock' => 25
    ]);

    Performance::create([
      'obra_id' => $o->id,
      'fechaObra' => '2026-11-24',
      'horaObra' => '14:00:00',
      'stock' => 25
    ]);

    Performance::create([
      'obra_id' => $o->id,
      'fechaObra' => '2026-11-25',
      'horaObra' => '20:00:00',
      'stock' => 25
    ]);


    $o = Obra::create([
      'productor_id' => 1,
      'nombre_obra' => 'Encantadores',
      'autor' => 'Daniela González',
      'clasificacion' => 'infantil',
      'precio' => 3000.00,
      'ubicacion' => 'Teatro Colón',
      'imagen' => '7mf28dwmmAnJDNCLj8iGsellpiq2JOwIRZNwqz5m.jpg',
      'sinopsis' => 'Encantadores es una propuesta interactiva para bebes en Buenos Aires especialmente diseñada para niños de 0 a 3 años inclusive.
      Un recorrido musical que los convoca a explorar, descubrir y experimentar creando un espacio de ilusión donde todo es posible.
      A través de canciones, imágenes, colores y formas se van creando y recreando las diferentes escenas. Dentro de este marco bebés y adultos se ven implicados en una aventura ficcional. El compartir los pone en acción y les permite conectarse con los aspectos más puros de la infancia: las emociones, las acciones, la imaginación y la simbolización.
      La obra y todo su proceso creativo han sido acompañados y asesorados por un equipo de profesionales relacionados a las ciencias de educación y psicopedagogía procurando de esta forma una propuesta artística acorde y respetuosa en relación a nuestros destinatarios.',
      'slug' => 'Encantadores',
      'solo_compartido' => false,
    ]);

    $o->genres()->attach([4, 7]);
    $o->adaptations()->attach([2]);
    $o->membersProduction()->createMany([
      ['label_id' => 1, 'name' => 'Barby Goity'],
      ['label_id' => 1, 'name' => 'Silvia Cerva'],
      ['label_id' => 1, 'name' => 'Gaby Zabala'],

      ['label_id' => 2, 'name' => 'Daniela Gonzáles'],

      ['label_id' => 5, 'name' => 'Daniela Gonzáles'],

      ['label_id' => 6, 'name' => 'Gaby Zabala'],
    ]);

    Performance::create([
      'obra_id' => $o->id,
      'fechaObra' => '2026-02-28',
      'horaObra' => '17:00:00',
      'stock' => 40
    ]);


    $o = Obra::create([
      'productor_id' => 1,
      'nombre_obra' => 'Ojo de Pombero',
      'autor' => 'Toto Castiñeiras',
      'clasificacion' => 'adultos',
      'precio' => 4000.00,
      'ubicacion' => 'Teatro Auditorium Centro Provincial de las Artes',
      'imagen' => 'pB6P1N8o9dRuHnGeicNRzHlELLqHeSXWxM36xrs6.jpg',
      'sinopsis' => '"Pombero, agazapado en la mirada del Diablo, espera la noche del carnaval para bajar el monte y molestar a las muchachas. Esta vez, la Juana, lazo en mano, parece dispuesta a cazarlo. Lo que resta es venganza.',
      'slug' => 'Ojo de Pombero',
      'solo_compartido' => false,
    ]);

    $o->genres()->attach([1, 2]);
    $o->membersProduction()->createMany([
      ['label_id' => 1, 'name' => 'Mariela Acosta'],
      ['label_id' => 1, 'name' => 'Toto Castiñeiras'],
      ['label_id' => 1, 'name' => 'Santiago Garcia Ibañez'],
      ['label_id' => 1, 'name' => 'Julia Gárriz'],
      ['label_id' => 1, 'name' => 'Julieta Laso'],
      ['label_id' => 1, 'name' => 'Mariano Torre'],

      ['label_id' => 2, 'name' => 'Toto Castiñeiras'],

      ['label_id' => 3, 'name' => 'Sofía Orsi'],

      ['label_id' => 4, 'name' => 'Daniela Taiana'],

      ['label_id' => 5, 'name' => 'Sofía Orsi'],

      ['label_id' => 6, 'name' => 'Alejandro Le Roux'],
      ['label_id' => 6, 'name' => 'Lucio Mantel'],
      ['label_id' => 6, 'name' => 'Romina Salerno'],
      ['label_id' => 6, 'name' => 'Sofía Orsi'],
    ]);

    Performance::create([
      'obra_id' => $o->id,
      'fechaObra' => '2026-03-05',
      'horaObra' => '19:00:00',
      'stock' => 70
    ]);
  }
}
