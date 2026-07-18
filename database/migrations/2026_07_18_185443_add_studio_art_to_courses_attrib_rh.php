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
        Schema::table('courses_attrib_rh', function (Blueprint $table) {
            $table->integer('art1')->nullable()->default(null)->after('workshop3');
            $table->integer('art2')->nullable()->default(null)->after('art1');
            $table->integer('art3')->nullable()->default(null)->after('art2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses_attrib_rh', function (Blueprint $table) {
            $table->dropColumn('art1');
            $table->dropColumn('art2');
            $table->dropColumn('art3');
        });
    }
};
