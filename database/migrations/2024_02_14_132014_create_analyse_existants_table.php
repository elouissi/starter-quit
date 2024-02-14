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
    Schema::create('analyse_existants', function (Blueprint $table) {
      $table->id();
      $table->foreignId('entreprise_id')->onDelete('cascade');
      $table->text('Concurrents')->nullable();
      $table->text('Contraintes')->nullable();
      $table->string('NomDomaine')->nullable();
      $table->string('Hebergement')->nullable();
      $table->string('Logo')->nullable();
      $table->text('Menu')->nullable();
      $table->text('ContenuSite')->nullable();
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('analyse_existants');
  }
};
