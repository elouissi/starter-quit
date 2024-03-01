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
            // $table->string('content');
            $table->string('logo');
            $table->string('logo_file')->nullable();
            $table->string('graphical_charter');
            $table->string('graphical_charter_file')->nullable();
            $table->string('wireframe');
            $table->string('wireframe_file')->nullable();
            $table->string('typography');
            $table->text('typography_text')->nullable();
            $table->string('description_product_services');
            $table->string('description_product_services_file')->nullable();
            $table->longText('style_graphiques');
            $table->string('style_graphique_autre')->nullable();
            $table->integer('number_of_propositions');
            $table->text('color_palette');
            // $table->text('typography');
            $table->text('exemples_sites')->nullable();
            $table->longText('exemples_sites_files')->nullable();
            $table->text('prompt_iatext_exemples_sites')->nullable();
            $table->text('iatext_exemples_sites')->nullable();
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
