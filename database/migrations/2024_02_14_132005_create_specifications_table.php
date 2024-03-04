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
    Schema::create('specifications', function (Blueprint $table) {
      $table->id();
      $table->string('entreprise_name');
      $table->string('has_website')->nullable();
      $table->string('website_domaine')->nullable();
      $table->string('contact_person');
      $table->string('phone');
      $table->string('email');
      $table->text('target')->nullable();
      $table->text('prompt_description')->nullable();
      $table->text('iatext_description')->nullable();
      $table->text('prompt_main_activities')->nullable();
      $table->text('iatext_main_activities')->nullable();
      $table->text('prompt_services_products')->nullable();
      $table->text('iatext_services_products')->nullable();
      $table->text('prompt_target_audience')->nullable();
      $table->text('iatext_target_audience')->nullable();
      $table->integer('step')->default(1);
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('entreprises');
  }
};
