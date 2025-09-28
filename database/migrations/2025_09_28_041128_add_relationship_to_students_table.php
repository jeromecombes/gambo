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
        Schema::table('students', function (Blueprint $table) {
            $table->mediumtext('relationship')->nullable()->after('contactemail');
            $table->mediumtext('frenchphone')->nullable()->after('cellphone');
            $table->mediumtext('whatsapp')->nullable()->after('frenchphone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('relationship');
            $table->dropColumn('frenchphone');
            $table->dropColumn('whatsapp');
        });
    }
};
