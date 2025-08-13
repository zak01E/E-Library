@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 to-yellow-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-orange-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <div class="bg-orange-500 p-3 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">MAMA ÉCOLE</h1>
                        <p class="text-sm text-gray-600">Système d'Inclusion des Parents Illettrés</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">{{ now()->format('d/m/Y H:i') }}</span>
                    <button class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">
                        <i class="fas fa-phone-alt mr-2"></i>Nouveau Message
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Parents -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Parents Inscrits</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_parents']) }}</p>
                        <p class="text-xs text-green-600 mt-2">
                            <i class="fas fa-arrow-up mr-1"></i>+15% ce mois
                        </p>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-full">
                        <i class="fas fa-users text-orange-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Parents Illettrés -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Parents Illettrés</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['illiterate_parents']) }}</p>
                        <p class="text-xs text-gray-500 mt-2">
                            {{ round(($stats['illiterate_parents'] / max($stats['total_parents'], 1)) * 100) }}% du total
                        </p>
                    </div>
                    <div class="bg-teal-100 p-3 rounded-full">
                        <i class="fas fa-phone-volume text-teal-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Appels Aujourd'hui -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Appels Aujourd'hui</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['calls_today']) }}</p>
                        <p class="text-xs text-blue-600 mt-2">
                            <i class="fas fa-clock mr-1"></i>Dernier il y a 5 min
                        </p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-phone text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Taux Engagement -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Taux Engagement</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['engagement_rate'] }}%</p>
                        <p class="text-xs text-green-600 mt-2">
                            <i class="fas fa-chart-line mr-1"></i>Excellent
                        </p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-chart-pie text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Language Distribution -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-language mr-2 text-orange-500"></i>Distribution par Langue
                </h2>
                <div class="space-y-4">
                    @foreach($stats['languages'] as $language)
                    @php
                        $percentage = ($language->total / max($stats['total_parents'], 1)) * 100;
                        $colors = [
                            'french' => 'bg-blue-500',
                            'dioula' => 'bg-orange-500',
                            'baoule' => 'bg-teal-500',
                            'bete' => 'bg-green-500',
                            'senoufo' => 'bg-red-500'
                        ];
                        $color = $colors[$language->preferred_language] ?? 'bg-gray-500';
                    @endphp
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700 capitalize">{{ $language->preferred_language }}</span>
                            <span class="text-sm text-gray-500">{{ number_format($language->total) }} parents ({{ round($percentage) }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="{{ $color }} h-3 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Success Metrics -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-trophy mr-2 text-yellow-500"></i>Métriques de Succès
                </h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b">
                        <span class="text-sm text-gray-600">Amélioration Présence</span>
                        <span class="text-lg font-bold text-green-600">{{ $stats['success_metrics']['attendance_improvement'] }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b">
                        <span class="text-sm text-gray-600">Amélioration Notes</span>
                        <span class="text-lg font-bold text-blue-600">{{ $stats['success_metrics']['grade_improvement'] }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b">
                        <span class="text-sm text-gray-600">Réduction Abandon</span>
                        <span class="text-lg font-bold text-teal-600">{{ $stats['success_metrics']['dropout_reduction'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Satisfaction Parents</span>
                        <span class="text-lg font-bold text-orange-600">{{ $stats['success_metrics']['parent_satisfaction'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Calls & Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Calls -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-history mr-2 text-blue-500"></i>Appels Récents
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2 text-gray-600">Parent</th>
                                <th class="text-left py-2 text-gray-600">Téléphone</th>
                                <th class="text-left py-2 text-gray-600">Type</th>
                                <th class="text-left py-2 text-gray-600">Langue</th>
                                <th class="text-left py-2 text-gray-600">Heure</th>
                                <th class="text-left py-2 text-gray-600">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stats['recent_calls'] as $call)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2">{{ $call->name ?? 'Parent #' . $call->parent_id }}</td>
                                <td class="py-2">{{ $call->phone_number }}</td>
                                <td class="py-2">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($call->message_type == 'grades') bg-blue-100 text-blue-700
                                        @elseif($call->message_type == 'absence') bg-red-100 text-red-700
                                        @elseif($call->message_type == 'meeting') bg-teal-100 text-purple-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        {{ ucfirst($call->message_type) }}
                                    </span>
                                </td>
                                <td class="py-2 capitalize">{{ $call->language }}</td>
                                <td class="py-2">{{ \Carbon\Carbon::parse($call->created_at)->format('H:i') }}</td>
                                <td class="py-2">
                                    @if($call->call_status == 'completed')
                                        <i class="fas fa-check-circle text-green-500"></i>
                                    @elseif($call->call_status == 'failed')
                                        <i class="fas fa-times-circle text-red-500"></i>
                                    @else
                                        <i class="fas fa-clock text-yellow-500"></i>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-bolt mr-2 text-yellow-500"></i>Actions Rapides
                </h2>
                <div class="space-y-3">
                    <button onclick="openNotificationModal('grades')" class="w-full bg-blue-500 text-white py-3 px-4 rounded-lg hover:bg-blue-600 transition flex items-center justify-between">
                        <span><i class="fas fa-graduation-cap mr-2"></i>Envoyer Notes</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    <button onclick="openNotificationModal('absence')" class="w-full bg-red-500 text-white py-3 px-4 rounded-lg hover:bg-red-600 transition flex items-center justify-between">
                        <span><i class="fas fa-user-times mr-2"></i>Signaler Absence</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    <button onclick="openNotificationModal('meeting')" class="w-full bg-teal-500 text-white py-3 px-4 rounded-lg hover:bg-teal-600 transition flex items-center justify-between">
                        <span><i class="fas fa-calendar mr-2"></i>Convoquer Réunion</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    <button onclick="openNotificationModal('urgent')" class="w-full bg-orange-500 text-white py-3 px-4 rounded-lg hover:bg-orange-600 transition flex items-center justify-between">
                        <span><i class="fas fa-exclamation-triangle mr-2"></i>Message Urgent</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>

                <div class="mt-6 pt-6 border-t">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Outils</h3>
                    <div class="space-y-2">
                        <a href="{{ route('mama-ecole.analytics') }}" class="block text-sm text-gray-600 hover:text-orange-600">
                            <i class="fas fa-chart-line mr-2"></i>Analytics Détaillés
                        </a>
                        <a href="{{ route('mama-ecole.parents') }}" class="block text-sm text-gray-600 hover:text-orange-600">
                            <i class="fas fa-user-plus mr-2"></i>Inscrire Parent
                        </a>
                        <a href="{{ route('mama-ecole.templates') }}" class="block text-sm text-gray-600 hover:text-orange-600">
                            <i class="fas fa-file-alt mr-2"></i>Gérer Templates
                        </a>
                        <a href="{{ route('mama-ecole.campaigns') }}" class="block text-sm text-gray-600 hover:text-orange-600">
                            <i class="fas fa-bullhorn mr-2"></i>Campagnes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notification Modal -->
<div id="notificationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-2xl">
        <h3 class="text-xl font-bold mb-4">Envoyer Notification</h3>
        <form id="notificationForm">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Classe</label>
                    <select name="class_id" class="w-full border rounded-lg px-3 py-2">
                        <option value="1">6ème A</option>
                        <option value="2">6ème B</option>
                        <option value="3">5ème A</option>
                    </select>
                </div>
                
                <div id="messageFields"></div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeNotificationModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                        <i class="fas fa-paper-plane mr-2"></i>Envoyer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function openNotificationModal(type) {
    document.getElementById('notificationModal').classList.remove('hidden');
    
    // Dynamically set fields based on type
    const fieldsContainer = document.getElementById('messageFields');
    
    if (type === 'grades') {
        fieldsContainer.innerHTML = `
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Matière</label>
                <input type="text" name="subject" class="w-full border rounded-lg px-3 py-2" placeholder="Ex: Mathématiques">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Commentaire</label>
                <textarea name="comment" class="w-full border rounded-lg px-3 py-2" rows="3" placeholder="Commentaire optionnel"></textarea>
            </div>
        `;
    } else if (type === 'meeting') {
        fieldsContainer.innerHTML = `
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" name="date" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Heure</label>
                    <input type="time" name="time" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Objet de la réunion</label>
                <input type="text" name="subject" class="w-full border rounded-lg px-3 py-2">
            </div>
        `;
    }
}

function closeNotificationModal() {
    document.getElementById('notificationModal').classList.add('hidden');
}
</script>
@endsection