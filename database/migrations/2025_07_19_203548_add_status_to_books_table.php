<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Ajouter le champ status avec les valeurs possibles
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('is_approved');
        });

        // Migrer les données existantes basées sur is_approved
        DB::table('books')->where('is_approved', true)->update(['status' => 'approved']);
        DB::table('books')->where('is_approved', false)->update(['status' => 'pending']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
