@props(['title', 'description', 'backRoute' => null, 'maxWidth' => '3xl'])

@php
    $maxWidthClass = match ($maxWidth) {
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        '5xl' => 'max-w-5xl',
        '6xl' => 'max-w-6xl',
        default => 'max-w-3xl',
    };
@endphp

<x-app-layout>
    <div class="{{ $maxWidthClass }} mx-auto py-12 px-4 sm:px-6 lg:px-8">
        @if ($backRoute)
            <div class="mb-6">
                <a href="{{ $backRoute }}"
                    class="inline-flex items-center gap-2 text-slate-500 font-semibold hover:text-[#764BA2] transition-colors group">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to List
                </a>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 overflow-hidden border border-slate-100">
            <div class="bg-[#e7e2ff] p-6 sm:p-8 border-b border-slate-100">
                <h2 class="text-2xl font-extrabold text-slate-800">{{ $title }}</h2>
                <p class="text-slate-500 text-sm font-medium mt-1">{{ $description }}</p>
            </div>

            {{ $slot }}
        </div>
    </div>
</x-app-layout>
