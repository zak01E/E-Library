@props([
    'active' => false,
    'href' => '#'
])

<li>
    <a
        href="{{ $href }}"
        @click.stop="
            // Maintenir le menu ouvert avant la navigation
            const currentPath = window.location.pathname;
            let menuToKeep = null;

            if (currentPath.includes('/author/books') || '{{ $href }}'.includes('/author/books')) {
                menuToKeep = 'books';
            } else if (currentPath.includes('/author/analytics') || '{{ $href }}'.includes('/author/analytics')) {
                menuToKeep = 'analytics';
            } else if (currentPath.includes('/author/revenue') || '{{ $href }}'.includes('/author/revenue')) {
                menuToKeep = 'revenue';
            } else if (currentPath.includes('/author/promotions') || '{{ $href }}'.includes('/author/promotions')) {
                menuToKeep = 'promotions';
            } else if (currentPath.includes('/author/tools') || '{{ $href }}'.includes('/author/tools')) {
                menuToKeep = 'tools';
            }

            if (menuToKeep) {
                localStorage.setItem('sidebarActiveMenu', menuToKeep);
            }
        "
        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ $active ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
    >
        {{ $slot }}
    </a>
</li>