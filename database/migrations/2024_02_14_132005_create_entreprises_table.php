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
    Schema::create('entreprises', function (Blueprint $table) {
      $table->id();
      $table->string('Nom');
      $table->string('PersonneContact');
      $table->string('Telephone');
      $table->string('Email')->unique();
      $table->text('Description')->nullable();
      $table->text('ActivitesPrincipales')->nullable();
      $table->text('ServicesProduits')->nullable();
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
