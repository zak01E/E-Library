<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomepageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Section Témoignages
            [
                'key' => 'testimonials_title',
                'value' => 'Ce que disent nos utilisateurs',
                'type' => 'text',
                'description' => 'Titre de la section témoignages'
            ],
            [
                'key' => 'testimonials_subtitle',
                'value' => 'Découvrez les retours de notre communauté',
                'type' => 'text',
                'description' => 'Sous-titre de la section témoignages'
            ],

            // Témoignage 1
            [
                'key' => 'testimonial1_text',
                'value' => 'E-Library a révolutionné ma façon de lire. L\'interface est intuitive et la qualité des livres exceptionnelle. Je recommande vivement !',
                'type' => 'textarea',
                'description' => 'Texte du témoignage 1'
            ],
            [
                'key' => 'testimonial1_name',
                'value' => 'Sophie Martin',
                'type' => 'text',
                'description' => 'Nom du témoignage 1'
            ],
            [
                'key' => 'testimonial1_role',
                'value' => 'Lectrice passionnée',
                'type' => 'text',
                'description' => 'Rôle du témoignage 1'
            ],
            [
                'key' => 'testimonial1_initials',
                'value' => 'SM',
                'type' => 'text',
                'description' => 'Initiales du témoignage 1'
            ],
            [
                'key' => 'testimonial1_color',
                'value' => 'blue',
                'type' => 'text',
                'description' => 'Couleur du témoignage 1'
            ],

            // Témoignage 2
            [
                'key' => 'testimonial2_text',
                'value' => 'En tant qu\'auteur, publier mes livres sur E-Library a été un jeu d\'enfant. Les outils d\'analytics m\'aident à comprendre mon audience.',
                'type' => 'textarea',
                'description' => 'Texte du témoignage 2'
            ],
            [
                'key' => 'testimonial2_name',
                'value' => 'Jean Dubois',
                'type' => 'text',
                'description' => 'Nom du témoignage 2'
            ],
            [
                'key' => 'testimonial2_role',
                'value' => 'Auteur publié',
                'type' => 'text',
                'description' => 'Rôle du témoignage 2'
            ],
            [
                'key' => 'testimonial2_initials',
                'value' => 'JD',
                'type' => 'text',
                'description' => 'Initiales du témoignage 2'
            ],
            [
                'key' => 'testimonial2_color',
                'value' => 'green',
                'type' => 'text',
                'description' => 'Couleur du témoignage 2'
            ],

            // Témoignage 3
            [
                'key' => 'testimonial3_text',
                'value' => 'Interface simple et efficace. Je trouve facilement mes livres préférés.',
                'type' => 'textarea',
                'description' => 'Texte du témoignage 3'
            ],
            [
                'key' => 'testimonial3_name',
                'value' => 'Alice Leroy',
                'type' => 'text',
                'description' => 'Nom du témoignage 3'
            ],
            [
                'key' => 'testimonial3_role',
                'value' => 'Étudiante',
                'type' => 'text',
                'description' => 'Rôle du témoignage 3'
            ],
            [
                'key' => 'testimonial3_initials',
                'value' => 'AL',
                'type' => 'text',
                'description' => 'Initiales du témoignage 3'
            ],
            [
                'key' => 'testimonial3_color',
                'value' => 'gray',
                'type' => 'text',
                'description' => 'Couleur du témoignage 3'
            ],

            // Section FAQ
            [
                'key' => 'faq_title',
                'value' => 'Questions Fréquentes',
                'type' => 'text',
                'description' => 'Titre de la section FAQ'
            ],
            [
                'key' => 'faq_subtitle',
                'value' => 'Trouvez rapidement les réponses à vos questions',
                'type' => 'text',
                'description' => 'Sous-titre de la section FAQ'
            ],

            // FAQ 1
            [
                'key' => 'faq1_question',
                'value' => 'Comment puis-je télécharger un livre ?',
                'type' => 'text',
                'description' => 'Question FAQ 1'
            ],
            [
                'key' => 'faq1_answer',
                'value' => 'Pour télécharger un livre, il suffit de cliquer sur le bouton "Télécharger" sur la page du livre. Vous devez être connecté à votre compte pour accéder aux téléchargements.',
                'type' => 'textarea',
                'description' => 'Réponse FAQ 1'
            ],

            // FAQ 2
            [
                'key' => 'faq2_question',
                'value' => 'L\'inscription est-elle vraiment gratuite ?',
                'type' => 'text',
                'description' => 'Question FAQ 2'
            ],
            [
                'key' => 'faq2_answer',
                'value' => 'Oui, l\'inscription et l\'utilisation de notre bibliothèque sont entièrement gratuites. Aucun frais caché, aucun abonnement requis.',
                'type' => 'textarea',
                'description' => 'Réponse FAQ 2'
            ],

            // FAQ 3
            [
                'key' => 'faq3_question',
                'value' => 'Comment publier mon propre livre ?',
                'type' => 'text',
                'description' => 'Question FAQ 3'
            ],
            [
                'key' => 'faq3_answer',
                'value' => 'Connectez-vous à votre compte, allez dans votre dashboard et cliquez sur "Publier un livre". Suivez les étapes pour uploader votre fichier PDF et remplir les informations nécessaires.',
                'type' => 'textarea',
                'description' => 'Réponse FAQ 3'
            ],

            // FAQ 4
            [
                'key' => 'faq4_question',
                'value' => 'Quels formats de fichiers sont acceptés ?',
                'type' => 'text',
                'description' => 'Question FAQ 4'
            ],
            [
                'key' => 'faq4_answer',
                'value' => 'Nous acceptons principalement les fichiers PDF. D\'autres formats comme EPUB pourront être supportés dans le futur selon les demandes de la communauté.',
                'type' => 'textarea',
                'description' => 'Réponse FAQ 4'
            ],

            // FAQ 5
            [
                'key' => 'faq5_question',
                'value' => 'Puis-je lire les livres hors ligne ?',
                'type' => 'text',
                'description' => 'Question FAQ 5'
            ],
            [
                'key' => 'faq5_answer',
                'value' => 'Oui, une fois téléchargé, vous pouvez lire le livre hors ligne avec n\'importe quel lecteur PDF sur votre appareil (ordinateur, tablette, smartphone).',
                'type' => 'textarea',
                'description' => 'Réponse FAQ 5'
            ],

            // Support FAQ
            [
                'key' => 'faq_support_title',
                'value' => 'Vous ne trouvez pas votre réponse ?',
                'type' => 'text',
                'description' => 'Titre support FAQ'
            ],
            [
                'key' => 'faq_support_subtitle',
                'value' => 'Notre équipe support est là pour vous aider',
                'type' => 'text',
                'description' => 'Sous-titre support FAQ'
            ],
            [
                'key' => 'faq_support_button',
                'value' => 'Contacter le Support',
                'type' => 'text',
                'description' => 'Bouton support FAQ'
            ],

            // Section CTA
            [
                'key' => 'cta_title',
                'value' => 'Prêt à Commencer Votre Aventure Littéraire ?',
                'type' => 'text',
                'description' => 'Titre de la section CTA'
            ],
            [
                'key' => 'cta_subtitle',
                'value' => 'Rejoignez notre communauté de passionnés et découvrez un monde de connaissances à portée de clic',
                'type' => 'textarea',
                'description' => 'Sous-titre de la section CTA'
            ],
            [
                'key' => 'cta_button_register',
                'value' => 'Créer un Compte Gratuit',
                'type' => 'text',
                'description' => 'Bouton créer un compte'
            ],
            [
                'key' => 'cta_button_explore',
                'value' => 'Explorer Sans Compte',
                'type' => 'text',
                'description' => 'Bouton explorer sans compte'
            ],
            [
                'key' => 'cta_button_dashboard',
                'value' => 'Accéder au Dashboard',
                'type' => 'text',
                'description' => 'Bouton accéder au dashboard'
            ],

            // Features CTA
            [
                'key' => 'cta_feature1_title',
                'value' => 'Accès Illimité',
                'type' => 'text',
                'description' => 'Titre feature CTA 1'
            ],
            [
                'key' => 'cta_feature1_description',
                'value' => 'Lisez autant que vous voulez, quand vous voulez',
                'type' => 'text',
                'description' => 'Description feature CTA 1'
            ],
            [
                'key' => 'cta_feature2_title',
                'value' => '100% Gratuit',
                'type' => 'text',
                'description' => 'Titre feature CTA 2'
            ],
            [
                'key' => 'cta_feature2_description',
                'value' => 'Aucun frais caché, aucun abonnement requis',
                'type' => 'text',
                'description' => 'Description feature CTA 2'
            ],
            [
                'key' => 'cta_feature3_title',
                'value' => 'Communauté',
                'type' => 'text',
                'description' => 'Titre feature CTA 3'
            ],
            [
                'key' => 'cta_feature3_description',
                'value' => 'Rejoignez des milliers de lecteurs passionnés',
                'type' => 'text',
                'description' => 'Description feature CTA 3'
            ],

            // Section Newsletter
            [
                'key' => 'newsletter_title',
                'value' => 'Restez Informé',
                'type' => 'text',
                'description' => 'Titre de la newsletter'
            ],
            [
                'key' => 'newsletter_subtitle',
                'value' => 'Recevez les dernières nouveautés et recommandations directement dans votre boîte mail',
                'type' => 'textarea',
                'description' => 'Sous-titre de la newsletter'
            ],
            [
                'key' => 'newsletter_placeholder',
                'value' => 'Votre adresse email...',
                'type' => 'text',
                'description' => 'Placeholder email newsletter'
            ],
            [
                'key' => 'newsletter_button',
                'value' => 'S\'abonner',
                'type' => 'text',
                'description' => 'Bouton newsletter'
            ],
            [
                'key' => 'newsletter_feature1',
                'value' => 'Nouveautés hebdomadaires',
                'type' => 'text',
                'description' => 'Feature newsletter 1'
            ],
            [
                'key' => 'newsletter_feature2',
                'value' => 'Recommandations personnalisées',
                'type' => 'text',
                'description' => 'Feature newsletter 2'
            ],
            [
                'key' => 'newsletter_privacy',
                'value' => 'Pas de spam, désinscription en un clic. Nous respectons votre vie privée.',
                'type' => 'text',
                'description' => 'Texte confidentialité newsletter'
            ],

            // Footer
            [
                'key' => 'footer_links_title',
                'value' => 'Liens Rapides',
                'type' => 'text',
                'description' => 'Titre section liens footer'
            ],
            [
                'key' => 'footer_link_library',
                'value' => 'Bibliothèque',
                'type' => 'text',
                'description' => 'Lien bibliothèque footer'
            ],
            [
                'key' => 'footer_link_search',
                'value' => 'Recherche',
                'type' => 'text',
                'description' => 'Lien recherche footer'
            ],
            [
                'key' => 'footer_link_categories',
                'value' => 'Catégories',
                'type' => 'text',
                'description' => 'Lien catégories footer'
            ],
            [
                'key' => 'footer_link_dashboard',
                'value' => 'Dashboard',
                'type' => 'text',
                'description' => 'Lien dashboard footer'
            ],
            [
                'key' => 'footer_link_login',
                'value' => 'Connexion',
                'type' => 'text',
                'description' => 'Lien connexion footer'
            ],
            [
                'key' => 'footer_link_register',
                'value' => 'Inscription',
                'type' => 'text',
                'description' => 'Lien inscription footer'
            ],
            [
                'key' => 'footer_support_title',
                'value' => 'Support',
                'type' => 'text',
                'description' => 'Titre section support footer'
            ],
            [
                'key' => 'footer_support_help',
                'value' => 'Centre d\'aide',
                'type' => 'text',
                'description' => 'Lien centre d\'aide footer'
            ],
            [
                'key' => 'footer_support_faq',
                'value' => 'FAQ',
                'type' => 'text',
                'description' => 'Lien FAQ footer'
            ],
            [
                'key' => 'footer_support_contact',
                'value' => 'Contact',
                'type' => 'text',
                'description' => 'Lien contact footer'
            ],
            [
                'key' => 'footer_support_privacy',
                'value' => 'Confidentialité',
                'type' => 'text',
                'description' => 'Lien confidentialité footer'
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
