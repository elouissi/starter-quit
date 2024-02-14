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
    Schema::create('design_maquettages', function (Blueprint $table) {
      $table->id();
      $table->foreignId('projet_id')->constrained()->onDelete('cascade');
      $table->string('StyleGraphique');
      $table->integer('NbPropositions')->default(1);
      $table->text('ExigencesGraphiques')->nullable();
      $table->text('ExemplesSites')->nullable();
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('design_maquettages');
  }
};
