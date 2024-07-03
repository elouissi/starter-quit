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
        Schema::table('facturations', function (Blueprint $table) {
            //
            $table->float('number_of_days_installation_environment')->change()->nullable();
            $table->float('number_of_days_integration_structure')->change()->nullable();
            $table->float('number_of_days_draft_texts_translations')->change()->nullable();
            $table->float('number_of_days_graphic_modeling')->change()->nullable();
            $table->float('number_of_days_web_development_integrations')->change()->nullable();
            $table->float('number_of_days_text_image_integration')->change()->nullable();
            $table->float('number_of_days_other_pages_integration')->change()->nullable();
            $table->float('number_of_days_mobile_version_optimization')->change()->nullable();
            $table->float('number_of_days_multilingual_integration')->change()->nullable();
            $table->float('number_of_days_seo_optimisation')->change()->nullable();
            $table->float('number_of_days_testing_tracking')->change()->nullable();
            $table->float('number_of_days_project_management')->change()->nullable();
            $table->float('installment_1_percentage')->change()->nullable();
            $table->float('installment_2_percentage')->change()->nullable();
            $table->float('installment_3_percentage')->change()->nullable();
            $table->float('installment_4_percentage')->change()->nullable();
            $table->float('installment_5_percentage')->change()->nullable();
            $table->float('installment_6_percentage')->change()->nullable();
            $table->float('installment_7_percentage')->change()->nullable();
            $table->float('installment_8_percentage')->change()->nullable();
            $table->float('installment_9_percentage')->change()->nullable();
            $table->float('installment_10_percentage')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facturations', function (Blueprint $table) {
            //
        });
    }
};
