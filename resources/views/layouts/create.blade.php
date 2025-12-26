@props(['title', 'description', 'backRoute' => null, 'maxWidth' => '3xl'])

@php
    $maxWidthClass = match ($maxWidth) {
        '3xl' => 'max-w-3xl',
        '5xl' => 'max-w-5xl',
        default => 'max-w-3xl',
    };
@endphp

<x-app-layout :title="$title">
    <div class="{{ $maxWidthClass }} mx-auto py-12 px-4 sm:px-6 lg:px-8">
        @if($backRoute)
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

        <div class="bg-white rounded-3xl shadow-xl shadow-indigo-100 overflow-hidden border border-indigo-50">
            <div class="bg-[#764BA2] p-6 sm:p-8 text-white text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>

                <h2 class="text-2xl font-bold relative z-10">{{ $title }}</h2>
                <p class="opacity-80 relative z-10 text-sm">{{ $description }}</p>
            </div>

            {{ $slot }}
        </div>
    </div>
</x-app-layout>
