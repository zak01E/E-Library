<section>
    <header class="mb-4">
        <h2 class="text-base font-medium text-gray-900 dark:text-white">
            {{ __('Photo de profil') }}
        </h2>
    </header>

    <div class="space-y-4">
        <!-- Current Photo Display - Compact -->
        <div class="flex items-center space-x-3">
            <img id="current-photo" class="h-12 w-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600"
                 src="{{ $user->profile_photo_url }}"
                 alt="{{ $user->name }}">
            <div class="flex-1 min-w-0">
                @if($user->profile_photo)
                    <div class="text-xs text-green-600 dark:text-green-400">
                        <i class="fas fa-check-circle mr-1"></i>Photo personnalisée
                    </div>
                @else
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        <i class="fas fa-user-circle mr-1"></i>Avatar par défaut
                    </div>
                @endif
            </div>
        </div>

        <!-- Upload Form - Compact -->
        <form method="post" action="{{ auth()->user()->role === 'author' && request()->routeIs('author.profile.edit') ? route('author.profile.photo.update') : route('profile.photo.update') }}" enctype="multipart/form-data" class="space-y-3">
            @csrf
            @method('patch')

            <div>
                <input type="file"
                       id="profile_photo"
                       name="profile_photo"
                       accept="image/*"
                       class="block w-full text-xs text-gray-500 dark:text-gray-400
                              file:mr-2 file:py-1 file:px-2
                              file:rounded file:border-0
                              file:text-xs file:font-medium
                              file:bg-indigo-50 file:text-indigo-700
                              hover:file:bg-indigo-100
                              dark:file:bg-indigo-900 dark:file:text-indigo-300
                              dark:hover:file:bg-indigo-800"
                       onchange="previewImage(this)">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    PNG, JPG, GIF jusqu'à 2MB
                </p>
                <x-input-error class="mt-1" :messages="$errors->get('profile_photo')" />
            </div>

            <!-- Preview - Compact -->
            <div id="photo-preview" class="hidden">
                <img id="preview-image" class="h-12 w-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600" src="#" alt="Aperçu">
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition-colors">
                    {{ __('Mettre à jour') }}
                </button>

                @if (session('status') === 'profile-photo-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-xs text-green-600 dark:text-green-400"
                    >{{ __('Mis à jour') }}</p>
                @endif
            </div>
        </form>

        <!-- Remove Photo Form - Compact -->
        @if($user->profile_photo)
            <form method="post" action="{{ auth()->user()->role === 'author' && request()->routeIs('author.profile.edit') ? route('author.profile.photo.destroy') : route('profile.photo.destroy') }}" class="pt-2 border-t border-gray-200 dark:border-gray-700">
                @csrf
                @method('delete')

                <button type="button"
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-photo-deletion')"
                        class="px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition-colors">
                    {{ __('Supprimer') }}
                </button>
            </form>

            <!-- Confirmation Modal -->
            <x-modal name="confirm-photo-deletion" focusable>
                <form method="post" action="{{ auth()->user()->role === 'author' && request()->routeIs('author.profile.edit') ? route('author.profile.photo.destroy') : route('profile.photo.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                        {{ __('Êtes-vous sûr de vouloir supprimer votre photo de profil ?') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Votre photo de profil sera supprimée et remplacée par l\'avatar par défaut.') }}
                    </p>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Annuler') }}
                        </x-secondary-button>

                        <x-danger-button class="ml-3">
                            {{ __('Supprimer la photo') }}
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        @endif
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('photo-preview');
            const previewImage = document.getElementById('preview-image');
            const currentPhoto = document.getElementById('current-photo');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.classList.add('hidden');
            }
        }
    </script>
</section>
