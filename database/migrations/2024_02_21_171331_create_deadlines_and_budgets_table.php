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
    Schema::create('deadlines_and_budgets', function (Blueprint $table) {
      $table->id();
      $table->foreignId('specification_id')->onDelete('cascade');
      $table->string('gestion_projet');
      $table->longText('communication');
      $table->string('deadline');
      $table->float('budget_from');
      $table->float('budget_to');
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('deadlines_and_budgets');
  }
};
