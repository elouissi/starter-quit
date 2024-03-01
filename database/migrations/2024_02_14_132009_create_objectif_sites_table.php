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
      $table->longText('payment_options')->nullable();
      $table->longText('languages')->nullable();
      $table->text('target_keywords')->nullable();
      $table->text('iatext_target_keywords')->nullable();
      $table->text('prompt_iatext_target_keywords')->nullable();
      $table->longText('expected_functions')->nullable();
      $table->text('expected_objectives')->nullable();
      $table->text('expected_client_objectives')->nullable();
      $table->text('prompt_expected_client_objectives')->nullable();
      $table->text('menu')->nullable();
      $table->text('prompt_iatext_menu')->nullable();
      $table->text('iatext_menu')->nullable();
      $table->text('techniques_specs')->nullable();
      $table->text('prompt_iatext_techniques_specs')->nullable();
      $table->text('iatext_techniques_specs')->nullable();
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
