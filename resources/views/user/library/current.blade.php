<x-user-dashboard-layout>
    <x-slot name="header">
        Mes emprunts actuels
    </x-slot>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-gray-500 text-sm">Livres empruntés</p>
                    <p class="text-2xl font-semibold text-gray-900">3</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-gray-500 text-sm">À rendre bientôt</p>
                    <p class="text-2xl font-semibold text-gray-900">1</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-gray-500 text-sm">Jours restants (moy.)</p>
                    <p class="text-2xl font-semibold text-gray-900">12</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Loans -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Livres actuellement empruntés</h3>
        </div>
        <div class="p-6">
            <div class="space-y-6">
                <!-- Book Item 1 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-20 bg-gray-300 rounded-md"></div>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">Le Petit Prince</h4>
                            <p class="text-sm text-gray-500">Antoine de Saint-Exupéry</p>
                            <div class="flex items-center mt-2 space-x-4">
                                <span class="text-sm text-gray-600">Emprunté le: 5 juillet 2025</span>
                                <span class="text-sm font-medium text-red-600">À rendre le: 20 juillet 2025</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-md hover:bg-blue-100">
                            Lire
                        </button>
                        <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                            Prolonger
                        </button>
                    </div>
                </div>

                <!-- Book Item 2 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-20 bg-gray-300 rounded-md"></div>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">1984</h4>
                            <p class="text-sm text-gray-500">George Orwell</p>
                            <div class="flex items-center mt-2 space-x-4">
                                <span class="text-sm text-gray-600">Emprunté le: 10 juillet 2025</span>
                                <span class="text-sm font-medium text-green-600">À rendre le: 25 juillet 2025</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-md hover:bg-blue-100">
                            Lire
                        </button>
                        <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                            Prolonger
                        </button>
                    </div>
                </div>

                <!-- Book Item 3 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-20 bg-gray-300 rounded-md"></div>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">L'Étranger</h4>
                            <p class="text-sm text-gray-500">Albert Camus</p>
                            <div class="flex items-center mt-2 space-x-4">
                                <span class="text-sm text-gray-600">Emprunté le: 15 juillet 2025</span>
                                <span class="text-sm font-medium text-green-600">À rendre le: 30 juillet 2025</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-md hover:bg-blue-100">
                            Lire
                        </button>
                        <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                            Prolonger
                        </button>
                    </div>
                </div>
            </div>

            <!-- Empty State (hidden when there are books) -->
            <div class="hidden text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun livre emprunté</h3>
                <p class="mt-1 text-sm text-gray-500">Commencez par parcourir notre catalogue.</p>
                <div class="mt-6">
                    <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Parcourir les livres
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-user-dashboard-layout>