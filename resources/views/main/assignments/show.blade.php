<x-app-layout>
    <div class="max-w-4xl mx-auto">
        
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('assignments.index') }}" class="flex items-center text-gray-500 hover:text-[#764BA2] font-bold transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to List
            </a>

            <div class="flex gap-2">
                <a href="{{ route('assignments.edit', $assignment->id) }}" class="px-4 py-2 bg-indigo-50 text-[#764BA2] rounded-lg font-bold hover:bg-indigo-100 transition-colors">
                    Edit
                </a>
                <form action="{{ route('assignments.destroy', $assignment->id) }}" method="POST" onsubmit="return confirm('Delete this assignment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-50 text-red-500 rounded-lg font-bold hover:bg-red-100 transition-colors">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-indigo-100 overflow-hidden border border-indigo-50">
            
            <div class="bg-gradient-to-r from-[#667EEA] to-[#764BA2] p-8 text-white">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">{{ $assignment->title }}</h1>
                        <p class="text-indigo-100 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            Created on {{ $assignment->created_at->format('l, d F Y') }}
                        </p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-2xl">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    </div>
                </div>
            </div>

            <div class="p-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-3 border-b border-gray-100 pb-2">Description</h3>
                        <div class="prose text-gray-600 leading-relaxed">
                            {{ $assignment->description ?? 'No description provided.' }}
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 h-fit border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Grading Criteria</h3>
                    
                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-4">
                        <div class="text-xs text-gray-500 mb-1">Rubric Name</div>
                        <div class="font-bold text-[#764BA2] text-lg">
                            {{ $assignment->rubric->subject_name ?? 'Unknown' }}
                        </div>
                    </div>

                    <a href="{{ route('rubrics.show', $assignment->rubric_id) }}" class="block w-full py-2.5 text-center bg-[#EBEBFF] text-[#764BA2] font-bold rounded-xl hover:bg-[#dadaff] transition-colors text-sm">
                        View Full Rubric
                    </a>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>