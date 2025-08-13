@extends('layouts.author-dashboard')

@section('content')
    <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-2xl font-bold text-blue-600">{{ $total_engagement['downloads'] }}</div>
                    <div class="text-gray-600">Total téléchargements</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-2xl font-bold text-green-600">{{ $total_engagement['views'] }}</div>
                    <div class="text-gray-600">Total vues</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-2xl font-bold text-teal-600">{{ number_format($total_engagement['avg_downloads'], 1) }}</div>
                    <div class="text-gray-600">Moyenne téléchargements</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-2xl font-bold text-teal-600">{{ number_format($total_engagement['avg_views'], 1) }}</div>
                    <div class="text-gray-600">Moyenne vues</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6">Performance détaillée par livre</h3>
                    
                    @if($books->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Titre
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Vues
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Téléchargements
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Taux de conversion
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date de publication
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Performance
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($books as $book)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $book->title }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $book->views }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $book->downloads }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    @if($book->views > 0)
                                                        {{ number_format(($book->downloads / $book->views) * 100, 1) }}%
                                                    @else
                                                        0%
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $book->created_at->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-1">
                                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                                            @php
                                                                $maxDownloads = max(1, $books->max('downloads'));
                                                                $percentage = ($book->downloads / $maxDownloads) * 100;
                                                            @endphp
                                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                                        </div>
                                                    </div>
                                                    <span class="ml-2 text-xs text-gray-600">{{ number_format($percentage, 0) }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h4 class="text-lg font-semibold mb-4">Top 3 livres les plus vus</h4>
                                <div class="space-y-3">
                                    @foreach($books->sortByDesc('views')->take(3) as $index => $book)
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <span class="text-2xl font-bold text-gray-400 mr-3">#{{ $index + 1 }}</span>
                                                <div>
                                                    <p class="font-medium">{{ Str::limit($book->title, 30) }}</p>
                                                    <p class="text-sm text-gray-600">{{ $book->views }} vues</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h4 class="text-lg font-semibold mb-4">Top 3 livres les plus téléchargés</h4>
                                <div class="space-y-3">
                                    @foreach($books->sortByDesc('downloads')->take(3) as $index => $book)
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <span class="text-2xl font-bold text-gray-400 mr-3">#{{ $index + 1 }}</span>
                                                <div>
                                                    <p class="font-medium">{{ Str::limit($book->title, 30) }}</p>
                                                    <p class="text-sm text-gray-600">{{ $book->downloads }} téléchargements</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune donnée analytique</h3>
                            <p class="mt-1 text-sm text-gray-500">Publiez des livres pour voir vos statistiques.</p>
                        </div>
                    @endif
                </div>
        </div>
    </div>
@endsection