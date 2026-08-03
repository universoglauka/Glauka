<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('obras', function (Blueprint $table) {
      $table->id();
      $table->foreignId('productor_id')->constrained('productores')->onDelete('cascade');
      $table->string('nombre_obra');
      $table->string('autor')->nullable();
      $table->string('clasificacion');
      $table->decimal('precio', 10, 2);
      $table->string('ubicacion');
      $table->string('imagen')->nullable();
      $table->text('sinopsis')->nullable();
      $table->string('slug')->unique();
      $table->boolean('solo_compartido')->default(false);
      $table->boolean('cancelado')->default(false);
      $table->boolean('eliminado')->default(false);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('obras');
  }
};
