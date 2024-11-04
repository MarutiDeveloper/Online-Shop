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
        Schema::table('shipping_charges', function (Blueprint $table) {
            $table->string('state_id')->nullable()->after('country_id');
            $table->string('city_id')->nullable()->after('state_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipping_charges', function (Blueprint $table) {
            $table->dropColumn('state_id');
            $table->dropColumn('city_id');
        });
    }
};
