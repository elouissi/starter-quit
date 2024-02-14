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
    Schema::create('gestion_projets', function (Blueprint $table) {
      $table->id();
      $table->foreignId('projet_id')->constrained()->onDelete('cascade');
      $table->string('MethodeGestion'); // As with enums, handle appropriately
      $table->text('Communication')->nullable();
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('gestion_projets');
  }
};
