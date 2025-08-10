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
        // Modifier la colonne status pour inclure les nouveaux statuts
        DB::statement("ALTER TABLE books MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'under_review', 'suspended') DEFAULT 'pending'");

        Schema::table('books', function (Blueprint $table) {
            // Ajouter des colonnes pour le système amélioré
            $table->text('status_reason')->nullable()->after('status'); // Raison du changement de statut
            $table->timestamp('status_changed_at')->nullable()->after('status_reason'); // Date du changement
            $table->unsignedBigInteger('status_changed_by')->nullable()->after('status_changed_at'); // Qui a changé le statut
            $table->boolean('is_public')->default(true)->after('status_changed_by'); // Visibilité publique

            // Index pour les performances
            $table->index(['status', 'is_public']);
            $table->index('status_changed_at');

            // Clé étrangère pour qui a changé le statut
            $table->foreign('status_changed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['status_changed_by']);
            $table->dropIndex(['status', 'is_public']);
            $table->dropIndex(['status_changed_at']);
            $table->dropColumn(['status_reason', 'status_changed_at', 'status_changed_by', 'is_public']);
        });

        // Remettre l'ancien enum
        DB::statement("ALTER TABLE books MODIFY COLUMN status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");
    }
};
