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
    Schema::create('projets', function (Blueprint $table) {
      $table->id();
      $table->foreignId('entreprise_id')->onDelete('cascade');
      $table->string('RefonteCreation'); // Consider using a check constraint or handle it in your application logic
      $table->string('TypeSite'); // Same as above for enum handling
      $table->text('Fonctions')->nullable();
      $table->boolean('Paiement');
      $table->boolean('Multilingue');
      $table->text('SpecificitesTechniques')->nullable();
      $table->integer('NbProduitsServices')->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('projets');
  }
};
