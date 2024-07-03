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
        Schema::table('deadlines_and_budgets', function (Blueprint $table) {
            //
            $table->string('budget_from')->nullable()->change();
            $table->string('budget_to')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deadlines_and_budgets', function (Blueprint $table) {
            //
            $table->string('budget_from')->nullable(false)->change();
            $table->string('budget_to')->nullable(false)->change();
        });
    }
};
