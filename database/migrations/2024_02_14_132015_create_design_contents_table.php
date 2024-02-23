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
        Schema::create('design_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specification_id')->onDelete('cascade');
            $table->string('content');
            $table->json('style_graphiques');
            $table->string('style_graphique_autre')->nullable();
            $table->integer('number_of_propositions');
            $table->text('color_palette');
            $table->text('typography');
            $table->text('exemples_sites')->nullable();
            $table->json('exemples_sites_files')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_contents');
    }
};
