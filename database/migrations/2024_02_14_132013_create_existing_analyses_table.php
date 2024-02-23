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
        Schema::create('existing_analyses', function (Blueprint $table) {

            $table->id();
            $table->foreignId('specification_id')->onDelete('cascade');
            $table->text('competitors')->nullable();
            $table->text('sample_sites')->nullable();
            $table->json('sample_sites_files')->nullable();
            $table->text('constraints')->nullable();
            $table->json('constraints_files')->nullable();
            $table->string('domain')->nullable();
            $table->string('domain_name')->nullable();
            $table->string('logo')->nullable();
            $table->string('logo_file')->nullable();
            $table->string('hosting')->nullable();
            $table->string('hosting_name')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('existing_analyses');
    }
};
