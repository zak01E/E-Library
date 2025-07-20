@props([
    'active' => false,
    'icon' => null,
    'href' => '#',
    'submenu' => false,
    'menuId' => null
])

@if($submenu)
    <!-- Menu avec sous-menu -->
    <li>
        <button
            @click="toggleSubmenu('{{ $menuId }}')"
            class="flex items-center justify-between w-full p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 group {{ $active ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
        >
            <div class="flex items-center">
                @if($icon)
                    <span class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                        {!! $icon !!}
                    </span>
                @endif
                <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ $slot }}</span>
            </div>
            <svg 
                :class="{'rotate-180': activeMenu === '{{ $menuId }}'}"
                class="w-4 h-4 transition-transform duration-200"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        
        <!-- Sous-menu -->
        <ul
            x-show="activeMenu === '{{ $menuId }}' || {{ $active ? 'true' : 'false' }}"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2"
            class="py-2 space-y-2"
            x-init="
                // Si ce menu est actif au chargement, l'ouvrir automatiquement
                if ({{ $active ? 'true' : 'false' }}) {
                    activeMenu = '{{ $menuId }}';
                }
            "
        >
            {{ $submenuContent ?? '' }}
        </ul>
    </li>
@else
    <!-- Menu simple -->
    <li>
        <a 
            href="{{ $href }}"
            class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 group {{ $active ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
        >
            @if($icon)
                <span class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                    {!! $icon !!}
                </span>
            @endif
            <span class="flex-1 ml-3 whitespace-nowrap">{{ $slot }}</span>
            @if(isset($badge))
                <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                    {{ $badge }}
                </span>
            @endif
        </a>
    </li>
@endif