<?php

use App\Models\Partner;
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
        $partner = Partner::where('name', '=', 'UPEC')
            ->where('end', '=', '0')
            ->first();
        $partner->end = '20252';
        $partner->save();

        $partner = Partner::where('name', '=', 'CIPh')
            ->where('end', '=', '0')
            ->first();
        $partner->end = '20252';
        $partner->save();

        $partner = Partner::where('name', '=', 'Sorbonne Université')
            ->first();
        $partner->order = 2;
        $partner->save();

        $partner = Partner::where('name', '=', 'Paris Cité')
            ->first();
        $partner->order = 3;
        $partner->save();

        $partner = new Partner();
        $partner->name = 'Université Paris Est Créteil (UPEC)';
        $partner->order = 4;
        $partner->date = 1;
        $partner->univreg = 1;
        $partner->start = '20261';
        $partner->end = 0;
        $partner->save();

        $partner = new Partner();
        $partner->name = 'Collège International de Philosophie (CIPh)';
        $partner->order = 5;
        $partner->date = 1;
        $partner->univreg = 1;
        $partner->start = '20261';
        $partner->end = 0;
        $partner->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $partner = Partner::where('name', '=', 'UPEC')
            ->where('end', '=', '20252')
            ->first();
        $partner->end = '0';
        $partner->save();

        $partner = Partner::where('name', '=', 'CIPh')
            ->where('end', '=', '20252')
            ->first();
        $partner->end = '0';
        $partner->save();

        $partner = Partner::where('name', '=', 'Sorbonne Université')
            ->first();
        $partner->order = 1;
        $partner->save();

        $partner = Partner::where('name', '=', 'Paris Cité')
            ->first();
        $partner->order = 1;
        $partner->save();

        $partner = Partner::where('name', '=', 'Université Paris Est Créteil (UPEC)')
            ->first();
        $partner->delete();

        $partner = Partner::where('name', '=', 'Collège International de Philosophie (CIPh)')
            ->first();
        $partner->delete();
    }
};
