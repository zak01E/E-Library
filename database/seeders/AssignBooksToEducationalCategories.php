<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class AssignBooksToEducationalCategories extends Seeder
{
    public function run()
    {
        // Désactiver temporairement les contraintes de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Mathématiques
        Book::where('title', 'LIKE', '%math%')
            ->orWhere('title', 'LIKE', '%algèbre%')
            ->orWhere('title', 'LIKE', '%géométrie%')
            ->orWhere('title', 'LIKE', '%calcul%')
            ->limit(200)
            ->update(['category' => 'Mathématiques']);

        // Français
        Book::where('title', 'LIKE', '%français%')
            ->orWhere('title', 'LIKE', '%grammaire%')
            ->orWhere('title', 'LIKE', '%conjugaison%')
            ->orWhere('title', 'LIKE', '%orthographe%')
            ->orWhere('category', 'Literature')
            ->limit(200)
            ->update(['category' => 'Français']);

        // Anglais
        Book::where('title', 'LIKE', '%english%')
            ->orWhere('title', 'LIKE', '%anglais%')
            ->orWhere('language', 'en')
            ->limit(150)
            ->update(['category' => 'Anglais']);

        // Histoire-Géographie
        Book::where('title', 'LIKE', '%histoire%')
            ->orWhere('title', 'LIKE', '%géographie%')
            ->orWhere('category', 'History')
            ->limit(200)
            ->update(['category' => 'Histoire-Géographie']);

        // Sciences Physiques
        Book::where('title', 'LIKE', '%physique%')
            ->orWhere('title', 'LIKE', '%chimie%')
            ->orWhere('title', 'LIKE', '%physics%')
            ->orWhere('title', 'LIKE', '%chemistry%')
            ->limit(150)
            ->update(['category' => 'Sciences Physiques']);

        // SVT
        Book::where('title', 'LIKE', '%biologie%')
            ->orWhere('title', 'LIKE', '%nature%')
            ->orWhere('title', 'LIKE', '%vie%')
            ->orWhere('title', 'LIKE', '%terre%')
            ->orWhere('category', 'Nature')
            ->limit(150)
            ->update(['category' => 'SVT']);

        // BAC
        Book::where('title', 'LIKE', '%bac%')
            ->orWhere('title', 'LIKE', '%baccalauréat%')
            ->orWhere('title', 'LIKE', '%terminale%')
            ->orWhere('title', 'LIKE', '%examen%')
            ->limit(100)
            ->update(['category' => 'BAC']);

        // BEPC
        Book::where('title', 'LIKE', '%bepc%')
            ->orWhere('title', 'LIKE', '%brevet%')
            ->orWhere('title', 'LIKE', '%3ème%')
            ->orWhere('title', 'LIKE', '%troisième%')
            ->limit(80)
            ->update(['category' => 'BEPC']);

        // CEPE
        Book::where('title', 'LIKE', '%cepe%')
            ->orWhere('title', 'LIKE', '%cm2%')
            ->orWhere('title', 'LIKE', '%primaire%')
            ->limit(80)
            ->update(['category' => 'CEPE']);

        // Primaire
        Book::where('title', 'LIKE', '%cp%')
            ->orWhere('title', 'LIKE', '%ce1%')
            ->orWhere('title', 'LIKE', '%ce2%')
            ->orWhere('title', 'LIKE', '%cm1%')
            ->orWhere('title', 'LIKE', '%primaire%')
            ->orWhere('level', 'primaire')
            ->limit(300)
            ->update(['category' => 'Primaire']);

        // Collège
        Book::where('title', 'LIKE', '%6ème%')
            ->orWhere('title', 'LIKE', '%5ème%')
            ->orWhere('title', 'LIKE', '%4ème%')
            ->orWhere('title', 'LIKE', '%collège%')
            ->orWhere('level', 'college')
            ->limit(250)
            ->update(['category' => 'Collège']);

        // Lycée
        Book::where('title', 'LIKE', '%seconde%')
            ->orWhere('title', 'LIKE', '%première%')
            ->orWhere('title', 'LIKE', '%terminale%')
            ->orWhere('title', 'LIKE', '%lycée%')
            ->orWhere('level', 'lycee')
            ->limit(250)
            ->update(['category' => 'Lycée']);

        // Supérieur
        Book::where('title', 'LIKE', '%université%')
            ->orWhere('title', 'LIKE', '%licence%')
            ->orWhere('title', 'LIKE', '%master%')
            ->orWhere('title', 'LIKE', '%doctorat%')
            ->orWhere('title', 'LIKE', '%thèse%')
            ->orWhere('level', 'superieur')
            ->limit(200)
            ->update(['category' => 'Supérieur']);

        // Économie-Gestion
        Book::where('category', 'Economics')
            ->orWhere('category', 'Business')
            ->orWhere('title', 'LIKE', '%gestion%')
            ->orWhere('title', 'LIKE', '%management%')
            ->limit(150)
            ->update(['category' => 'Économie-Gestion']);

        // Concours
        Book::where('title', 'LIKE', '%concours%')
            ->orWhere('title', 'LIKE', '%préparation%')
            ->orWhere('title', 'LIKE', '%QCM%')
            ->limit(100)
            ->update(['category' => 'Concours']);

        // Histoire de Côte d'Ivoire
        Book::where('title', 'LIKE', '%côte%ivoire%')
            ->orWhere('title', 'LIKE', '%ivoir%')
            ->orWhere('title', 'LIKE', '%abidjan%')
            ->orWhere('description', 'LIKE', '%côte%ivoire%')
            ->limit(50)
            ->update(['category' => 'Histoire de Côte d\'Ivoire']);

        // Culture Ivoirienne
        Book::where('title', 'LIKE', '%tradition%')
            ->orWhere('title', 'LIKE', '%culture%afric%')
            ->orWhere('title', 'LIKE', '%conte%afric%')
            ->limit(50)
            ->update(['category' => 'Culture Ivoirienne']);

        // Méthodologie
        Book::where('title', 'LIKE', '%méthod%')
            ->orWhere('title', 'LIKE', '%apprendre%')
            ->orWhere('title', 'LIKE', '%révision%')
            ->orWhere('title', 'LIKE', '%technique%étude%')
            ->limit(80)
            ->update(['category' => 'Méthodologie']);

        // Orientation
        Book::where('title', 'LIKE', '%orientation%')
            ->orWhere('title', 'LIKE', '%carrière%')
            ->orWhere('title', 'LIKE', '%métier%')
            ->orWhere('title', 'LIKE', '%profession%')
            ->limit(80)
            ->update(['category' => 'Orientation']);

        // Professionnel
        Book::where('title', 'LIKE', '%professionnel%')
            ->orWhere('title', 'LIKE', '%technique%')
            ->orWhere('title', 'LIKE', '%pratique%')
            ->orWhere('category', 'Technology')
            ->limit(150)
            ->update(['category' => 'Professionnel']);

        // Parascolaire
        Book::where('title', 'LIKE', '%jeu%')
            ->orWhere('title', 'LIKE', '%loisir%')
            ->orWhere('title', 'LIKE', '%activité%')
            ->orWhere('title', 'LIKE', '%vacances%')
            ->limit(100)
            ->update(['category' => 'Parascolaire']);

        // Manuels MENET-FP (simulation avec des livres Education)
        Book::where('category', 'Education')
            ->limit(50)
            ->update(['category' => 'Manuels MENET-FP']);

        // Programme Officiel
        Book::where('title', 'LIKE', '%programme%')
            ->orWhere('title', 'LIKE', '%curriculum%')
            ->orWhere('title', 'LIKE', '%officiel%')
            ->limit(30)
            ->update(['category' => 'Programme Officiel']);

        // Langues Locales
        Book::where('language', 'LIKE', '%baoule%')
            ->orWhere('language', 'LIKE', '%dioula%')
            ->orWhere('language', 'LIKE', '%senoufo%')
            ->orWhere('title', 'LIKE', '%langue%afric%')
            ->limit(30)
            ->update(['category' => 'Langues Locales']);

        // Réactiver les contraintes
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        echo "Attribution des livres aux catégories éducatives terminée!\n";
    }
}