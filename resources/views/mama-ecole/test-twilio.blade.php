@extends('layouts.app')

@section('title', 'Test Twilio - Mama École')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-3xl font-bold mb-6">Test Twilio pour Mama École</h1>
        
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Configuration Twilio</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>Numéro Twilio : <strong>{{ env('TWILIO_NUMBER') }}</strong></p>
                        <p>Mode : <strong>{{ env('MAMA_ECOLE_MODE') }}</strong></p>
                        <p>SID configuré : <strong>{{ substr(env('TWILIO_SID'), 0, 10) }}...</strong></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Test d'appel vocal -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">1. Test d'Appel Vocal</h2>
            <form id="callForm" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Numéro à appeler (format international)</label>
                    <input type="text" name="phone_number" id="call_phone" 
                           placeholder="+33612345678 ou +2250700000000"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message à dire</label>
                    <textarea name="message" id="call_message" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Bonjour, ceci est un test de Mama École. Votre enfant a bien travaillé aujourd'hui.">Bonjour, ceci est un test de Mama École. Votre enfant a bien travaillé aujourd'hui.</textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Langue</label>
                    <select name="language" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="fr-FR">Français</option>
                        <option value="en-US">Anglais</option>
                    </select>
                </div>
                
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                    <i class="fas fa-phone mr-2"></i>Lancer l'Appel Test
                </button>
            </form>
            
            <div id="callResult" class="mt-4 hidden">
                <div class="bg-green-50 border-l-4 border-green-500 p-4">
                    <p class="text-green-700"></p>
                </div>
            </div>
        </div>

        <!-- Test SMS -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">2. Test SMS</h2>
            <form id="smsForm" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Numéro destinataire</label>
                    <input type="text" name="phone_number" id="sms_phone"
                           placeholder="+33612345678"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message SMS</label>
                    <textarea name="message" id="sms_message" rows="2" maxlength="160"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="MAMA ECOLE: Test SMS">MAMA ECOLE: Votre enfant a obtenu 15/20 en Maths. Félicitations!</textarea>
                    <p class="text-xs text-gray-500 mt-1">Maximum 160 caractères</p>
                </div>
                
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-sms mr-2"></i>Envoyer SMS Test
                </button>
            </form>
            
            <div id="smsResult" class="mt-4 hidden">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                    <p class="text-blue-700"></p>
                </div>
            </div>
        </div>

        <!-- Instructions pour Twilio -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <h3 class="font-semibold text-yellow-800 mb-2">⚠️ Configuration Twilio Console</h3>
            <ol class="list-decimal list-inside text-sm text-yellow-700 space-y-2">
                <li>Allez dans votre <a href="https://console.twilio.com" target="_blank" class="text-blue-600 underline">Console Twilio</a></li>
                <li>Dans Phone Numbers > Manage > Active Numbers</li>
                <li>Cliquez sur votre numéro (+1 217 882 0790)</li>
                <li>Dans "Voice Configuration", mettez :
                    <ul class="list-disc list-inside ml-4 mt-1">
                        <li>Webhook: <code class="bg-gray-100 px-1">{{ url('/mama-ecole/webhook/twiml') }}</code></li>
                        <li>Method: HTTP POST</li>
                    </ul>
                </li>
                <li>Dans "Messaging Configuration", mettez :
                    <ul class="list-disc list-inside ml-4 mt-1">
                        <li>Webhook: <code class="bg-gray-100 px-1">{{ url('/mama-ecole/webhook/sms') }}</code></li>
                        <li>Method: HTTP POST</li>
                    </ul>
                </li>
                <li>Cliquez sur "Save configuration"</li>
            </ol>
        </div>

        <!-- Logs -->
        <div class="mt-8">
            <h3 class="font-semibold mb-2">Logs d'activité</h3>
            <div id="logs" class="bg-gray-900 text-green-400 p-4 rounded-lg font-mono text-sm h-48 overflow-y-auto">
                <p>En attente d'actions...</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Logger
function addLog(message, type = 'info') {
    const logs = document.getElementById('logs');
    const time = new Date().toLocaleTimeString();
    const color = type === 'error' ? 'text-red-400' : type === 'success' ? 'text-green-400' : 'text-yellow-400';
    logs.innerHTML += `<p class="${color}">[${time}] ${message}</p>`;
    logs.scrollTop = logs.scrollHeight;
}

// Test Appel
document.getElementById('callForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const phone = document.getElementById('call_phone').value;
    const message = document.getElementById('call_message').value;
    
    if (!phone) {
        alert('Veuillez entrer un numéro de téléphone');
        return;
    }
    
    addLog('Lancement de l\'appel vers ' + phone + '...', 'info');
    
    try {
        const response = await fetch('{{ route("mama-ecole.test.call") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                phone_number: phone,
                message: message,
                language: this.language.value
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            addLog('✅ Appel lancé avec succès! SID: ' + result.call_sid, 'success');
            document.getElementById('callResult').classList.remove('hidden');
            document.querySelector('#callResult p').textContent = 'Appel en cours! Call SID: ' + result.call_sid;
        } else {
            addLog('❌ Erreur: ' + result.error, 'error');
            alert('Erreur: ' + result.error);
        }
    } catch (error) {
        addLog('❌ Erreur réseau: ' + error.message, 'error');
        alert('Erreur: ' + error.message);
    }
});

// Test SMS
document.getElementById('smsForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const phone = document.getElementById('sms_phone').value;
    const message = document.getElementById('sms_message').value;
    
    if (!phone) {
        alert('Veuillez entrer un numéro de téléphone');
        return;
    }
    
    addLog('Envoi SMS vers ' + phone + '...', 'info');
    
    try {
        const response = await fetch('{{ route("mama-ecole.test.sms") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                phone_number: phone,
                message: message
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            addLog('✅ SMS envoyé! SID: ' + result.message_sid, 'success');
            document.getElementById('smsResult').classList.remove('hidden');
            document.querySelector('#smsResult p').textContent = 'SMS envoyé avec succès! Message SID: ' + result.message_sid;
        } else {
            addLog('❌ Erreur: ' + result.error, 'error');
            alert('Erreur: ' + result.error);
        }
    } catch (error) {
        addLog('❌ Erreur réseau: ' + error.message, 'error');
        alert('Erreur: ' + error.message);
    }
});
</script>
@endpush

@endsection