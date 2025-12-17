<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Vexel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white text-gray-900">

    <div class="flex min-h-screen bg-white">

        <aside class="w-64 bg-[#F0F2FF] border-r border-indigo-50 flex flex-col fixed h-full z-30">

            <div class="h-24 flex items-center px-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/vexel-logo.png') }}" alt="Logo" class="w-8 h-8">
                    <span class="text-2xl font-bold text-[#764BA2] tracking-wide">Vexel</span>
                </a>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">

                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-xl transition-all group relative {{ request()->routeIs('dashboard') ? 'bg-white text-[#764BA2] shadow-sm font-bold' : 'text-gray-500 hover:text-[#764BA2] hover:bg-indigo-50 font-medium' }}">
                    @if (request()->routeIs('dashboard'))
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#764BA2] rounded-l-xl"></div>
                    @endif
                    <span>Dashboard</span>
                </a>

                @if (Route::has('rubrics.index'))
                    <a href="{{ route('rubrics.index') }}"
                        class="flex items-center px-4 py-3 rounded-xl transition-all group relative {{ request()->routeIs('rubrics*') ? 'bg-white text-[#764BA2] shadow-sm font-bold' : 'text-gray-500 hover:text-[#764BA2] hover:bg-indigo-50 font-medium' }}">
                        @if (request()->routeIs('rubrics*'))
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#764BA2] rounded-l-xl"></div>
                        @endif
                        <span>Rubrics</span>
                    </a>
                @endif

                @if (Route::has('assignments.index'))
                    <a href="{{ route('assignments.index') }}"
                        class="flex items-center px-4 py-3 rounded-xl transition-all group relative {{ request()->routeIs('assignments*') ? 'bg-white text-[#764BA2] shadow-sm font-bold' : 'text-gray-500 hover:text-[#764BA2] hover:bg-indigo-50 font-medium' }}">
                        @if (request()->routeIs('assignments*'))
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#764BA2] rounded-l-xl"></div>
                        @endif
                        <span>Assignments</span>
                    </a>
                @endif

                @if (Route::has('submissions.index'))
                    <a href="{{ route('submissions.index') }}"
                        class="flex items-center px-4 py-3 rounded-xl transition-all group relative {{ request()->routeIs('submissions*') ? 'bg-white text-[#764BA2] shadow-sm font-bold' : 'text-gray-500 hover:text-[#764BA2] hover:bg-indigo-50 font-medium' }}">
                        @if (request()->routeIs('submissions*'))
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#764BA2] rounded-l-xl"></div>
                        @endif
                        <span>Submissions</span>
                    </a>
                @endif

            </nav>

            <div class="p-6 border-t border-indigo-100 flex items-center justify-between gap-2"> <a
                    href="{{ route('profile.edit') }}" class="flex items-center gap-3 group">
                    <div
                        class="w-10 h-10 rounded-full bg-[#764BA2] text-white flex items-center justify-center font-bold text-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">View Profile</p>
                    </div>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                        title="Log Out">
                        {{-- Ikon Logout (Heroicons) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 ml-64 p-10 bg-white min-h-screen">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
