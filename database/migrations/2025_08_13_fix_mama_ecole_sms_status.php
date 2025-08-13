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
        // Modifier la colonne status pour accepter 'queued'
        DB::statement("ALTER TABLE mama_ecole_sms_logs MODIFY COLUMN status ENUM('pending', 'queued', 'sent', 'delivered', 'failed', 'undelivered', 'sending') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revenir à l'ancienne définition
        DB::statement("ALTER TABLE mama_ecole_sms_logs MODIFY COLUMN status ENUM('pending', 'sent', 'delivered', 'failed') DEFAULT 'pending'");
    }
};