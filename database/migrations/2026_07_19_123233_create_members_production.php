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
    Schema::create('members_production', function (Blueprint $table) {
      $table->id();
      $table->foreignId('obra_id')->constrained('obras')->onDelete('cascade');
      $table->foreignId('label_id')->constrained('labels');
      $table->string('name');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('members_production');
  }
};
