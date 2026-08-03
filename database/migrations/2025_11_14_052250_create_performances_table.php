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
    Schema::create('performances', function (Blueprint $table) {
      $table->id();
      $table->foreignId('obra_id')->constrained()->onDelete('cascade');
      $table->date('fechaObra');
      $table->time('horaObra');
      $table->integer('stock')->default(0);
      $table->string('linkVirtual')->nullable();
      $table->enum('estado_pago', ['pendiente', 'realizado'])->default('pendiente');
      $table->boolean('visible_admin')->default(true);
      $table->boolean('cancelado')->default(false);
      $table->timestamps();
    });
  }
  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('performances');
  }
};
