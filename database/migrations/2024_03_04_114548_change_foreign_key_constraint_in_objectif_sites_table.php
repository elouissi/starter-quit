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
    Schema::table('objectif_sites', function (Blueprint $table) {
      //
      $table->dropForeign(['specification_id']);
      $table->foreign('specification_id')->references('id')->on('specifications')->onDelete('cascade'); // Add the new foreign key constraint
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('objectif_sites', function (Blueprint $table) {
      //
    });
  }
};