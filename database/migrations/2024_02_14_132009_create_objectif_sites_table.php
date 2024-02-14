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
      $table->foreignId('entreprise_id')->constrained();
      $table->text('ObjectifsAttendus');
      $table->string('Cible');
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
