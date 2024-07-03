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
            $table->double('total_days', 8, 2)->nullable()->after('host_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facturations', function (Blueprint $table) {
            //
            $table->dropColumn('total_days');
        });
    }
};
