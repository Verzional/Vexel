<x-app-layout>
    <div class="max-w-6xl mx-auto">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Analysis Result</h1>
                <p class="text-gray-500">Review the AI grading below.</p>
            </div>
            
            <div class="flex gap-3">
                <form action="{{ route('submissions.destroy', $submission->id) }}" method="POST" onsubmit="return confirm('Discard this result?');">
                    @csrf @method('DELETE')
                    <button class="px-4 py-3 bg-red-50 text-red-600 rounded-xl font-bold hover:bg-red-100 transition-colors">
                        Discard / Delete
                    </button>
                </form>

                <a href="{{ route('submissions.index') }}" class="px-6 py-3 bg-[#764BA2] text-white rounded-xl font-bold hover:bg-[#633e8a] shadow-lg shadow-indigo-200 transition-transform transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Confirm & Finish
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="col-span-1 space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-indigo-50">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Student Info</h3>
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $submission->student_name }}</h1>
                    <p class="text-sm text-gray-500">Submitted {{ $submission->created_at->diffForHumans() }}</p>
                    
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <p class="text-sm text-gray-500 mb-1">Assignment</p>
                        <p class="font-bold text-[#764BA2]">{{ $submission->assignment->title }}</p>
                    </div>
                </div>
            </div>

            <div class="col-span-2">
                <div class="bg-white rounded-2xl shadow-lg border border-indigo-50 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#667EEA] to-[#764BA2] p-6 text-white flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white/20 rounded-lg">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold">AI Grading Analysis</h2>
                                <p class="text-indigo-100 text-sm">Based on Rubric Criteria</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 bg-gray-50/50 min-h-[400px]">
                        @if($submission->extracted_text)
                            <div class="prose max-w-none font-mono text-sm text-gray-800 whitespace-pre-wrap">
                                {!! nl2br(e($submission->extracted_text)) !!}
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center h-64 text-gray-400">
                                <p>No AI result found.</p>
                                <p class="text-sm">Check your OpenAI API Key.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>