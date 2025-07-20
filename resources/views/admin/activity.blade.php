@extends('layouts.admin-dashboard')

@section('page-title', 'Activité des Utilisateurs')
@section('page-description', 'Surveillance en temps réel de l\'activité et des interactions des utilisateurs')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Activité des utilisateurs</h2>
            <p class="mt-1 text-sm text-gray-600">
                Surveillance en temps réel de l'activité sur la plateforme
                <span class="inline-flex items-center ml-2">
                    <span id="status-indicator" class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                    <span class="ml-1 text-xs text-gray-500">Dernière mise à jour: <span id="last-update">{{ now()->format('H:i:s') }}</span></span>
                </span>
            </p>
        </div>
        <div class="flex space-x-3">
            <select id="period-selector" class="border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="1h">Dernière heure</option>
                <option value="24h" selected>Dernières 24h</option>
                <option value="7d">Dernière semaine</option>
                <option value="30d">Dernier mois</option>
            </select>
            <button id="refresh-btn" class="bg-white px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Actualiser
            </button>
            <label class="flex items-center">
                <input type="checkbox" id="auto-refresh" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" checked>
                <span class="ml-2 text-sm text-gray-600">Auto-refresh (15s)</span>
            </label>
        </div>
    </div>

    <!-- Real-time Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-r from-green-400 to-green-500 rounded-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Utilisateurs en ligne</p>
                    <p id="online-users" class="text-2xl font-bold">{{ $stats['online_users'] ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <p id="online-users-change" class="text-xs mt-2 opacity-75">Temps réel</p>
        </div>

        <div class="bg-gradient-to-r from-blue-400 to-blue-500 rounded-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Nouveaux utilisateurs</p>
                    <p id="new-users" class="text-2xl font-bold">{{ $stats['new_users'] ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
            </div>
            <p id="new-users-change" class="text-xs mt-2 opacity-75">{{ $stats['new_users_change'] ?? 0 }}% vs période précédente</p>
        </div>

        <div class="bg-gradient-to-r from-purple-400 to-purple-500 rounded-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Téléchargements</p>
                    <p id="downloads" class="text-2xl font-bold">{{ $stats['downloads'] ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                </div>
            </div>
            <p id="downloads-change" class="text-xs mt-2 opacity-75">{{ $stats['downloads_change'] ?? 0 }}% vs période précédente</p>
        </div>

        <div class="bg-gradient-to-r from-orange-400 to-orange-500 rounded-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Pages vues</p>
                    <p id="page-views" class="text-2xl font-bold">{{ $stats['page_views'] ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
            </div>
            <p id="page-views-change" class="text-xs mt-2 opacity-75">{{ $stats['page_views_change'] ?? 0 }}% vs période précédente</p>
        </div>
    </div>

    <!-- Activity Chart & Timeline -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Activity Chart -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Activité par heure</h3>
            </div>
            <div class="p-6">
                <canvas id="activityChart" class="h-96"></canvas>
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Activité récente</h3>
            </div>
            <div id="activity-timeline" class="p-6 space-y-4 max-h-96 overflow-y-auto">
                <!-- Timeline items -->
                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">Nouvel utilisateur inscrit</p>
                        <p class="text-xs text-gray-500">Marie Dupont - Il y a 2 min</p>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">Livre téléchargé</p>
                        <p class="text-xs text-gray-500">"1984" par Jean Martin - Il y a 5 min</p>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">Nouvelle évaluation</p>
                        <p class="text-xs text-gray-500">"Le Petit Prince" - 5 étoiles - Il y a 8 min</p>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">Abonnement Premium</p>
                        <p class="text-xs text-gray-500">Pierre Leroy - Il y a 12 min</p>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">Déconnexion</p>
                        <p class="text-xs text-gray-500">Sophie Bernard - Il y a 15 min</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Activity Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Journal d'activité détaillé</h3>
            <div class="flex items-center space-x-3">
                <input type="text" id="search-input" placeholder="Rechercher un utilisateur..." class="border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <select id="action-filter" class="border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="all">Toutes les actions</option>
                    <option value="login">Connexions</option>
                    <option value="download">Téléchargements</option>
                    <option value="register">Inscriptions</option>
                    <option value="view">Consultations</option>
                </select>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Heure</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Détails</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appareil</th>
                    </tr>
                </thead>
                <tbody id="activity-table-body" class="bg-white divide-y divide-gray-200">
                    <!-- Dynamic content will be loaded here -->
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                <span id="table-info">Chargement...</span>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Variables globales
    let activityChart;
    let autoRefreshInterval;
    let isUpdating = false;

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser le graphique
        initActivityChart();

        // Charger les données initiales
        loadActivityData();

        // Event listeners
        document.getElementById('refresh-btn').addEventListener('click', loadActivityData);
        document.getElementById('period-selector').addEventListener('change', loadActivityData);
        document.getElementById('search-input').addEventListener('input', debounce(loadActivityData, 500));
        document.getElementById('action-filter').addEventListener('change', loadActivityData);

        // Auto-refresh
        const autoRefreshCheckbox = document.getElementById('auto-refresh');

        function startAutoRefresh() {
            if (autoRefreshCheckbox.checked) {
                autoRefreshInterval = setInterval(loadActivityData, 15000); // 15 secondes
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

    // Fonction pour charger les données d'activité
    async function loadActivityData() {
        if (isUpdating) return;
        isUpdating = true;

        const statusIndicator = document.getElementById('status-indicator');
        statusIndicator.className = 'w-3 h-3 bg-yellow-500 rounded-full animate-pulse';

        try {
            const period = document.getElementById('period-selector').value;
            const search = document.getElementById('search-input').value;
            const actionFilter = document.getElementById('action-filter').value;

            const params = new URLSearchParams({
                period: period,
                search: search,
                action_filter: actionFilter,
                limit: 50
            });

            const response = await fetch(`{{ route('admin.activity.realtime-data') }}?${params.toString()}`);
            const data = await response.json();

            // Mettre à jour les statistiques
            updateStats(data.stats);

            // Mettre à jour le graphique
            updateActivityChart(data.charts);

            // Mettre à jour la timeline
            updateActivityTimeline(data.activities);

            // Mettre à jour le tableau
            updateActivityTable(data.activities);

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

    // Fonction pour initialiser le graphique d'activité
    function initActivityChart() {
        const ctx = document.getElementById('activityChart').getContext('2d');
        activityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Activité par heure',
                    data: [],
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
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // Fonction pour mettre à jour les statistiques
    function updateStats(stats) {
        document.getElementById('online-users').textContent = stats.online_users;
        document.getElementById('new-users').textContent = stats.new_users;
        document.getElementById('downloads').textContent = stats.downloads;
        document.getElementById('page-views').textContent = stats.page_views;

        // Mettre à jour les changements
        updateChangeIndicator('new-users-change', stats.new_users_change);
        updateChangeIndicator('downloads-change', stats.downloads_change);
        updateChangeIndicator('page-views-change', stats.page_views_change);
    }

    // Fonction pour mettre à jour les indicateurs de changement
    function updateChangeIndicator(elementId, change) {
        const element = document.getElementById(elementId);
        if (change > 0) {
            element.textContent = `+${change}% vs période précédente`;
        } else if (change < 0) {
            element.textContent = `${change}% vs période précédente`;
        } else {
            element.textContent = 'Aucun changement vs période précédente';
        }
    }

    // Fonction pour mettre à jour le graphique
    function updateActivityChart(chartData) {
        if (activityChart && chartData) {
            activityChart.data.labels = chartData.labels;
            activityChart.data.datasets[0].data = chartData.activity_data;
            activityChart.update('none');
        }
    }

    // Fonction pour mettre à jour la timeline d'activité
    function updateActivityTimeline(activities) {
        const timeline = document.getElementById('activity-timeline');
        timeline.innerHTML = '';

        activities.slice(0, 10).forEach(activity => {
            const timelineItem = createTimelineItem(activity);
            timeline.appendChild(timelineItem);
        });
    }

    // Fonction pour créer un élément de timeline
    function createTimelineItem(activity) {
        const div = document.createElement('div');
        div.className = 'flex space-x-3';

        const iconColor = getActionIconColor(activity.action);
        const icon = getActionIcon(activity.action);

        div.innerHTML = `
            <div class="flex-shrink-0">
                <div class="w-8 h-8 ${iconColor} rounded-full flex items-center justify-center">
                    ${icon}
                </div>
            </div>
            <div class="flex-1">
                <p class="text-sm text-gray-900">${getActionDescription(activity.action)}</p>
                <p class="text-xs text-gray-500">${activity.user_name || 'Système'} - ${activity.time}</p>
            </div>
        `;

        return div;
    }

    // Fonction pour mettre à jour le tableau d'activité
    function updateActivityTable(activities) {
        const tbody = document.getElementById('activity-table-body');
        tbody.innerHTML = '';

        activities.forEach(activity => {
            const row = createTableRow(activity);
            tbody.appendChild(row);
        });

        // Mettre à jour les informations du tableau
        document.getElementById('table-info').textContent =
            `Affichage de ${activities.length} activités récentes`;
    }

    // Fonction pour créer une ligne de tableau
    function createTableRow(activity) {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-gray-50';

        const initials = activity.user_name ?
            activity.user_name.split(' ').map(n => n[0]).join('').toUpperCase() : 'SY';

        tr.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${activity.time}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-8 w-8">
                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                            <span class="text-xs font-medium text-indigo-700">${initials}</span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">${activity.user_name || 'Système'}</p>
                        <p class="text-xs text-gray-500">${activity.user_email || ''}</p>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${getActionDescription(activity.action)}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${activity.description || '-'}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${activity.ip_address || '-'}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${activity.user_agent || '-'}</td>
        `;

        return tr;
    }

    // Fonctions utilitaires
    function getActionIconColor(action) {
        const colors = {
            'login': 'bg-green-100',
            'logout': 'bg-gray-100',
            'register': 'bg-blue-100',
            'download': 'bg-purple-100',
            'view': 'bg-yellow-100',
            'error': 'bg-red-100'
        };
        return colors[action] || 'bg-gray-100';
    }

    function getActionIcon(action) {
        const icons = {
            'login': '<svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>',
            'logout': '<svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>',
            'register': '<svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>',
            'download': '<svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" /></svg>',
            'view': '<svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>'
        };
        return icons[action] || '<svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
    }

    function getActionDescription(action) {
        const descriptions = {
            'login': 'Connexion',
            'logout': 'Déconnexion',
            'register': 'Inscription',
            'download': 'Téléchargement',
            'view': 'Consultation',
            'error': 'Erreur'
        };
        return descriptions[action] || action;
    }

    // Fonction debounce pour limiter les appels API
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
</script>
@endsection