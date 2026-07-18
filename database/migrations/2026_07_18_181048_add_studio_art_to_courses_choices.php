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
        Schema::table('courses_choices', function (Blueprint $table) {
            $table->integer('a4')->nullable()->default(null)->after('e2');
            $table->integer('b4')->nullable()->default(null)->after('a4');
            $table->integer('c4')->nullable()->default(null)->after('b4');
            $table->integer('d4')->nullable()->default(null)->after('c4');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses_choices', function (Blueprint $table) {
            $table->dropColumn('a4');
            $table->dropColumn('b4');
            $table->dropColumn('c4');
            $table->dropColumn('d4');
        });
    }
};
