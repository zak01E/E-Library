<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class DiagnoseBooksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:diagnose {--fix : Supprimer les livres avec des fichiers manquants}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnostique les fichiers PDF manquants et optionnellement les supprime';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Diagnostic des fichiers PDF...');

        $books = Book::all();
        $missingFiles = [];
        $existingFiles = [];

        foreach ($books as $book) {
            if (Storage::disk('public')->exists($book->pdf_path)) {
                $existingFiles[] = $book;
                $this->line("✅ Livre #{$book->id}: {$book->title} - Fichier OK");
            } else {
                $missingFiles[] = $book;
                $this->error("❌ Livre #{$book->id}: {$book->title} - Fichier manquant: {$book->pdf_path}");
            }
        }

        $this->newLine();
        $this->info("📊 Résumé:");
        $this->info("   • Total des livres: " . $books->count());
        $this->info("   • Fichiers existants: " . count($existingFiles));
        $this->error("   • Fichiers manquants: " . count($missingFiles));

        if (count($missingFiles) > 0) {
            $this->newLine();
            $this->warn("⚠️  Des fichiers PDF sont manquants. Ces livres ne peuvent pas être téléchargés.");

            if ($this->option('fix')) {
                if ($this->confirm('Voulez-vous supprimer les livres avec des fichiers manquants de la base de données ?')) {
                    foreach ($missingFiles as $book) {
                        $book->delete();
                        $this->info("🗑️  Livre supprimé: #{$book->id} - {$book->title}");
                    }
                    $this->info("✅ " . count($missingFiles) . " livres supprimés de la base de données.");
                }
            } else {
                $this->info("💡 Utilisez --fix pour supprimer automatiquement les livres avec des fichiers manquants.");
            }
        } else {
            $this->info("🎉 Tous les fichiers PDF sont présents !");
        }

        return 0;
    }
}
