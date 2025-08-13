@extends('layouts.admin-dashboard')

@section('page-title', 'Dashboard Admin')
@section('page-description', 'Vue d\'ensemble dynamique de votre plateforme eLibrary')

@section('content')
    <!-- Header with Real-time Indicator -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard Admin</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Vue d'ensemble en temps réel de votre plateforme
                <span class="inline-flex items-center ml-2">
                    <span id="status-indicator" class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                    <span class="ml-1 text-xs text-gray-500">Dernière mise à jour: <span id="last-update">{{ now()->format('H:i:s') }}</span></span>
                </span>
            </p>
        </div>
        <div class="flex space-x-3">
            <button id="refresh-btn" class="bg-white px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Actualiser
            </button>
            <label class="flex items-center">
                <input type="checkbox" id="auto-refresh" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" checked>
                <span class="ml-2 text-sm text-gray-600">Auto-refresh (30s)</span>
            </label>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <i class="fas fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Utilisateurs totaux</p>
                    <p id="total-users" class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_users'] ?? 0 }}</p>
                    <p id="users-growth" class="text-xs {{ ($stats['users_growth'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }} dark:text-green-400">
                        {{ ($stats['users_growth'] ?? 0) >= 0 ? '+' : '' }}{{ $stats['users_growth'] ?? 0 }}% ce mois
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <i class="fas fa-book text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Livres totaux</p>
                    <p id="total-books" class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_books'] ?? 0 }}</p>
                    <p id="books-growth" class="text-xs {{ ($stats['books_growth'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }} dark:text-green-400">
                        {{ ($stats['books_growth'] ?? 0) >= 0 ? '+' : '' }}{{ $stats['books_growth'] ?? 0 }}% ce mois
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-teal-100 dark:bg-purple-900">
                    <i class="fas fa-user-edit text-teal-600 dark:text-purple-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Auteurs</p>
                    <p id="total-authors" class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_authors'] ?? 0 }}</p>
                    <p id="authors-growth" class="text-xs {{ ($stats['authors_growth'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }} dark:text-green-400">
                        {{ ($stats['authors_growth'] ?? 0) >= 0 ? '+' : '' }}{{ $stats['authors_growth'] ?? 0 }}% ce mois
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900">
                    <i class="fas fa-clock text-orange-600 dark:text-orange-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">En attente</p>
                    <p id="pending-books" class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_books'] ?? 0 }}</p>
                    <p class="text-xs text-orange-600 dark:text-orange-400">À approuver</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Activity Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Activité des 7 derniers jours</h3>
                <div class="flex space-x-2">
                    <button id="chart-users-btn" class="px-3 py-1 text-xs bg-blue-100 text-blue-600 rounded-full">Utilisateurs</button>
                    <button id="chart-books-btn" class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">Livres</button>
                    <button id="chart-activity-btn" class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">Activités</button>
                </div>
            </div>
            <div class="h-64">
                <canvas id="activityChart"></canvas>
            </div>
        </div>

        <!-- Popular Categories -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Catégories Populaires</h3>
            <div id="categories-container" class="space-y-4">
                <!-- Dynamic content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Additional Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Online Users & Today's Activity -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Activité en temps réel</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center p-4 bg-green-50 dark:bg-green-900 rounded-lg">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400" id="online-users">
                        {{ $stats['online_users'] ?? 0 }}
                    </div>
                    <div class="text-sm text-green-600 dark:text-green-400">Utilisateurs en ligne</div>
                </div>
                <div class="text-center p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400" id="today-activities">
                        {{ $stats['today_activities'] ?? 0 }}
                    </div>
                    <div class="text-sm text-blue-600 dark:text-blue-400">Activités aujourd'hui</div>
                </div>
            </div>
        </div>

        <!-- User Growth Trend -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Croissance des utilisateurs</h3>
            <div class="h-32">
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Pending Books -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Livres en attente d'approbation -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Livres en attente</h3>
                <a href="{{ admin_route('books') }}?status=pending" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">Voir tout</a>
            </div>
            <div id="pending-books-container" class="space-y-4">
                <!-- Dynamic content will be loaded here -->
            </div>
        </div>

        <!-- Nouveaux utilisateurs -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Nouveaux utilisateurs</h3>
                <a href="{{ admin_route('users') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">Voir tout</a>
            </div>
            <div id="recent-users-container" class="space-y-4">
                <!-- Dynamic content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Actions Rapides</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ admin_route('books') }}" class="flex items-center p-4 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg mr-3">
                    <i class="fas fa-book text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <p class="font-medium text-blue-900 dark:text-blue-100">Gérer les livres</p>
                    <p class="text-xs text-blue-600 dark:text-blue-400">Voir tous les livres</p>
                </div>
            </a>

            <a href="{{ admin_route('users') }}" class="flex items-center p-4 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition-colors">
                <div class="p-2 bg-green-100 dark:bg-green-800 rounded-lg mr-3">
                    <i class="fas fa-users text-green-600 dark:text-green-400"></i>
                </div>
                <div>
                    <p class="font-medium text-green-900 dark:text-green-100">Gérer les utilisateurs</p>
                    <p class="text-xs text-green-600 dark:text-green-400">Voir tous les utilisateurs</p>
                </div>
            </a>

            <a href="{{ route('books.create') }}" class="flex items-center p-4 bg-purple-50 dark:bg-purple-900 rounded-lg hover:bg-teal-100 dark:hover:bg-purple-800 transition-colors">
                <div class="p-2 bg-teal-100 dark:bg-purple-800 rounded-lg mr-3">
                    <i class="fas fa-plus text-teal-600 dark:text-purple-400"></i>
                </div>
                <div>
                    <p class="font-medium text-purple-900 dark:text-purple-100">Ajouter un livre</p>
                    <p class="text-xs text-teal-600 dark:text-purple-400">Nouveau livre</p>
                </div>
            </a>

            <a href="{{ admin_route('reports') }}" class="flex items-center p-4 bg-orange-50 dark:bg-orange-900 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-800 transition-colors">
                <div class="p-2 bg-orange-100 dark:bg-orange-800 rounded-lg mr-3">
                    <i class="fas fa-chart-line text-orange-600 dark:text-orange-400"></i>
                </div>
                <div>
                    <p class="font-medium text-orange-900 dark:text-orange-100">Voir les rapports</p>
                    <p class="text-xs text-orange-600 dark:text-orange-400">Analytics détaillées</p>
                </div>
            </a>
        </div>
    </div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Variables globales
    let activityChart, userGrowthChart;
    let autoRefreshInterval;
    let isUpdating = false;
    let currentChartType = 'users';

    // Données initiales
    const initialData = {
        stats: @json($stats ?? []),
        chartData: @json($chartData ?? []),
        recentData: @json($recentData ?? [])
    };

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser les graphiques
        initCharts();

        // Charger les données initiales
        updateDashboard(initialData);

        // Event listeners
        document.getElementById('refresh-btn').addEventListener('click', loadDashboardData);

        // Chart type buttons
        document.getElementById('chart-users-btn').addEventListener('click', () => switchChart('users'));
        document.getElementById('chart-books-btn').addEventListener('click', () => switchChart('books'));
        document.getElementById('chart-activity-btn').addEventListener('click', () => switchChart('activity'));

        // Auto-refresh
        const autoRefreshCheckbox = document.getElementById('auto-refresh');

        function startAutoRefresh() {
            if (autoRefreshCheckbox.checked) {
                autoRefreshInterval = setInterval(loadDashboardData, 30000); // 30 secondes
            }
        }

        function stopAutoRefresh() {
            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
            }
        }

        autoRefreshCheckbox.addEventListener('change', function() {
            if (this.checked) {
                startAutoRefresh();
            } else {
                stopAutoRefresh();
            }
        });

        // Démarrer l'auto-refresh
        startAutoRefresh();

        // Arrêter l'auto-refresh quand la page n'est pas visible
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                stopAutoRefresh();
            } else if (autoRefreshCheckbox.checked) {
                startAutoRefresh();
            }
        });
    });

    // Fonction pour charger les données du dashboard
    async function loadDashboardData() {
        if (isUpdating) return;
        isUpdating = true;

        const statusIndicator = document.getElementById('status-indicator');
        statusIndicator.className = 'w-3 h-3 bg-yellow-500 rounded-full animate-pulse';

        try {
            const response = await fetch('{{ admin_route('dashboard.realtime-data') }}');
            const data = await response.json();

            // Mettre à jour le dashboard
            updateDashboard(data);

            // Mettre à jour l'horodatage
            document.getElementById('last-update').textContent = data.timestamp;

            // Indicateur de succès
            statusIndicator.className = 'w-3 h-3 bg-green-500 rounded-full animate-pulse';

        } catch (error) {
            console.error('Erreur lors du chargement des données:', error);
            statusIndicator.className = 'w-3 h-3 bg-red-500 rounded-full animate-pulse';
        } finally {
            isUpdating = false;
        }
    }

    // Fonction pour initialiser les graphiques
    function initCharts() {
        // Graphique d'activité principal
        const activityCtx = document.getElementById('activityChart').getContext('2d');
        activityChart = new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Utilisateurs',
                    data: [],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Graphique de croissance des utilisateurs
        const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
        userGrowthChart = new Chart(userGrowthCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Nouveaux utilisateurs',
                    data: [],
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        display: false
                    }
                }
            }
        });
    }

    // Fonction pour mettre à jour le dashboard
    function updateDashboard(data) {
        // Mettre à jour les statistiques
        updateStats(data.stats);

        // Mettre à jour les graphiques
        updateCharts(data.chartData);

        // Mettre à jour les catégories
        updateCategories(data.categoriesData);

        // Mettre à jour les données récentes
        updateRecentData(data.recentData);
    }

    // Fonction pour mettre à jour les statistiques
    function updateStats(stats) {
        document.getElementById('total-users').textContent = stats.total_users || 0;
        document.getElementById('total-books').textContent = stats.total_books || 0;
        document.getElementById('total-authors').textContent = stats.total_authors || 0;
        document.getElementById('pending-books').textContent = stats.pending_books || 0;
        document.getElementById('online-users').textContent = stats.online_users || 0;
        document.getElementById('today-activities').textContent = stats.today_activities || 0;

        // Mettre à jour les indicateurs de croissance
        updateGrowthIndicator('users-growth', stats.users_growth);
        updateGrowthIndicator('books-growth', stats.books_growth);
        updateGrowthIndicator('authors-growth', stats.authors_growth);
    }

    // Fonction pour mettre à jour les indicateurs de croissance
    function updateGrowthIndicator(elementId, growth) {
        const element = document.getElementById(elementId);
        const isPositive = growth >= 0;

        element.textContent = `${isPositive ? '+' : ''}${growth}% ce mois`;
        element.className = `text-xs ${isPositive ? 'text-green-600' : 'text-red-600'} dark:text-green-400`;
    }

    // Fonction pour mettre à jour les graphiques
    function updateCharts(chartData) {
        if (activityChart && chartData) {
            activityChart.data.labels = chartData.labels;

            // Mettre à jour selon le type de graphique sélectionné
            switch(currentChartType) {
                case 'users':
                    activityChart.data.datasets[0].data = chartData.user_registrations;
                    activityChart.data.datasets[0].label = 'Nouveaux utilisateurs';
                    activityChart.data.datasets[0].borderColor = 'rgb(59, 130, 246)';
                    activityChart.data.datasets[0].backgroundColor = 'rgba(59, 130, 246, 0.1)';
                    break;
                case 'books':
                    activityChart.data.datasets[0].data = chartData.book_uploads;
                    activityChart.data.datasets[0].label = 'Nouveaux livres';
                    activityChart.data.datasets[0].borderColor = 'rgb(16, 185, 129)';
                    activityChart.data.datasets[0].backgroundColor = 'rgba(16, 185, 129, 0.1)';
                    break;
                case 'activity':
                    activityChart.data.datasets[0].data = chartData.activities;
                    activityChart.data.datasets[0].label = 'Activités';
                    activityChart.data.datasets[0].borderColor = 'rgb(139, 92, 246)';
                    activityChart.data.datasets[0].backgroundColor = 'rgba(139, 92, 246, 0.1)';
                    break;
            }

            activityChart.update('none');
        }
    }

    // Fonction pour changer le type de graphique
    function switchChart(type) {
        currentChartType = type;

        // Mettre à jour les boutons
        document.querySelectorAll('[id^="chart-"]').forEach(btn => {
            btn.className = 'px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-full';
        });
        document.getElementById(`chart-${type}-btn`).className = 'px-3 py-1 text-xs bg-blue-100 text-blue-600 rounded-full';

        // Recharger les données
        loadDashboardData();
    }

    // Fonction pour mettre à jour les catégories
    function updateCategories(categoriesData) {
        const container = document.getElementById('categories-container');
        container.innerHTML = '';

        if (categoriesData && categoriesData.length > 0) {
            categoriesData.forEach((category, index) => {
                const colors = ['blue', 'green', 'purple', 'orange', 'red'];
                const color = colors[index % colors.length];

                const categoryElement = document.createElement('div');
                categoryElement.className = 'flex items-center justify-between';
                categoryElement.innerHTML = `
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-${color}-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">${category.name}</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2 mr-3">
                            <div class="bg-${color}-500 h-2 rounded-full" style="width: ${category.percentage}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">${category.percentage}%</span>
                    </div>
                `;
                container.appendChild(categoryElement);
            });
        } else {
            container.innerHTML = '<p class="text-gray-500 text-center">Aucune catégorie trouvée</p>';
        }
    }

    // Fonction pour mettre à jour les données récentes
    function updateRecentData(recentData) {
        // Mettre à jour les livres en attente
        updatePendingBooks(recentData.pending_books);

        // Mettre à jour les nouveaux utilisateurs
        updateRecentUsers(recentData.recent_users);
    }

    // Fonction pour mettre à jour les livres en attente
    function updatePendingBooks(pendingBooks) {
        const container = document.getElementById('pending-books-container');
        container.innerHTML = '';

        if (pendingBooks && pendingBooks.length > 0) {
            pendingBooks.forEach(book => {
                const bookElement = document.createElement('div');
                bookElement.className = 'flex items-start space-x-3 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg';
                bookElement.innerHTML = `
                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-book text-orange-600 dark:text-orange-400"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">${book.title}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Par ${book.author}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">${book.created_at}</p>
                    </div>
                    <div class="flex space-x-2">
                        <button class="text-green-600 hover:text-green-700 text-xs">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="text-red-600 hover:text-red-700 text-xs">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                container.appendChild(bookElement);
            });
        } else {
            container.innerHTML = `
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400">Aucun livre en attente d'approbation</p>
                </div>
            `;
        }
    }

    // Fonction pour mettre à jour les nouveaux utilisateurs
    function updateRecentUsers(recentUsers) {
        const container = document.getElementById('recent-users-container');
        container.innerHTML = '';

        if (recentUsers && recentUsers.length > 0) {
            recentUsers.forEach(user => {
                const userElement = document.createElement('div');
                userElement.className = 'flex items-start space-x-3';
                userElement.innerHTML = `
                    <img class="w-10 h-10 rounded-full" src="${user.avatar}" alt="${user.name}">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">${user.name}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">${user.email}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                ${user.role.charAt(0).toUpperCase() + user.role.slice(1)}
                            </span>
                        </p>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        ${user.created_at}
                    </div>
                `;
                container.appendChild(userElement);
            });
        } else {
            container.innerHTML = `
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-blue-500 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400">Aucun nouvel utilisateur récemment</p>
                </div>
            `;
        }
    }
</script>
@endsection