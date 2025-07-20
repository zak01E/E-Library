<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MainDashboardController extends Controller
{
    /**
     * Display the main dashboard
     */
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'active_users' => User::where('created_at', '>=', now()->subMonth())->count(),
            'total_downloads' => 94328, // This would come from a downloads table
            'average_rating' => 4.8, // This would come from a ratings table
        ];

        return view('dashboard.main', compact('stats'));
    }

    /**
     * Display books categories
     */
    public function booksCategories()
    {
        $categories = [
            [
                'name' => 'Fiction',
                'description' => 'Romans, nouvelles et œuvres imaginaires',
                'count' => 1247,
                'icon' => 'fa-magic',
                'color' => 'blue',
                'status' => 'active'
            ],
            [
                'name' => 'Science',
                'description' => 'Recherche scientifique et découvertes',
                'count' => 892,
                'icon' => 'fa-flask',
                'color' => 'green',
                'status' => 'active'
            ],
            [
                'name' => 'Technologie',
                'description' => 'Programmation, IA et innovations tech',
                'count' => 743,
                'icon' => 'fa-laptop-code',
                'color' => 'purple',
                'status' => 'active'
            ],
            [
                'name' => 'Histoire',
                'description' => 'Événements historiques et biographies',
                'count' => 634,
                'icon' => 'fa-landmark',
                'color' => 'orange',
                'status' => 'active'
            ],
            [
                'name' => 'Art & Design',
                'description' => 'Beaux-arts, design et créativité',
                'count' => 456,
                'icon' => 'fa-palette',
                'color' => 'pink',
                'status' => 'active'
            ],
            [
                'name' => 'Business',
                'description' => 'Entrepreneuriat et gestion d\'entreprise',
                'count' => 389,
                'icon' => 'fa-briefcase',
                'color' => 'indigo',
                'status' => 'active'
            ],
            [
                'name' => 'Philosophie',
                'description' => 'Réflexions et pensées philosophiques',
                'count' => 267,
                'icon' => 'fa-brain',
                'color' => 'yellow',
                'status' => 'inactive'
            ],
            [
                'name' => 'Santé & Bien-être',
                'description' => 'Médecine, nutrition et développement personnel',
                'count' => 523,
                'icon' => 'fa-heartbeat',
                'color' => 'red',
                'status' => 'active'
            ]
        ];

        return view('books.categories', compact('categories'));
    }

    /**
     * Display books reviews
     */
    public function booksReviews()
    {
        $stats = [
            'average_rating' => 4.7,
            'total_reviews' => 3247,
            'positive_reviews' => 89,
            'flagged_reviews' => 23
        ];

        $reviews = [
            [
                'id' => 1,
                'user_name' => 'Marie Dubois',
                'user_avatar' => 'https://ui-avatars.com/api/?name=Marie+Dubois&background=6366f1&color=fff',
                'book_title' => 'L\'Art de la Programmation',
                'book_author' => 'Donald Knuth',
                'book_category' => 'Technologie',
                'rating' => 5,
                'comment' => 'Excellent livre pour comprendre les fondamentaux de la programmation. Les explications sont claires et les exemples très pertinents. Je le recommande vivement à tous les développeurs, débutants comme expérimentés.',
                'helpful_votes' => 24,
                'replies_count' => 3,
                'status' => 'approved',
                'created_at' => '2 heures'
            ],
            [
                'id' => 2,
                'user_name' => 'Jean Martin',
                'user_avatar' => 'https://ui-avatars.com/api/?name=Jean+Martin&background=10b981&color=fff',
                'book_title' => 'Intelligence Artificielle Moderne',
                'book_author' => 'Stuart Russell',
                'book_category' => 'Science',
                'rating' => 4,
                'comment' => 'Livre très complet sur l\'IA. Couvre bien les aspects théoriques et pratiques. Quelques passages un peu techniques mais dans l\'ensemble très accessible. Parfait pour se mettre à jour sur les dernières avancées.',
                'helpful_votes' => 18,
                'replies_count' => 1,
                'status' => 'pending',
                'created_at' => '5 heures'
            ],
            [
                'id' => 3,
                'user_name' => 'Pierre Durand',
                'user_avatar' => 'https://ui-avatars.com/api/?name=Pierre+Durand&background=ef4444&color=fff',
                'book_title' => 'Design Patterns',
                'book_author' => 'Gang of Four',
                'book_category' => 'Technologie',
                'rating' => 1,
                'comment' => 'Livre complètement dépassé, les exemples ne fonctionnent plus avec les technologies actuelles. Perte de temps totale.',
                'helpful_votes' => -12,
                'replies_count' => 0,
                'status' => 'flagged',
                'flagged_count' => 5,
                'created_at' => '1 jour'
            ]
        ];

        return view('books.reviews', compact('stats', 'reviews'));
    }

    /**
     * Display authors index
     */
    public function authorsIndex()
    {
        $stats = [
            'total_authors' => 1247,
            'active_authors' => 892,
            'featured_authors' => 47,
            'pending_applications' => 34
        ];

        $authors = [
            [
                'id' => 1,
                'name' => 'Marie Dubois',
                'email' => 'marie.dubois@email.com',
                'avatar' => 'https://ui-avatars.com/api/?name=Marie+Dubois&background=6366f1&color=fff',
                'specialty' => 'Spécialiste IA',
                'books_count' => 23,
                'rating' => 4.8,
                'reads_count' => 12400,
                'reviews_count' => 234,
                'status' => 'featured',
                'last_activity' => '2 heures'
            ],
            [
                'id' => 2,
                'name' => 'Jean Martin',
                'email' => 'jean.martin@email.com',
                'avatar' => 'https://ui-avatars.com/api/?name=Jean+Martin&background=10b981&color=fff',
                'specialty' => 'Historien',
                'books_count' => 18,
                'rating' => 4.6,
                'reads_count' => 8700,
                'reviews_count' => 156,
                'status' => 'active',
                'last_activity' => '1 jour'
            ],
            [
                'id' => 3,
                'name' => 'Sophie Laurent',
                'email' => 'sophie.laurent@email.com',
                'avatar' => 'https://ui-avatars.com/api/?name=Sophie+Laurent&background=f59e0b&color=fff',
                'specialty' => 'Romancière',
                'books_count' => 3,
                'rating' => 4.9,
                'reads_count' => 2100,
                'reviews_count' => 47,
                'status' => 'new',
                'last_activity' => '3 heures'
            ]
        ];

        return view('authors.index', compact('stats', 'authors'));
    }

    /**
     * Display analytics overview
     */
    public function analyticsOverview()
    {
        $metrics = [
            'page_views' => 247300,
            'unique_users' => 18400,
            'downloads' => 94300,
            'avg_time' => '4m 32s'
        ];

        $trends = [
            'page_views_trend' => 12.5,
            'users_trend' => 8.2,
            'downloads_trend' => 23.1,
            'time_trend' => -2.3
        ];

        return view('analytics.overview', compact('metrics', 'trends'));
    }

    /**
     * Display users management
     */
    public function usersIndex()
    {
        $stats = [
            'total_users' => 18492,
            'active_users' => 13247,
            'premium_users' => 2847,
            'new_users_week' => 234
        ];

        $users = [
            [
                'id' => 1,
                'name' => 'Marie Dubois',
                'email' => 'marie.dubois@email.com',
                'avatar' => 'https://ui-avatars.com/api/?name=Marie+Dubois&background=6366f1&color=fff',
                'role' => 'author',
                'status' => 'active',
                'last_activity' => '2 heures',
                'books_read' => 247
            ],
            [
                'id' => 2,
                'name' => 'Jean Martin',
                'email' => 'jean.martin@email.com',
                'avatar' => 'https://ui-avatars.com/api/?name=Jean+Martin&background=10b981&color=fff',
                'role' => 'user',
                'status' => 'active',
                'last_activity' => '1 jour',
                'books_read' => 89
            ],
            [
                'id' => 3,
                'name' => 'Sophie Laurent',
                'email' => 'sophie.laurent@email.com',
                'avatar' => 'https://ui-avatars.com/api/?name=Sophie+Laurent&background=f59e0b&color=fff',
                'role' => 'admin',
                'status' => 'active',
                'last_activity' => '30 min',
                'books_read' => 156
            ],
            [
                'id' => 4,
                'name' => 'Pierre Durand',
                'email' => 'pierre.durand@email.com',
                'avatar' => 'https://ui-avatars.com/api/?name=Pierre+Durand&background=ef4444&color=fff',
                'role' => 'user',
                'status' => 'suspended',
                'last_activity' => '5 jours',
                'books_read' => 23
            ],
            [
                'id' => 5,
                'name' => 'Anne Moreau',
                'email' => 'anne.moreau@email.com',
                'avatar' => 'https://ui-avatars.com/api/?name=Anne+Moreau&background=8b5cf6&color=fff',
                'role' => 'author',
                'status' => 'active',
                'last_activity' => '3 heures',
                'books_read' => 134
            ]
        ];

        return view('users.index', compact('stats', 'users'));
    }

    /**
     * Display marketing campaigns
     */
    public function marketingCampaigns()
    {
        $stats = [
            'active_campaigns' => 12,
            'total_impressions' => 847200,
            'click_rate' => 4.7,
            'avg_roi' => 312
        ];

        $campaigns = [
            [
                'id' => 1,
                'name' => 'Promotion Livres Tech',
                'type' => 'Email + Social Media',
                'status' => 'active',
                'impressions' => 247300,
                'clicks' => 11600,
                'ctr' => 4.7,
                'budget_used' => 2340,
                'budget_total' => 3000,
                'started_days_ago' => 5,
                'ends_in_days' => 9,
                'icon' => 'fa-book-open',
                'color' => 'blue'
            ],
            [
                'id' => 2,
                'name' => 'Rentrée Étudiante',
                'type' => 'Display + Search',
                'status' => 'active',
                'impressions' => 189700,
                'clicks' => 8900,
                'ctr' => 4.7,
                'budget_used' => 1890,
                'budget_total' => 2500,
                'started_days_ago' => 12,
                'ends_in_days' => 3,
                'icon' => 'fa-graduation-cap',
                'color' => 'green'
            ]
        ];

        return view('marketing.campaigns', compact('stats', 'campaigns'));
    }

    /**
     * Display collections
     */
    public function collectionsIndex()
    {
        $stats = [
            'total_collections' => 47,
            'popular_collections' => 12,
            'books_in_collections' => 1247,
            'total_views' => 94300
        ];

        return view('collections.index', compact('stats'));
    }

    /**
     * Display system settings
     */
    public function systemSettings()
    {
        $settings = [
            'platform_name' => 'E-Library',
            'base_url' => 'https://elibrary.com',
            'timezone' => 'Europe/Paris',
            'default_language' => 'fr',
            'description' => 'Une plateforme moderne de bibliothèque numérique permettant aux auteurs de publier leurs œuvres et aux lecteurs de découvrir de nouveaux contenus.',
            'registrations_open' => true,
            'maintenance_mode' => false
        ];

        return view('system.settings', compact('settings'));
    }
}
