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
    Schema::create('planning_projets', function (Blueprint $table) {
      $table->id();
      $table->foreignId('projet_id')->constrained()->onDelete('cascade');
      $table->date('Delais');
      $table->decimal('Budget', 15, 2);
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('planning_projets');
  }
};
