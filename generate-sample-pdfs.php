<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use Illuminate\Support\Facades\Storage;

$books = Book::all();
$created = 0;
$skipped = 0;

foreach ($books as $book) {
    $pdfPath = $book->pdf_path;
    
    // Vérifier si le fichier existe déjà
    if (Storage::disk('public')->exists($pdfPath)) {
        $skipped++;
        echo "✓ Skipped (exists): Book #{$book->id} - {$book->title}\n";
        continue;
    }
    
    // Créer le répertoire si nécessaire
    $dir = dirname($pdfPath);
    if (!Storage::disk('public')->exists($dir)) {
        Storage::disk('public')->makeDirectory($dir);
    }
    
    // Générer un PDF simple avec le titre du livre
    $title = substr($book->title, 0, 50); // Limiter la longueur du titre
    $author = substr($book->author_name, 0, 40);
    $category = $book->category ?? 'Non catégorisé';
    $description = wordwrap($book->description ?? 'Pas de description disponible.', 70);
    
    $pdfContent = "%PDF-1.4
1 0 obj
<< /Type /Catalog /Pages 2 0 R >>
endobj
2 0 obj
<< /Type /Pages /Kids [3 0 R] /Count 1 >>
endobj
3 0 obj
<< /Type /Page /Parent 2 0 R /Resources << /Font << /F1 << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> >> >> /MediaBox [0 0 612 792] /Contents 4 0 R >>
endobj
4 0 obj
<< /Length 500 >>
stream
BT
/F1 20 Tf
50 700 Td
($title) Tj
0 -30 Td
/F1 14 Tf
(Par: $author) Tj
0 -20 Td
(Categorie: $category) Tj
0 -40 Td
/F1 12 Tf
(Description:) Tj
0 -20 Td
($description) Tj
0 -40 Td
/F1 10 Tf
(Ceci est un fichier PDF de demonstration pour l'E-Library.) Tj
0 -20 Td
(Le contenu reel du livre sera disponible prochainement.) Tj
ET
endstream
endobj
xref
0 5
0000000000 65535 f 
0000000009 00000 n 
0000000058 00000 n 
0000000115 00000 n 
0000000274 00000 n 
trailer
<< /Size 5 /Root 1 0 R >>
startxref
800
%%EOF";
    
    // Sauvegarder le PDF
    Storage::disk('public')->put($pdfPath, $pdfContent);
    $created++;
    echo "✓ Created: Book #{$book->id} - {$book->title} -> {$pdfPath}\n";
}

echo "\n=== RÉSUMÉ ===\n";
echo "PDFs créés: $created\n";
echo "PDFs existants (ignorés): $skipped\n";
echo "Total de livres traités: " . ($created + $skipped) . "\n";