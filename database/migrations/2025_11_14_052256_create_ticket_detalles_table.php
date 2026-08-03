<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('ticketdetalles', function (Blueprint $table) {
      $table->id();
      $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
      $table->foreignId('obra_id')->constrained('obras')->onDelete('cascade');
      $table->foreignId('performance_id')->constrained('performances')->onDelete('cascade');
      $table->string('nombre_obra');
      $table->boolean('es_virtual')->default(false);
      $table->string('nombre_productor');
      $table->dateTime('fecha_hora_obra');
      $table->string('codigo')->unique();
      $table->integer('cantidad');
      $table->json('emails_virtuales')->nullable();
      $table->decimal('precio_u', 10, 2);
      $table->decimal('subtotal', 10, 2);
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('ticketdetalles');
  }
};
