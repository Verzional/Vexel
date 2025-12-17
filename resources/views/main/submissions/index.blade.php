<x-app-layout>
    <div class="max-w-6xl mx-auto">
        
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Submissions List</h2>
                <p class="text-gray-500">Manage student submissions and AI grading results.</p>
            </div>
            
            <a href="{{ route('submissions.create') }}" 
               class="px-6 py-3 bg-[#764BA2] hover:bg-[#633e8a] text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-transform transform hover:-translate-y-0.5 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Upload New Submission
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($submissions as $submission)
                <div class="bg-[#EBEBFF] rounded-2xl p-6 relative hover:shadow-md transition-shadow group border border-indigo-50 min-h-[200px] flex flex-col justify-between">
                    
                    <div class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                        
                        <a href="{{ route('submissions.show', $submission->id) }}" 
                           class="w-8 h-8 flex items-center justify-center bg-white text-gray-600 rounded-lg shadow-sm hover:text-[#764BA2] hover:scale-110 transition-all"
                           title="View AI Result">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>

                        <a href="{{ route('submissions.edit', $submission->id) }}" 
                           class="w-8 h-8 flex items-center justify-center bg-[#D0D3F5] text-[#764BA2] rounded-lg hover:bg-[#764BA2] hover:text-white hover:scale-110 transition-all"
                           title="Edit Submission">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </a>

                        <form action="{{ route('submissions.destroy', $submission->id) }}" method="POST" onsubmit="return confirm('Delete this submission?');">
                            @csrf @method('DELETE')
                            <button type="submit" 
                                    class="w-8 h-8 flex items-center justify-center bg-[#ffdede] text-red-500 rounded-lg hover:bg-red-500 hover:text-white hover:scale-110 transition-all"
                                    title="Delete">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>

                    <a href="{{ route('submissions.show', $submission->id) }}" class="block">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mb-4 text-[#764BA2] shadow-sm">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mb-1 pr-16 leading-tight group-hover:text-[#764BA2] transition-colors">
                            {{ $submission->assignment->title ?? 'Unknown Assignment' }}
                        </h3>
                        
                        <p class="text-sm text-gray-600 font-medium mb-4 flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            {{ $submission->student_name }}
                        </p>

                        <div class="pt-4 border-t border-indigo-200/50 text-xs text-gray-400 font-medium flex justify-between items-center">
                            <span>Uploaded {{ $submission->created_at->diffForHumans() }}</span>
                            
                            @if($submission->extracted_text)
                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-[10px] font-bold">GRADED</span>
                            @else
                                <span class="bg-gray-200 text-gray-500 px-2 py-0.5 rounded text-[10px] font-bold">PENDING</span>
                            @endif
                        </div>
                    </a>

                </div>
            @empty
                <div class="col-span-full py-16 text-center">
                    <div class="bg-gray-50 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                    </div>
                    <p class="text-gray-500 font-medium">No submissions found.</p>
                    <p class="text-gray-400 text-sm mt-1">Upload a PDF to start grading.</p>
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>