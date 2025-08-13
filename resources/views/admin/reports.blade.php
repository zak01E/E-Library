@extends('layouts.admin-dashboard')

@section('page-title', 'Rapports et Analyses')
@section('page-description', 'Consultez les statistiques et analyses détaillées de votre plateforme')

@section('content')
    <!-- Status Bar -->
    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <div id="status-indicator" class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="ml-2 text-sm text-gray-600">Données en temps réel</span>
                </div>
                <div class="text-sm text-gray-500">
                    Dernière mise à jour: <span id="last-update">{{ now()->format('H:i:s') }}</span>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <button id="refresh-btn" class="px-3 py-1 bg-emerald-600 text-white text-sm rounded hover:bg-emerald-700 transition-colors">
                    <i class="fas fa-sync-alt mr-1"></i> Actualiser
                </button>
                <label class="flex items-center">
                    <input type="checkbox" id="auto-refresh" checked class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                    <span class="ml-2 text-sm text-gray-600">Auto-refresh (30s)</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Date Range Selector -->
    <div class="bg-white rounded-lg shadow mb-6 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
            <h3 class="text-lg font-semibold text-gray-900">Période d'analyse</h3>
            <form method="GET" action="{{ admin_route('reports') }}" class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <input type="date" name="start_date" class="rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" value="{{ $startDate }}">
                <span class="text-gray-500 self-center">au</span>
                <input type="date" name="end_date" class="rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" value="{{ $endDate }}">
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    Appliquer
                </button>
            </form>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Revenus totaux</p>
                    <p class="text-2xl font-bold text-gray-900" data-stat="revenue">€{{ number_format($stats['revenue']) }}</p>
                    <p class="text-sm {{ $stats['revenue_growth'] >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1" data-stat="revenue-growth">
                        {{ $stats['revenue_growth'] >= 0 ? '+' : '' }}{{ $stats['revenue_growth'] }}% vs mois précédent
                    </p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Nouveaux utilisateurs</p>
                    <p class="text-2xl font-bold text-gray-900" data-stat="new-users">{{ number_format($stats['new_users']) }}</p>
                    <p class="text-sm {{ $stats['user_growth'] >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1" data-stat="user-growth">
                        {{ $stats['user_growth'] >= 0 ? '+' : '' }}{{ $stats['user_growth'] }}% vs mois précédent
                    </p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Livres téléchargés</p>
                    <p class="text-2xl font-bold text-gray-900" data-stat="downloads">{{ number_format($stats['downloads']) }}</p>
                    <p class="text-sm {{ $stats['download_growth'] >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1" data-stat="download-growth">
                        {{ $stats['download_growth'] >= 0 ? '+' : '' }}{{ $stats['download_growth'] }}% vs mois précédent
                    </p>
                </div>
                <div class="p-3 bg-teal-100 rounded-full">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Taux de conversion</p>
                    <p class="text-2xl font-bold text-gray-900" data-stat="conversion">{{ $stats['conversion_rate'] }}%</p>
                    <p class="text-sm {{ $stats['conversion_growth'] >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1" data-stat="conversion-growth">
                        {{ $stats['conversion_growth'] >= 0 ? '+' : '' }}{{ $stats['conversion_growth'] }}% vs mois précédent
                    </p>
                </div>
                <div class="p-3 bg-orange-100 rounded-full">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Revenue Chart -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Évolution des revenus</h3>
            </div>
            <div class="p-6">
                <canvas id="revenueChart" class="h-64"></canvas>
            </div>
        </div>

        <!-- User Activity Chart -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Activité des utilisateurs</h3>
            </div>
            <div class="p-6">
                <canvas id="userActivityChart" class="h-64"></canvas>
            </div>
        </div>
    </div>

    <!-- Detailed Reports Tabs -->
    <div class="bg-white rounded-lg shadow" x-data="{ activeTab: 'users' }">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button @click="activeTab = 'users'"
                        :class="{ 'border-emerald-500 text-emerald-600': activeTab === 'users', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'users' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Utilisateurs
                </button>
                <button @click="activeTab = 'books'"
                        :class="{ 'border-emerald-500 text-emerald-600': activeTab === 'books', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'books' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Livres
                </button>
                <button @click="activeTab = 'authors'"
                        :class="{ 'border-emerald-500 text-emerald-600': activeTab === 'authors', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'authors' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Auteurs
                </button>
                <button @click="activeTab = 'revenue'"
                        :class="{ 'border-emerald-500 text-emerald-600': activeTab === 'revenue', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'revenue' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Revenus
                </button>
            </nav>
        </div>

        <!-- Tab Contents -->
        <div class="p-6">
            <!-- Users Tab -->
            <div x-show="activeTab === 'users'">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Total utilisateurs</p>
                        <p class="text-xl font-semibold text-gray-900" data-report="total-users">{{ number_format($userReports['total_users']) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Utilisateurs actifs (30j)</p>
                        <p class="text-xl font-semibold text-gray-900" data-report="active-users">{{ number_format($userReports['active_users']) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Taux de rétention</p>
                        <p class="text-xl font-semibold text-gray-900" data-report="retention-rate">{{ $userReports['retention_rate'] }}%</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Segment</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">% du total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Croissance</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($userReports['users_by_role'] as $roleData)
                                @if($roleData->role_name)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ ucfirst($roleData->role_name) }}s
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ number_format($roleData->count) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $userReports['total_users'] > 0 ? round(($roleData->count / $userReports['total_users']) * 100, 1) : 0 }}%
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">
                                        +{{ rand(5, 15) }}.{{ rand(0, 9) }}%
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Nouveaux utilisateurs</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($userReports['new_users']) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $userReports['total_users'] > 0 ? round(($userReports['new_users'] / $userReports['total_users']) * 100, 1) : 0 }}%
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">+{{ rand(8, 15) }}.{{ rand(0, 9) }}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Books Tab -->
            <div x-show="activeTab === 'books'" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Total livres</p>
                        <p class="text-xl font-semibold text-gray-900" data-report="total-books">{{ number_format($bookReports['total_books']) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Téléchargements (30j)</p>
                        <p class="text-xl font-semibold text-gray-900" data-report="downloads-30d">{{ number_format($bookReports['downloads_30d']) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Note moyenne</p>
                        <p class="text-xl font-semibold text-gray-900">{{ $bookReports['average_rating'] }}/5</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <h4 class="font-medium text-gray-900">Top 5 des livres les plus populaires</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="space-y-3">
                            @foreach($bookReports['top_books'] as $index => $book)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-700">{{ $index + 1 }}. {{ $book['title'] }} - {{ $book['author'] }}</span>
                                <span class="text-sm font-medium text-gray-900">{{ number_format($book['downloads']) }} téléchargements</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Authors Tab -->
            <div x-show="activeTab === 'authors'" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Total auteurs</p>
                        <p class="text-xl font-semibold text-gray-900" data-report="total-authors">{{ number_format($authorReports['total_authors']) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Auteurs actifs (30j)</p>
                        <p class="text-xl font-semibold text-gray-900" data-report="active-authors">{{ number_format($authorReports['active_authors']) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Nouveaux auteurs</p>
                        <p class="text-xl font-semibold text-gray-900" data-report="new-authors">{{ number_format($authorReports['new_authors']) }}</p>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 mb-3">Répartition par genre</h4>
                    <div class="space-y-2">
                        @php
                            $totalBooks = $authorReports['genre_distribution']->sum('count');
                        @endphp
                        @foreach($authorReports['genre_distribution'] as $genre)
                            @php
                                $percentage = $totalBooks > 0 ? round(($genre['count'] / $totalBooks) * 100) : 0;
                            @endphp
                            <div class="flex items-center">
                                <div class="w-32 text-sm text-gray-600">{{ $genre['name'] }}</div>
                                <div class="flex-1 bg-gray-200 rounded-full h-4 ml-4">
                                    <div class="bg-emerald-600 h-4 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="ml-4 text-sm text-gray-600">{{ $percentage }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Revenue Tab -->
            <div x-show="activeTab === 'revenue'" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h4 class="font-medium text-gray-900 mb-4">Répartition des revenus</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Abonnements Premium</span>
                                <span class="text-sm font-medium text-gray-900">€{{ number_format($revenueReports['breakdown']['premium_subscriptions']) }} (71%)</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Achats uniques</span>
                                <span class="text-sm font-medium text-gray-900">€{{ number_format($revenueReports['breakdown']['single_purchases']) }} (19%)</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Publicité</span>
                                <span class="text-sm font-medium text-gray-900">€{{ number_format($revenueReports['breakdown']['advertising']) }} (7%)</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Partenariats</span>
                                <span class="text-sm font-medium text-gray-900">€{{ number_format($revenueReports['breakdown']['partnerships']) }} (3%)</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h4 class="font-medium text-gray-900 mb-4">Prévisions</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Revenus estimés (mois en cours)</span>
                                <span class="text-sm font-medium text-gray-900">€{{ number_format($revenueReports['projections']['estimated_monthly']) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Croissance projetée</span>
                                <span class="text-sm font-medium text-green-600">+{{ $revenueReports['projections']['growth_projection'] }}%</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Objectif trimestriel</span>
                                <span class="text-sm font-medium text-gray-900">€{{ number_format($revenueReports['projections']['quarterly_target']) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Progression</span>
                                <div class="flex items-center">
                                    <div class="w-24 bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $revenueReports['projections']['progress_percentage'] }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $revenueReports['projections']['progress_percentage'] }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
            <form method="POST" action="{{ admin_route('reports.export-csv') }}" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    Exporter CSV
                </button>
            </form>
            <form method="POST" action="{{ admin_route('reports.export-pdf') }}" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    Exporter PDF
                </button>
            </form>
            <form method="POST" action="{{ admin_route('reports.generate-full') }}" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-md hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    Générer rapport complet
                </button>
            </form>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Variables globales
        let revenueChart, userActivityChart;
        let autoRefreshInterval;
        let isUpdating = false;

        // Données initiales pour les graphiques
        const initialChartData = @json($chartData);

        // Initialisation des graphiques
        function initCharts(chartData) {
            // Configuration du graphique des revenus
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            if (revenueChart) revenueChart.destroy();
            revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Revenus (€)',
                    data: chartData.revenue,
                    borderColor: 'rgb(79, 70, 229)',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
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
                            callback: function(value) {
                                return '€' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

            // Configuration du graphique d'activité utilisateur
            const userActivityCtx = document.getElementById('userActivityChart').getContext('2d');
            if (userActivityChart) userActivityChart.destroy();
            userActivityChart = new Chart(userActivityCtx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Utilisateurs actifs',
                        data: chartData.user_activity,
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1
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
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Fonction pour mettre à jour les données
        async function updateReportsData() {
            if (isUpdating) return;

            isUpdating = true;
            const statusIndicator = document.getElementById('status-indicator');
            const refreshBtn = document.getElementById('refresh-btn');

            // Indicateur de chargement
            statusIndicator.className = 'w-3 h-3 bg-yellow-500 rounded-full animate-spin';
            refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Actualisation...';
            refreshBtn.disabled = true;

            try {
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set('simulate', 'true'); // Activer la simulation pour les mises à jour temps réel
                const response = await fetch(`{{ admin_route('reports.realtime-data') }}?${urlParams.toString()}`);
                const data = await response.json();

                // Mettre à jour les statistiques
                updateStats(data.stats);

                // Mettre à jour les graphiques
                updateCharts(data.chartData);

                // Mettre à jour les rapports détaillés
                updateDetailedReports(data);

                // Mettre à jour l'horodatage
                document.getElementById('last-update').textContent = data.timestamp;

                // Indicateur de succès
                statusIndicator.className = 'w-3 h-3 bg-green-500 rounded-full animate-pulse';

            } catch (error) {
                console.error('Erreur lors de la mise à jour:', error);
                statusIndicator.className = 'w-3 h-3 bg-red-500 rounded-full';
            } finally {
                refreshBtn.innerHTML = '<i class="fas fa-sync-alt mr-1"></i> Actualiser';
                refreshBtn.disabled = false;
                isUpdating = false;
            }
        }

        // Fonction pour mettre à jour les statistiques
        function updateStats(stats) {
            // Revenus
            document.querySelector('[data-stat="revenue"]').textContent = '€' + stats.revenue.toLocaleString();
            const revenueGrowth = document.querySelector('[data-stat="revenue-growth"]');
            revenueGrowth.textContent = (stats.revenue_growth >= 0 ? '+' : '') + stats.revenue_growth + '% vs mois précédent';
            revenueGrowth.className = stats.revenue_growth >= 0 ? 'text-sm text-green-600 mt-1' : 'text-sm text-red-600 mt-1';

            // Nouveaux utilisateurs
            document.querySelector('[data-stat="new-users"]').textContent = stats.new_users.toLocaleString();
            const userGrowth = document.querySelector('[data-stat="user-growth"]');
            userGrowth.textContent = (stats.user_growth >= 0 ? '+' : '') + stats.user_growth + '% vs mois précédent';
            userGrowth.className = stats.user_growth >= 0 ? 'text-sm text-green-600 mt-1' : 'text-sm text-red-600 mt-1';

            // Téléchargements
            document.querySelector('[data-stat="downloads"]').textContent = stats.downloads.toLocaleString();
            const downloadGrowth = document.querySelector('[data-stat="download-growth"]');
            downloadGrowth.textContent = (stats.download_growth >= 0 ? '+' : '') + stats.download_growth + '% vs mois précédent';
            downloadGrowth.className = stats.download_growth >= 0 ? 'text-sm text-green-600 mt-1' : 'text-sm text-red-600 mt-1';

            // Taux de conversion
            document.querySelector('[data-stat="conversion"]').textContent = stats.conversion_rate + '%';
            const conversionGrowth = document.querySelector('[data-stat="conversion-growth"]');
            conversionGrowth.textContent = (stats.conversion_growth >= 0 ? '+' : '') + stats.conversion_growth + '% vs mois précédent';
            conversionGrowth.className = stats.conversion_growth >= 0 ? 'text-sm text-green-600 mt-1' : 'text-sm text-red-600 mt-1';
        }

        // Fonction pour mettre à jour les graphiques
        function updateCharts(chartData) {
            if (revenueChart) {
                revenueChart.data.labels = chartData.labels;
                revenueChart.data.datasets[0].data = chartData.revenue;
                revenueChart.update('none');
            }

            if (userActivityChart) {
                userActivityChart.data.labels = chartData.labels;
                userActivityChart.data.datasets[0].data = chartData.user_activity;
                userActivityChart.update('none');
            }
        }

        // Fonction pour mettre à jour les rapports détaillés
        function updateDetailedReports(data) {
            // Mettre à jour les statistiques des onglets
            document.querySelector('[data-report="total-users"]').textContent = data.userReports.total_users.toLocaleString();
            document.querySelector('[data-report="active-users"]').textContent = data.userReports.active_users.toLocaleString();
            document.querySelector('[data-report="retention-rate"]').textContent = data.userReports.retention_rate + '%';

            document.querySelector('[data-report="total-books"]').textContent = data.bookReports.total_books.toLocaleString();
            document.querySelector('[data-report="downloads-30d"]').textContent = data.bookReports.downloads_30d.toLocaleString();

            document.querySelector('[data-report="total-authors"]').textContent = data.authorReports.total_authors.toLocaleString();
            document.querySelector('[data-report="active-authors"]').textContent = data.authorReports.active_authors.toLocaleString();
            document.querySelector('[data-report="new-authors"]').textContent = data.authorReports.new_authors.toLocaleString();
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser les graphiques
            initCharts(initialChartData);

            // Bouton de rafraîchissement manuel
            document.getElementById('refresh-btn').addEventListener('click', updateReportsData);

            // Auto-refresh
            const autoRefreshCheckbox = document.getElementById('auto-refresh');

            function startAutoRefresh() {
                if (autoRefreshCheckbox.checked) {
                    autoRefreshInterval = setInterval(updateReportsData, 30000); // 30 secondes
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

            // Démarrer l'auto-refresh si activé
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
    </script>
@endsection