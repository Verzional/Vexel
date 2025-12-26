@props(['title', 'description', 'maxWidth' => '7xl'])

@php
    $maxWidthClass = match ($maxWidth) {
        '3xl' => 'max-w-3xl',
        '5xl' => 'max-w-5xl',
        '7xl' => 'max-w-7xl',
        'full' => 'max-w-full',
        default => 'max-w-7xl',
    };
@endphp

<x-app-layout :title="$title">
    <div class="{{ $maxWidthClass }} mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">
            <div class="flex-1">
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">{{ $title }}</h2>
                <p class="text-gray-500 mt-2 text-lg">{{ $description }}</p>
            </div>

            @if(isset($actions))
                <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto items-center">
                    {{ $actions }}
                </div>
            @endif
        </div>

        {{ $slot }}
    </div>
</x-app-layout>
