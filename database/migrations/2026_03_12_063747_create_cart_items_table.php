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
    Schema::create('cart_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('cart_id')->constrained()->onDelete('cascade');
      $table->foreignId('obra_id')->constrained()->onDelete('cascade');
      $table->foreignId('performance_id')->constrained()->onDelete('cascade');
      $table->integer('cantidad');
      $table->json('emails_virtuales')->nullable();
      $table->boolean('stock_alert_sent')->default(false);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('cart_items');
  }
};
