<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'Vexel' . ($title ? " - $title" : '') ?? config('app.name', 'Vexel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white text-gray-900" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen bg-white">

        <!-- Mobile Backdrop -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/80 z-40 lg:hidden" style="display: none;"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-[#F0F2FF] border-r border-indigo-50 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 lg:fixed lg:inset-y-0">

            <div class="h-24 flex items-center px-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo_vexel.webp') }}" alt="Vexel Logo" class="h-10 w-auto">
                </a>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">

                <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <span>Dashboard</span>
                </x-sidebar-link>

                @if (Route::has('rubrics.index'))
                    <x-sidebar-link :href="route('rubrics.index')" :active="request()->routeIs('rubrics*')">
                        <span>Rubrics</span>
                    </x-sidebar-link>
                @endif

                @if (Route::has('assignments.index'))
                    <x-sidebar-link :href="route('assignments.index')" :active="request()->routeIs('assignments*')">
                        <span>Assignments</span>
                    </x-sidebar-link>
                @endif

                @if (Route::has('submissions.index'))
                    <x-sidebar-link :href="route('submissions.index')" :active="request()->routeIs('submissions*')">
                        <span>Submissions</span>
                    </x-sidebar-link>
                @endif

            </nav>

            <div class="mt-auto p-6 border-t border-indigo-100 flex items-center justify-between gap-2">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 group flex-1 min-w-0">
                    <div
                        class="w-10 h-10 rounded-full bg-[#764BA2] text-white flex items-center justify-center font-bold text-lg shrink-0">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">View Profile</p>
                    </div>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                    @csrf
                    <button type="submit"
                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                        title="Log Out">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-h-screen lg:ml-64 transition-all duration-300">

            <!-- Mobile Header -->
            <header
                class="flex items-center justify-between p-4 bg-white border-b border-gray-100 lg:hidden sticky top-0 z-20">
                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none p-2 rounded-md hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo_vexel.webp') }}" alt="Vexel Logo" class="h-8 w-auto">
                </div>
                <div class="w-10"></div> <!-- Spacer for balance -->
            </header>

            <main class="flex-1 p-4 sm:p-10 bg-white">
                {{ $slot }}
            </main>
        </div>
    </div>

    @if (session('success'))
        <x-toast :message="session('success')" type="success" />
    @endif
    @if (session('error'))
        <x-toast :message="session('error')" type="error" />
    @endif
</body>

</html>
