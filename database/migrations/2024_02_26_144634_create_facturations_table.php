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
    Schema::create('facturations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('specification_id')->onDelete('cascade');
      $table->unsignedInteger('number_of_days_installation_environment')->nullable();
      $table->float('unit_amount_installation_environment')->nullable();
      $table->float('total_installation_environment')->nullable();
      $table->unsignedInteger('number_of_days_integration_structure')->nullable();
      $table->float('unit_amount_integration_structure')->nullable();
      $table->float('total_integration_structure')->nullable();
      $table->unsignedInteger('number_of_days_draft_texts_translations')->nullable();
      $table->float('unit_amount_draft_texts_translations')->nullable();
      $table->float('total_draft_texts_translations')->nullable();
      $table->unsignedInteger('number_of_days_graphic_modeling')->nullable();
      $table->float('unit_amount_graphic_modeling')->nullable();
      $table->float('total_graphic_modeling')->nullable();
      $table->unsignedInteger('number_of_days_web_development_integrations')->nullable();
      $table->float('unit_amount_web_development_integrations')->nullable();
      $table->float('total_web_development_integrations')->nullable();
      $table->unsignedInteger('number_of_days_text_image_integration')->nullable();
      $table->float('unit_amount_text_image_integration')->nullable();
      $table->float('total_text_image_integration')->nullable();
      $table->unsignedInteger('number_of_days_other_pages_integration')->nullable();
      $table->float('unit_amount_other_pages_integration')->nullable();
      $table->float('total_other_pages_integration')->nullable();
      $table->unsignedInteger('number_of_days_mobile_version_optimization')->nullable();
      $table->float('unit_amount_mobile_version_optimization')->nullable();
      $table->float('total_mobile_version_optimization')->nullable();
      $table->unsignedInteger('number_of_days_multilingual_integration')->nullable();
      $table->float('unit_amount_multilingual_integration')->nullable();
      $table->float('total_multilingual_integration')->nullable();
      $table->unsignedInteger('number_of_days_seo_optimisation')->nullable();
      $table->float('unit_amount_seo_optimisation')->nullable();
      $table->float('total_seo_optimisation')->nullable();
      $table->unsignedInteger('number_of_days_testing_tracking')->nullable();
      $table->float('unit_amount_testing_tracking')->nullable();
      $table->float('total_testing_tracking')->nullable();
      $table->unsignedInteger('number_of_days_project_management')->nullable();
      $table->float('unit_amount_project_management')->nullable();
      $table->float('total_project_management')->nullable();
      $table->float('exceptional_discount')->nullable();
      $table->float('total')->nullable();
      $table->float('rest')->nullable();
      $table->unsignedInteger('installment_1_percentage')->nullable();
      $table->float('installment_1_amount')->nullable();
      $table->string('installment_1_title')->nullable();
      $table->unsignedInteger('installment_2_percentage')->nullable();
      $table->float('installment_2_amount')->nullable();
      $table->string('installment_2_title')->nullable();
      $table->unsignedInteger('installment_3_percentage')->nullable();
      $table->float('installment_3_amount')->nullable();
      $table->string('installment_3_title')->nullable();
      $table->unsignedInteger('installment_4_percentage')->nullable();
      $table->float('installment_4_amount')->nullable();
      $table->string('installment_4_title')->nullable();
      $table->unsignedInteger('installment_5_percentage')->nullable();
      $table->float('installment_5_amount')->nullable();
      $table->string('installment_5_title')->nullable();
      $table->unsignedInteger('installment_6_percentage')->nullable();
      $table->float('installment_6_amount')->nullable();
      $table->string('installment_6_title')->nullable();
      $table->unsignedInteger('installment_7_percentage')->nullable();
      $table->float('installment_7_amount')->nullable();
      $table->string('installment_7_title')->nullable();
      $table->unsignedInteger('installment_8_percentage')->nullable();
      $table->float('installment_8_amount')->nullable();
      $table->string('installment_8_title')->nullable();
      $table->unsignedInteger('installment_9_percentage')->nullable();
      $table->float('installment_9_amount')->nullable();
      $table->string('installment_9_title')->nullable();
      $table->unsignedInteger('installment_10_percentage')->nullable();
      $table->float('installment_10_amount')->nullable();
      $table->string('installment_10_title')->nullable();
      $table->unsignedInteger('maintenance_percentage')->nullable();
      $table->float('maintenance_amount')->nullable();
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('facturations');
  }
};
