<x-index-layout title="Rubrics List" description="Create and organize rubrics for fair and structured grading.">
    <x-slot name="actions">
        <x-search-input :action="route('rubrics.index')" placeholder="Search rubrics..." />

        <x-primary-link-button :href="Route::has('rubrics.create') ? route('rubrics.create') : '#'">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create New Rubric
        </x-primary-link-button>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($rubrics ?? [] as $rubric)
            <div
                class="bg-[#EBEBFF] rounded-2xl p-6 relative hover:shadow-md transition-all group border border-indigo-50 min-h-[200px] flex flex-col justify-between">

                <div class="absolute top-4 right-4 flex gap-2 z-20">
                    <a href="{{ route('rubrics.edit', $rubric->id) }}"
                        class="w-8 h-8 flex items-center justify-center bg-[#D0D3F5] text-[#764BA2] rounded-lg hover:bg-[#764BA2] hover:text-white hover:scale-110 transition-all"
                        title="Edit Rubric">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </a>

                    <form id="delete-form-{{ $rubric->id }}" action="{{ route('rubrics.destroy', $rubric->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $rubric->id }})"
                            class="w-8 h-8 flex items-center justify-center bg-[#ffdede] text-red-500 rounded-lg hover:bg-red-500 hover:text-white hover:scale-110 transition-all"
                            title="Delete Rubric">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>

                <a href="{{ route('rubrics.show', $rubric->id) }}"
                    class="h-full flex flex-col justify-between relative z-10">
                    <div class="mb-4">
                        <div
                            class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mb-4 text-[#764BA2] shadow-sm">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>

                        <h3
                            class="text-lg font-bold text-gray-700 pr-16 mb-2 leading-tight group-hover:text-[#764BA2] transition-colors line-clamp-2">
                            {{ $rubric->subject_name }}
                        </h3>

                        @php
                            $criteriaData = is_string($rubric->criteria)
                                ? json_decode($rubric->criteria, true)
                                : $rubric->criteria;
                            $count = is_array($criteriaData) ? count($criteriaData) : 0;
                        @endphp
                        <div class="flex flex-wrap gap-2 mb-2">
                            <span
                                class="inline-block px-3 py-1 bg-white text-[#764BA2] text-[10px] font-black uppercase tracking-wider rounded-lg shadow-sm">
                                {{ $count }} Criteria
                            </span>
                            @if($rubric->assignment)
                            <span
                                class="inline-block px-3 py-1 bg-indigo-100 text-indigo-600 text-[10px] font-black uppercase tracking-wider rounded-lg shadow-sm">
                                {{ Str::limit($rubric->assignment->title, 20) }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <div
                        class="pt-4 border-t border-indigo-200/50 text-[10px] text-gray-400 font-bold uppercase tracking-widest flex justify-between items-center">
                        <span>Modified {{ $rubric->updated_at ? $rubric->updated_at->diffForHumans() : '-' }}</span>
                        <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity transform group-hover:translate-x-1"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-span-full py-16 text-center">
                <p class="text-gray-500">No Rubrics found.</p>
            </div>
        @endforelse
    </div>

    <x-toast-delete message="Are you sure you want to delete this rubric? This action cannot be undone." />
</x-index-layout>
