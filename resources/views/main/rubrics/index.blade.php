<x-app-layout>
    
    <div class="flex flex-col sm:flex-row justify-end items-center gap-4 mb-8">
        
        <div class="relative w-full sm:w-80">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" placeholder="Search rubrics..." 
                   class="w-full py-2.5 pl-10 pr-4 bg-gray-50 border border-gray-200 text-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#764BA2] focus:border-transparent transition-all placeholder-gray-400">
        </div>
    </div>

    <a href="{{ Route::has('rubrics.create') ? route('rubrics.create') : '#' }}" 
       class="block w-full py-4 bg-[#8B5CF6] hover:bg-[#7c4dff] text-white rounded-xl shadow-lg shadow-purple-200 transition-all transform hover:-translate-y-0.5 mb-10 flex items-center justify-center gap-2 group">
        <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <span class="text-lg font-bold">Create New Rubric</span>
    </a>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        @forelse($rubrics ?? [] as $rubric)
            <div class="bg-[#EBEBFF] rounded-2xl p-6 relative hover:shadow-md transition-shadow group border border-indigo-50/50">
                
                <div class="absolute top-4 right-4 flex gap-2 z-10">
                    
                    <a href="{{ route('rubrics.show', $rubric->id) }}" 
                       class="w-8 h-8 flex items-center justify-center bg-white text-gray-600 rounded-lg shadow-sm border border-gray-100 hover:text-[#764BA2] hover:border-[#764BA2] transition-colors"
                       title="View Detail">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>

                    <a href="{{ Route::has('rubrics.edit') ? route('rubrics.edit', $rubric->id) : '#' }}" 
                       class="w-8 h-8 flex items-center justify-center bg-[#D0D3F5] text-[#764BA2] rounded-lg hover:bg-[#764BA2] hover:text-white transition-colors"
                       title="Edit Rubric">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </a>

                    <form action="{{ route('rubrics.destroy', $rubric->id) }}" method="POST" onsubmit="return confirm('Delete this rubric?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-8 h-8 flex items-center justify-center bg-[#ffdede] text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition-colors"
                                title="Delete Rubric">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>

                </div>

                <a href="{{ route('rubrics.show', $rubric->id) }}" class="hover:underline decoration-[#764BA2] decoration-2 underline-offset-2">
                    <h3 class="text-lg font-bold text-gray-900 pr-24 mb-3 leading-tight min-h-[3rem]">
                        {{ $rubric->subject_name }}
                    </h3>
                </a>

                <div class="mb-8">
                    @php
                        $criteriaData = is_string($rubric->criteria) ? json_decode($rubric->criteria, true) : $rubric->criteria;
                        $count = is_array($criteriaData) ? count($criteriaData) : 0;
                    @endphp
                    <span class="inline-block px-3 py-1 bg-[#D0D3F5] text-[#764BA2] text-xs font-bold rounded-full">
                        {{ $count }} Criteria
                    </span>
                </div>

                <div class="text-gray-400 text-sm font-medium">
                    Last Modified: {{ $rubric->updated_at ? $rubric->updated_at->diffForHumans() : '-' }}
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-12 text-center">
                <div class="p-4 bg-gray-50 rounded-full mb-3">
                    <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">No rubrics found.</p>
                <p class="text-gray-400 text-sm mt-1">Get started by creating a new rubric.</p>
            </div>
        @endforelse

    </div>
</x-app-layout>