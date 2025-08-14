<section>
    <div class="flex items-center space-x-3">
        <!-- Current Photo -->
        <div class="shrink-0">
            @if(Auth::user()->profile_photo)
                <img src="{{ Auth::user()->profile_photo_url }}" 
                     alt="{{ Auth::user()->name }}" 
                     class="h-14 w-14 object-cover rounded-full ring-2 ring-emerald-200 shadow">
            @else
                <div class="h-14 w-14 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full flex items-center justify-center text-white text-base font-bold ring-2 ring-emerald-200 shadow">
                    @php
                        $nameParts = explode(' ', Auth::user()->name);
                        $initials = strtoupper(substr($nameParts[0], 0, 1));
                        if(count($nameParts) > 1) {
                            $initials .= strtoupper(substr(end($nameParts), 0, 1));
                        }
                    @endphp
                    {{ $initials }}
                </div>
            @endif
        </div>

        <!-- Upload Form -->
        <div class="flex-1">
            <form method="POST" action="{{ route('admin.profile.photo.update') }}" enctype="multipart/form-data" class="flex items-center space-x-2">
                @csrf
                @method('PATCH')

                <label for="photo" class="relative cursor-pointer">
                    <span class="px-2.5 py-1 text-xs border border-gray-300 dark:border-gray-600 rounded-md inline-flex items-center hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                        <i class="fas fa-camera mr-1 text-xs"></i>
                        Changer
                    </span>
                    <input id="photo" name="profile_photo" type="file" class="sr-only" accept="image/*" onchange="this.form.submit()">
                </label>

                @if(Auth::user()->profile_photo)
                    <form method="POST" action="{{ route('admin.profile.photo.destroy') }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-500 text-xs">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                    </form>
                @endif
                
                <span class="text-xs text-gray-500">Max: 2MB</span>
            </form>

            @if ($errors->has('profile_photo'))
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">
                    {{ $errors->first('profile_photo') }}
                </p>
            @endif
        </div>
        </div>
    </div>

</section>