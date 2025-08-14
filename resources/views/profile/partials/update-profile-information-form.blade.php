<section>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('admin.profile.update') }}" class="space-y-3">
        @csrf
        @method('patch')

        <div class="space-y-2">
            <div>
                <label for="name" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-0.5">Nom</label>
                <input id="name" name="name" type="text" class="w-full px-2.5 py-1 text-xs border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" value="{{ old('name', $user->name) }}" required />
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-0.5">Email</label>
                <input id="email" name="email" type="email" class="w-full px-2.5 py-1 text-xs border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" value="{{ old('email', $user->email) }}" required />
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-0.5">Téléphone</label>
                <input id="phone" name="phone" type="tel" class="w-full px-2.5 py-1 text-xs border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" value="{{ old('phone', $user->phone) }}" />
                @error('phone')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="px-3 py-1 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-xs font-medium rounded-md transition">
                Enregistrer
            </button>
        </div>
    </form>
</section>