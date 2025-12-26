@props([
    'title',
    'badge',
    'subtitle' => null,
    'subtitleIcon' => null,
    'backRoute' => null,
    'editRoute' => null,
    'deleteRoute' => null,
    'deleteConfirm' => 'Delete this item?',
    'maxWidth' => '5xl',
    'dateBadge' => null,
])

@php
    $maxWidthClass = match ($maxWidth) {
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        '5xl' => 'max-w-5xl',
        '6xl' => 'max-w-6xl',
        '7xl' => 'max-w-7xl',
        default => 'max-w-5xl',
    };
@endphp

<x-app-layout :title="$title">
    <div class="{{ $maxWidthClass }} mx-auto py-8 px-4 sm:px-6 lg:px-8">
        {{-- Back Link --}}
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

        {{-- Main Card --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 overflow-hidden border border-slate-100">
            {{-- Header --}}
            <div class="bg-[#F8F9FF] p-6 sm:p-8 border-b border-slate-100">
                <div class="flex justify-between items-start gap-4">
                    {{-- Title Section --}}
                    <div class="space-y-2 min-w-0 flex-1">
                        <span
                            class="inline-block bg-[#764BA2] text-white text-[10px] px-2.5 py-1 rounded-lg font-bold uppercase tracking-widest shadow-sm">
                            {{ $badge }}
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 break-words">{{ $title }}</h1>
                        @if ($subtitle)
                            <p class="text-slate-500 flex items-center gap-2 font-medium text-sm">
                                @if ($subtitleIcon)
                                    {!! $subtitleIcon !!}
                                @endif
                                {{ $subtitle }}
                            </p>
                        @endif
                    </div>

                    {{-- Actions Section --}}
                    <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                        @if ($dateBadge)
                            <span class="hidden sm:inline-block text-xs font-semibold text-slate-400 bg-slate-100 px-3 py-1.5 rounded-full">
                                {{ $dateBadge }}
                            </span>
                        @endif

                        @if (isset($headerActions))
                            {{ $headerActions }}
                        @endif

                        @if ($editRoute)
                            <a href="{{ $editRoute }}"
                                class="p-2 sm:p-2.5 bg-white rounded-xl shadow-sm text-slate-400 hover:text-[#764BA2] hover:shadow-md transition-all border border-slate-200"
                                title="Edit">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                        @endif

                        @if ($deleteRoute)
                            <form id="delete-form-show" action="{{ $deleteRoute }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('show')"
                                    class="p-2 sm:p-2.5 bg-white rounded-xl shadow-sm text-slate-400 hover:text-red-500 hover:shadow-md transition-all border border-slate-200"
                                    title="Delete">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6 sm:p-8">
                {{ $slot }}
            </div>
        </div>
    </div>

    @if (isset($scripts))
        {{ $scripts }}
    @endif

    <x-toast-delete :message="$deleteConfirm ?? 'Are you sure you want to delete this item? This action cannot be undone.'" />
</x-app-layout>
