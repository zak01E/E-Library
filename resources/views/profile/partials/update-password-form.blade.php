<section>

    <form method="post" action="{{ route('password.update') }}" class="space-y-3">
        @csrf
        @method('put')

        <div class="space-y-2">
            <div>
                <label for="update_password_current_password" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-0.5">Mot de passe actuel</label>
                <input id="update_password_current_password" name="current_password" type="password" class="w-full px-2.5 py-1 text-xs border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" />
                @if($errors->updatePassword->get('current_password'))
                    <p class="mt-1 text-xs text-red-600">{{ $errors->updatePassword->get('current_password')[0] }}</p>
                @endif
            </div>

            <div>
                <label for="update_password_password" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-0.5">Nouveau mot de passe</label>
                <input id="update_password_password" name="password" type="password" class="w-full px-2.5 py-1 text-xs border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" />
                @if($errors->updatePassword->get('password'))
                    <p class="mt-1 text-xs text-red-600">{{ $errors->updatePassword->get('password')[0] }}</p>
                @endif
            </div>

            <div>
                <label for="update_password_password_confirmation" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-0.5">Confirmer</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full px-2.5 py-1 text-xs border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" />
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="px-3 py-1 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-xs font-medium rounded-md transition">
                Modifier
            </button>
        </div>
    </form>
</section>