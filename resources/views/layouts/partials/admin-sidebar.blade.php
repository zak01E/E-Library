<div class="flex grow flex-col gap-y-5 overflow-y-auto bg-indigo-600 px-6 pb-4">
    <div class="flex h-16 shrink-0 items-center">
        <img class="h-8 w-auto" src="https://tailwindui.com/plus/img/logos/mark.svg?color=white" alt="E-Library">
        <span class="ml-3 text-xl font-semibold text-white">E-Library Admin</span>
    </div>
    <nav class="flex flex-1 flex-col">
        <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
                <ul role="list" class="-mx-2 space-y-1">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                            <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Tableau de bord
                        </a>
                    </li>

                    <!-- Gestion des utilisateurs -->
                    <li>
                        <div x-data="{ open: {{ request()->is('admin/users*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" type="button" class="text-indigo-200 hover:text-white hover:bg-indigo-700 group flex items-center w-full gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                Utilisateurs
                                <svg :class="open ? 'rotate-90 text-gray-400' : 'text-gray-300'" class="ml-auto h-5 w-5 shrink-0 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <ul x-show="open" x-transition class="mt-1 px-2">
                                <li>
                                    <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') && !request()->has('role') ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700' }} block rounded-md py-2 pr-2 pl-9 text-sm leading-6">
                                        Tous les utilisateurs
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.users', ['role' => 'admin']) }}" class="{{ request()->routeIs('admin.users') && request()->get('role') == 'admin' ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700' }} block rounded-md py-2 pr-2 pl-9 text-sm leading-6">
                                        Administrateurs
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.users', ['role' => 'author']) }}" class="{{ request()->routeIs('admin.users') && request()->get('role') == 'author' ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700' }} block rounded-md py-2 pr-2 pl-9 text-sm leading-6">
                                        Auteurs
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.users', ['role' => 'user']) }}" class="{{ request()->routeIs('admin.users') && request()->get('role') == 'user' ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700' }} block rounded-md py-2 pr-2 pl-9 text-sm leading-6">
                                        Utilisateurs standard
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Gestion des livres -->
                    <li>
                        <div x-data="{ open: {{ request()->is('admin/books*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" type="button" class="text-indigo-200 hover:text-white hover:bg-indigo-700 group flex items-center w-full gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                                Livres
                                <svg :class="open ? 'rotate-90 text-gray-400' : 'text-gray-300'" class="ml-auto h-5 w-5 shrink-0 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <ul x-show="open" x-transition class="mt-1 px-2">
                                <li>
                                    <a href="{{ route('admin.books') }}" class="{{ request()->routeIs('admin.books') && !request()->has('status') ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700' }} block rounded-md py-2 pr-2 pl-9 text-sm leading-6">
                                        Tous les livres
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.books', ['status' => 'pending']) }}" class="{{ request()->routeIs('admin.books') && request()->get('status') == 'pending' ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700' }} block rounded-md py-2 pr-2 pl-9 text-sm leading-6">
                                        En attente d'approbation
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.books', ['status' => 'approved']) }}" class="{{ request()->routeIs('admin.books') && request()->get('status') == 'approved' ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700' }} block rounded-md py-2 pr-2 pl-9 text-sm leading-6">
                                        Livres approuvés
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.books', ['status' => 'rejected']) }}" class="{{ request()->routeIs('admin.books') && request()->get('status') == 'rejected' ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700' }} block rounded-md py-2 pr-2 pl-9 text-sm leading-6">
                                        Livres rejetés
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Catégories -->
                    <li>
                        <div x-data="{ open: {{ request()->is('admin/categories*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" type="button" class="text-indigo-200 hover:text-white hover:bg-indigo-700 group flex items-center w-full gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 01-1.125-1.125v-3.75zM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-8.25zM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-2.25z" />
                                </svg>
                                Catégories
                                <svg :class="open ? 'rotate-90 text-gray-400' : 'text-gray-300'" class="ml-auto h-5 w-5 shrink-0 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <ul x-show="open" x-transition class="mt-1 px-2">
                                <li>
                                    <a href="{{ route('admin.categories.index') }}" class="text-indigo-200 hover:text-white hover:bg-indigo-700 block rounded-md py-2 pr-2 pl-9 text-sm leading-6">
                                        Toutes les catégories
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.categories.create') }}" class="text-indigo-200 hover:text-white hover:bg-indigo-700 block rounded-md py-2 pr-2 pl-9 text-sm leading-6">
                                        Ajouter une catégorie
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Rapports et Statistiques -->
                    <li>
                        <div x-data="{ open: {{ request()->is('admin/reports*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" type="button" class="text-indigo-200 hover:text-white hover:bg-indigo-700 group flex items-center w-full gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                                Rapports
                                <svg :class="open ? 'rotate-90 text-gray-400' : 'text-gray-300'" class="ml-auto h-5 w-5 shrink-0 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <ul x-show="open" x-transition class="mt-1 px-2">
                                <li>
                                    <a href="{{ route('admin.reports.downloads') }}" class="text-indigo-200 hover:text-white hover:bg-indigo-700 block rounded-md py-2 pr-2 pl-9 text-sm leading-6">
                                        Téléchargements
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.reports.users') }}" class="text-indigo-200 hover:text-white hover:bg-indigo-700 block rounded-md py-2 pr-2 pl-9 text-sm leading-6">
                                        Activité utilisateurs
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.reports.revenue') }}" class="text-indigo-200 hover:text-white hover:bg-indigo-700 block rounded-md py-2 pr-2 pl-9 text-sm leading-6">
                                        Revenus
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Paramètres -->
                    <li>
                        <div x-data="{ open: {{ request()->is('admin/settings*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" type="button" class="text-indigo-200 hover:text-white hover:bg-indigo-700 group flex items-center w-full gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Paramètres
                                <svg :class="open ? 'rotate-90 text-gray-400' : 'text-gray-300'" class="ml-auto h-5 w-5 shrink-0 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <ul x-show="open" x-transition class="mt-1 px-2">
                                <li>
                                    <a href="{{ route('admin.settings.general') }}" class="text-indigo-200 hover:text-white hover:bg-indigo-700 block rounded-md py-2 pr-2 pl-9 text-sm leading-6">
                                        Général
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.settings.email') }}" class="text-indigo-200 hover:text-white hover:bg-indigo-700 block rounded-md py-2 pr-2 pl-9 text-sm leading-6">
                                        Email
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.settings.storage') }}" class="text-indigo-200 hover:text-white hover:bg-indigo-700 block rounded-md py-2 pr-2 pl-9 text-sm leading-6">
                                        Stockage
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            
            <li class="mt-auto">
                <a href="{{ route('home') }}" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-indigo-200 hover:bg-indigo-700 hover:text-white">
                    <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    Retour au site
                </a>
            </li>
        </ul>
    </nav>
</div>