<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HomepageContentController extends Controller
{
    /**
     * Display the homepage content management interface
     */
    public function index()
    {
        $settings = SiteSetting::getAllSettings();
        
        // Organiser les settings par sections
        $sections = [
            'navigation' => [
                'title' => 'Navigation',
                'settings' => [
                    'nav_menu_accueil' => 'Menu Accueil',
                    'nav_menu_bibliotheque' => 'Menu Bibliothèque',
                    'nav_menu_auteurs' => 'Menu Auteurs',
                    'nav_menu_apropos' => 'Menu À propos',
                    'nav_button_connexion' => 'Bouton Connexion',
                    'nav_button_inscription' => 'Bouton Inscription',
                    'nav_button_dashboard' => 'Bouton Dashboard',
                ]
            ],
            'hero' => [
                'title' => 'Section Hero',
                'settings' => [
                    'hero_welcome_text' => 'Texte d\'accueil',
                    'hero_search_placeholder' => 'Placeholder recherche',
                    'hero_search_button' => 'Bouton recherche',
                    'hero_cta_explorer' => 'Bouton Explorer',
                    'hero_cta_rejoindre' => 'Bouton Rejoindre',
                    'hero_stats_livres' => 'Label Livres',
                    'hero_stats_lecteurs' => 'Label Lecteurs',
                    'hero_stats_telechargements' => 'Label Téléchargements',
                    'hero_stats_auteurs' => 'Label Auteurs',
                ]
            ],
            'features' => [
                'title' => 'Fonctionnalités',
                'settings' => [
                    'features_title' => 'Titre section',
                    'features_subtitle' => 'Sous-titre section',
                    'feature1_title' => 'Titre fonctionnalité 1',
                    'feature1_description' => 'Description fonctionnalité 1',
                    'feature1_point1' => 'Point 1 fonctionnalité 1',
                    'feature1_point2' => 'Point 2 fonctionnalité 1',
                    'feature1_icon' => 'Icône fonctionnalité 1',
                    'feature1_color' => 'Couleur fonctionnalité 1',
                    'feature2_title' => 'Titre fonctionnalité 2',
                    'feature2_description' => 'Description fonctionnalité 2',
                    'feature2_point1' => 'Point 1 fonctionnalité 2',
                    'feature2_point2' => 'Point 2 fonctionnalité 2',
                    'feature2_icon' => 'Icône fonctionnalité 2',
                    'feature2_color' => 'Couleur fonctionnalité 2',
                    'feature3_title' => 'Titre fonctionnalité 3',
                    'feature3_description' => 'Description fonctionnalité 3',
                    'feature3_point1' => 'Point 1 fonctionnalité 3',
                    'feature3_point2' => 'Point 2 fonctionnalité 3',
                    'feature3_icon' => 'Icône fonctionnalité 3',
                    'feature3_color' => 'Couleur fonctionnalité 3',
                ]
            ],
            'books' => [
                'title' => 'Section Livres',
                'settings' => [
                    'books_section_title' => 'Titre section',
                    'books_filters_label' => 'Label filtres',
                    'books_filter_all_categories' => 'Option toutes catégories',
                    'books_filter_all_languages' => 'Option toutes langues',
                    'books_filter_author_placeholder' => 'Placeholder auteur',
                    'books_filter_clear' => 'Bouton effacer',
                    'books_tab_recent' => 'Onglet récents',
                    'books_tab_popular' => 'Onglet populaires',
                    'books_tab_viewed' => 'Onglet les plus vus',
                    'books_button_discover' => 'Bouton découvrir',
                    'books_button_preview' => 'Bouton aperçu',
                    'books_login_required' => 'Message connexion requise',
                    'books_no_results' => 'Message aucun résultat',
                    'books_no_results_subtitle' => 'Sous-titre aucun résultat',
                ]
            ],
            'testimonials' => [
                'title' => 'Témoignages',
                'settings' => [
                    'testimonials_title' => 'Titre section',
                    'testimonials_subtitle' => 'Sous-titre section',
                    'testimonial1_text' => 'Texte témoignage 1',
                    'testimonial1_name' => 'Nom témoignage 1',
                    'testimonial1_role' => 'Rôle témoignage 1',
                    'testimonial1_initials' => 'Initiales témoignage 1',
                    'testimonial1_color' => 'Couleur témoignage 1',
                    'testimonial2_text' => 'Texte témoignage 2',
                    'testimonial2_name' => 'Nom témoignage 2',
                    'testimonial2_role' => 'Rôle témoignage 2',
                    'testimonial2_initials' => 'Initiales témoignage 2',
                    'testimonial2_color' => 'Couleur témoignage 2',
                    'testimonial3_text' => 'Texte témoignage 3',
                    'testimonial3_name' => 'Nom témoignage 3',
                    'testimonial3_role' => 'Rôle témoignage 3',
                    'testimonial3_initials' => 'Initiales témoignage 3',
                    'testimonial3_color' => 'Couleur témoignage 3',
                ]
            ],
            'faq' => [
                'title' => 'FAQ',
                'settings' => [
                    'faq_title' => 'Titre section',
                    'faq_subtitle' => 'Sous-titre section',
                    'faq1_question' => 'Question 1',
                    'faq1_answer' => 'Réponse 1',
                    'faq2_question' => 'Question 2',
                    'faq2_answer' => 'Réponse 2',
                    'faq3_question' => 'Question 3',
                    'faq3_answer' => 'Réponse 3',
                    'faq4_question' => 'Question 4',
                    'faq4_answer' => 'Réponse 4',
                    'faq5_question' => 'Question 5',
                    'faq5_answer' => 'Réponse 5',
                    'faq_support_title' => 'Titre support',
                    'faq_support_subtitle' => 'Sous-titre support',
                    'faq_support_button' => 'Bouton support',
                ]
            ],
            'cta' => [
                'title' => 'Call-to-Action',
                'settings' => [
                    'cta_title' => 'Titre CTA',
                    'cta_subtitle' => 'Sous-titre CTA',
                    'cta_button_register' => 'Bouton créer compte',
                    'cta_button_explore' => 'Bouton explorer',
                    'cta_button_dashboard' => 'Bouton dashboard',
                    'cta_feature1_title' => 'Titre feature 1',
                    'cta_feature1_description' => 'Description feature 1',
                    'cta_feature2_title' => 'Titre feature 2',
                    'cta_feature2_description' => 'Description feature 2',
                    'cta_feature3_title' => 'Titre feature 3',
                    'cta_feature3_description' => 'Description feature 3',
                ]
            ],
            'newsletter' => [
                'title' => 'Newsletter',
                'settings' => [
                    'newsletter_title' => 'Titre newsletter',
                    'newsletter_subtitle' => 'Sous-titre newsletter',
                    'newsletter_placeholder' => 'Placeholder email',
                    'newsletter_button' => 'Bouton newsletter',
                    'newsletter_feature1' => 'Feature 1',
                    'newsletter_feature2' => 'Feature 2',
                    'newsletter_privacy' => 'Texte confidentialité',
                ]
            ],
            'simple_books' => [
                'title' => 'Section Livres Simple',
                'settings' => [
                    'simple_books_title' => 'Titre de la Section',
                    'simple_books_subtitle' => 'Sous-titre de la Section',
                    'simple_books_button' => 'Texte du Bouton',
                ]
            ],
            'simple_authors' => [
                'title' => 'Section Auteurs Simple',
                'settings' => [
                    'simple_authors_title' => 'Titre Principal (ex: "Auteurs Vedettes")',
                    'simple_authors_subtitle' => 'Description sous le titre (ex: "Découvrez nos meilleurs auteurs")',
                    'simple_authors_button' => 'Bouton sous chaque auteur (ex: "Voir les livres")',
                    'simple_authors_view_all' => 'Gros bouton en bas (ex: "Voir tous les auteurs")',
                ]
            ],
            'footer' => [
                'title' => 'Footer',
                'settings' => [
                    'footer_links_title' => 'Titre liens rapides',
                    'footer_link_library' => 'Lien bibliothèque',
                    'footer_link_search' => 'Lien recherche',
                    'footer_link_categories' => 'Lien catégories',
                    'footer_link_dashboard' => 'Lien dashboard',
                    'footer_link_login' => 'Lien connexion',
                    'footer_link_register' => 'Lien inscription',
                    'footer_support_title' => 'Titre support',
                    'footer_support_help' => 'Lien aide',
                    'footer_support_faq' => 'Lien FAQ',
                    'footer_support_contact' => 'Lien contact',
                    'footer_support_privacy' => 'Lien confidentialité',
                ]
            ]
        ];

        return view('admin.homepage-content.index', compact('settings', 'sections'));
    }

    /**
     * Update homepage content settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable|string|max:1000',
        ]);

        foreach ($validated['settings'] as $key => $value) {
            SiteSetting::set($key, $value);
        }

        return redirect()->route('admin.homepage-content.index')
            ->with('success', '✅ Contenu de la page d\'accueil mis à jour avec succès !');
    }
}
