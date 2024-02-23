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
    Schema::create('objectif_sites', function (Blueprint $table) {
      $table->id();
      $table->foreignId('specification_id')->constrained();
      $table->string('project_need')->nullable();
      $table->string('project_type')->nullable();
      $table->json('payment_options')->nullable();
      $table->json('languages')->nullable();
      $table->text('target_keywords')->nullable();
      $table->json('expected_functions')->nullable();
      $table->text('expected_objectives')->nullable();
      $table->string('menu')->nullable();
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('objectif_sites');
  }
};
