@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Analytics - Téléchargements</h1>
            <p class="text-gray-600 dark:text-gray-400">Analysez les téléchargements de vos livres</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('author.analytics') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Retour aux analytics
            </a>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-download mr-2"></i>Exporter
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <i class="fas fa-download text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Total</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_downloads']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                    <i class="fas fa-calendar-month text-green-600 dark:text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Ce mois</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['this_month'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                    <i class="fas fa-calendar-week text-purple-600 dark:text-purple-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Cette semaine</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['this_week'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-lg">
                    <i class="fas fa-calendar-day text-orange-600 dark:text-orange-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Aujourd'hui</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['today'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                    <i class="fas fa-chart-bar text-yellow-600 dark:text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Moyenne/livre</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['avg_per_book'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Daily Downloads Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Téléchargements cette semaine</h3>
            <div class="h-64">
                <canvas id="dailyDownloadsChart"></canvas>
            </div>
        </div>

        <!-- Top Books -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Livres les plus téléchargés</h3>
            <div class="space-y-3">
                @forelse($bookDownloads->take(5) as $index => $book)
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="flex items-center">
                        <span class="w-6 h-6 bg-blue-100 text-blue-800 text-xs rounded-full flex items-center justify-center mr-3">
                            {{ $index + 1 }}
                        </span>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white text-sm">{{ Str::limit($book->title, 30) }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-blue-600">{{ number_format($book->downloads) }}</p>
                        <p class="text-xs text-gray-500">téléchargements</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-book text-3xl mb-3"></i>
                    <p>Aucun livre publié</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Detailed Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Détail par livre</h3>
                <div class="flex space-x-2">
                    <select class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700">
                        <option>Tous les livres</option>
                        <option>30 derniers jours</option>
                        <option>7 derniers jours</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Livre</th>
                        <th class="px-6 py-3 text-center font-medium text-gray-700 dark:text-gray-300">Total</th>
                        <th class="px-6 py-3 text-center font-medium text-gray-700 dark:text-gray-300">Ce mois</th>
                        <th class="px-6 py-3 text-center font-medium text-gray-700 dark:text-gray-300">Cette semaine</th>
                        <th class="px-6 py-3 text-center font-medium text-gray-700 dark:text-gray-300">Aujourd'hui</th>
                        <th class="px-6 py-3 text-center font-medium text-gray-700 dark:text-gray-300">Tendance</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @forelse($bookDownloads as $book)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-12 bg-gray-200 dark:bg-gray-600 rounded mr-3 flex items-center justify-center">
                                    <i class="fas fa-book text-gray-400"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $book->title }}</p>
                                    <p class="text-xs text-gray-500">Publié récemment</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-lg font-bold text-blue-600">{{ number_format($book->downloads) }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-medium text-gray-900 dark:text-white">{{ rand(5, 25) }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-medium text-gray-900 dark:text-white">{{ rand(1, 8) }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-medium text-gray-900 dark:text-white">{{ rand(0, 3) }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php $trend = rand(1, 3); @endphp
                            @if($trend == 1)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                    <i class="fas fa-arrow-up"></i> +{{ rand(5, 20) }}%
                                </span>
                            @elseif($trend == 2)
                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">
                                    <i class="fas fa-arrow-down"></i> -{{ rand(2, 10) }}%
                                </span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">
                                    <i class="fas fa-minus"></i> Stable
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-book text-4xl mb-4"></i>
                            <p>Aucun livre publié</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Daily Downloads Chart
const ctx = document.getElementById('dailyDownloadsChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($dailyDownloads['labels']) !!},
        datasets: [{
            label: 'Téléchargements',
            data: {!! json_encode($dailyDownloads['data']) !!},
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
</script>
@endsection