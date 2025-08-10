<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Site de base
            [
                'key' => 'site_name',
                'value' => 'E-Library',
                'type' => 'text',
                'description' => 'Nom du site affiché dans le titre et la navigation'
            ],
            [
                'key' => 'site_logo',
                'value' => null,
                'type' => 'image',
                'description' => 'Logo principal du site (format recommandé: PNG, 200x60px)'
            ],
            [
                'key' => 'site_favicon',
                'value' => null,
                'type' => 'image',
                'description' => 'Icône du site (favicon) - format ICO ou PNG 32x32px'
            ],
            [
                'key' => 'site_logo_dark',
                'value' => null,
                'type' => 'image',
                'description' => 'Logo pour le mode sombre (optionnel)'
            ],
            [
                'key' => 'site_description',
                'value' => 'Votre bibliothèque numérique moderne',
                'type' => 'text',
                'description' => 'Description courte du site'
            ],
            [
                'key' => 'admin_logo',
                'value' => null,
                'type' => 'image',
                'description' => 'Logo pour l\'interface d\'administration'
            ],

            // Navigation
            [
                'key' => 'nav_menu_accueil',
                'value' => 'Accueil',
                'type' => 'text',
                'description' => 'Texte du menu Accueil'
            ],
            [
                'key' => 'nav_menu_bibliotheque',
                'value' => 'Bibliothèque',
                'type' => 'text',
                'description' => 'Texte du menu Bibliothèque'
            ],
            [
                'key' => 'nav_menu_auteurs',
                'value' => 'Auteurs',
                'type' => 'text',
                'description' => 'Texte du menu Auteurs'
            ],
            [
                'key' => 'nav_menu_apropos',
                'value' => 'À propos',
                'type' => 'text',
                'description' => 'Texte du menu À propos'
            ],
            [
                'key' => 'nav_button_connexion',
                'value' => 'Connexion',
                'type' => 'text',
                'description' => 'Texte du bouton Connexion'
            ],
            [
                'key' => 'nav_button_inscription',
                'value' => 'S\'inscrire',
                'type' => 'text',
                'description' => 'Texte du bouton Inscription'
            ],
            [
                'key' => 'nav_button_dashboard',
                'value' => 'Dashboard',
                'type' => 'text',
                'description' => 'Texte du bouton Dashboard'
            ],

            // Section Hero
            [
                'key' => 'hero_welcome_text',
                'value' => 'Bienvenue sur',
                'type' => 'text',
                'description' => 'Texte d\'accueil dans le hero'
            ],
            [
                'key' => 'hero_search_placeholder',
                'value' => 'Rechercher un livre...',
                'type' => 'text',
                'description' => 'Placeholder de la barre de recherche'
            ],
            [
                'key' => 'hero_search_button',
                'value' => 'Rechercher',
                'type' => 'text',
                'description' => 'Texte du bouton de recherche'
            ],
            [
                'key' => 'hero_cta_explorer',
                'value' => 'Explorer la Bibliothèque',
                'type' => 'text',
                'description' => 'Texte du bouton Explorer'
            ],
            [
                'key' => 'hero_cta_rejoindre',
                'value' => 'Rejoindre',
                'type' => 'text',
                'description' => 'Texte du bouton Rejoindre'
            ],
            [
                'key' => 'hero_stats_livres',
                'value' => 'Livres',
                'type' => 'text',
                'description' => 'Label des statistiques livres'
            ],
            [
                'key' => 'hero_stats_lecteurs',
                'value' => 'Lecteurs',
                'type' => 'text',
                'description' => 'Label des statistiques lecteurs'
            ],
            [
                'key' => 'hero_stats_telechargements',
                'value' => 'Téléchargements',
                'type' => 'text',
                'description' => 'Label des statistiques téléchargements'
            ],
            [
                'key' => 'hero_stats_auteurs',
                'value' => 'Auteurs',
                'type' => 'text',
                'description' => 'Label des statistiques auteurs'
            ],

            // Section Fonctionnalités
            [
                'key' => 'features_title',
                'value' => 'Nos Fonctionnalités',
                'type' => 'text',
                'description' => 'Titre de la section fonctionnalités'
            ],
            [
                'key' => 'features_subtitle',
                'value' => 'Découvrez ce qui rend notre bibliothèque numérique unique',
                'type' => 'text',
                'description' => 'Sous-titre de la section fonctionnalités'
            ],

            // Feature 1 - Lecture
            [
                'key' => 'feature1_title',
                'value' => 'Lecture Simple',
                'type' => 'text',
                'description' => 'Titre de la fonctionnalité 1'
            ],
            [
                'key' => 'feature1_description',
                'value' => 'Lisez vos livres préférés avec notre lecteur intégré et intuitif.',
                'type' => 'text',
                'description' => 'Description de la fonctionnalité 1'
            ],
            [
                'key' => 'feature1_point1',
                'value' => 'Lecteur PDF intégré',
                'type' => 'text',
                'description' => 'Premier point de la fonctionnalité 1'
            ],
            [
                'key' => 'feature1_point2',
                'value' => 'Mode sombre/clair',
                'type' => 'text',
                'description' => 'Deuxième point de la fonctionnalité 1'
            ],
            [
                'key' => 'feature1_icon',
                'value' => 'fas fa-book-reader',
                'type' => 'text',
                'description' => 'Icône de la fonctionnalité 1'
            ],
            [
                'key' => 'feature1_color',
                'value' => 'emerald',
                'type' => 'text',
                'description' => 'Couleur de la fonctionnalité 1'
            ],

            // Feature 2 - Publication
            [
                'key' => 'feature2_title',
                'value' => 'Publication',
                'type' => 'text',
                'description' => 'Titre de la fonctionnalité 2'
            ],
            [
                'key' => 'feature2_description',
                'value' => 'Publiez vos œuvres facilement et partagez-les avec la communauté.',
                'type' => 'text',
                'description' => 'Description de la fonctionnalité 2'
            ],
            [
                'key' => 'feature2_point1',
                'value' => 'Upload simple',
                'type' => 'text',
                'description' => 'Premier point de la fonctionnalité 2'
            ],
            [
                'key' => 'feature2_point2',
                'value' => 'Validation rapide',
                'type' => 'text',
                'description' => 'Deuxième point de la fonctionnalité 2'
            ],
            [
                'key' => 'feature2_icon',
                'value' => 'fas fa-pen-fancy',
                'type' => 'text',
                'description' => 'Icône de la fonctionnalité 2'
            ],
            [
                'key' => 'feature2_color',
                'value' => 'green',
                'type' => 'text',
                'description' => 'Couleur de la fonctionnalité 2'
            ],

            // Feature 3 - Recherche
            [
                'key' => 'feature3_title',
                'value' => 'Recherche',
                'type' => 'text',
                'description' => 'Titre de la fonctionnalité 3'
            ],
            [
                'key' => 'feature3_description',
                'value' => 'Trouvez rapidement vos livres préférés.',
                'type' => 'text',
                'description' => 'Description de la fonctionnalité 3'
            ],
            [
                'key' => 'feature3_point1',
                'value' => 'Recherche par titre',
                'type' => 'text',
                'description' => 'Premier point de la fonctionnalité 3'
            ],
            [
                'key' => 'feature3_point2',
                'value' => 'Filtres par catégorie',
                'type' => 'text',
                'description' => 'Deuxième point de la fonctionnalité 3'
            ],
            [
                'key' => 'feature3_icon',
                'value' => 'fas fa-search',
                'type' => 'text',
                'description' => 'Icône de la fonctionnalité 3'
            ],
            [
                'key' => 'feature3_color',
                'value' => 'orange',
                'type' => 'text',
                'description' => 'Couleur de la fonctionnalité 3'
            ],

            // Section Livres
            [
                'key' => 'books_section_title',
                'value' => 'Découvrez nos Livres',
                'type' => 'text',
                'description' => 'Titre de la section livres'
            ],
            [
                'key' => 'books_filters_label',
                'value' => 'Filtres:',
                'type' => 'text',
                'description' => 'Label des filtres'
            ],
            [
                'key' => 'books_filter_all_categories',
                'value' => '📚 Toutes catégories',
                'type' => 'text',
                'description' => 'Option toutes catégories'
            ],
            [
                'key' => 'books_filter_all_languages',
                'value' => '🌍 Toutes langues',
                'type' => 'text',
                'description' => 'Option toutes langues'
            ],
            [
                'key' => 'books_filter_author_placeholder',
                'value' => '👤 Rechercher un auteur...',
                'type' => 'text',
                'description' => 'Placeholder recherche auteur'
            ],
            [
                'key' => 'books_filter_clear',
                'value' => 'Effacer',
                'type' => 'text',
                'description' => 'Bouton effacer filtres'
            ],
            [
                'key' => 'books_tab_recent',
                'value' => 'Récents',
                'type' => 'text',
                'description' => 'Onglet livres récents'
            ],
            [
                'key' => 'books_tab_popular',
                'value' => 'Populaires',
                'type' => 'text',
                'description' => 'Onglet livres populaires'
            ],
            [
                'key' => 'books_tab_viewed',
                'value' => 'Les plus vus',
                'type' => 'text',
                'description' => 'Onglet livres les plus vus'
            ],
            [
                'key' => 'books_button_discover',
                'value' => 'Découvrir',
                'type' => 'text',
                'description' => 'Bouton découvrir livre'
            ],
            [
                'key' => 'books_button_preview',
                'value' => 'Aperçu',
                'type' => 'text',
                'description' => 'Bouton aperçu livre'
            ],
            [
                'key' => 'books_login_required',
                'value' => 'Connexion requise',
                'type' => 'text',
                'description' => 'Message connexion requise'
            ],
            [
                'key' => 'books_no_results',
                'value' => 'Aucun livre trouvé',
                'type' => 'text',
                'description' => 'Message aucun résultat'
            ],
            [
                'key' => 'books_no_results_subtitle',
                'value' => 'Essayez de modifier vos critères de recherche',
                'type' => 'text',
                'description' => 'Sous-titre aucun résultat'
            ]
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
