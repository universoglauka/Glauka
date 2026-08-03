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
    Schema::create('ticket_entries', function (Blueprint $table) {
      $table->id();
      $table->foreignId('ticketdetalles_id')
        ->constrained()
        ->onDelete('cascade');
      $table->string('codigo')->unique();
      $table->timestamp('checked_at')->nullable();
      $table->foreignId('checked_by')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('ticket_entries');
  }
};
