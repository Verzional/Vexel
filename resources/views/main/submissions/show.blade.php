<x-app-layout>
    <div class="max-w-6xl mx-auto">

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Analysis Result</h1>
                <p class="text-gray-500">Review the AI grading below.</p>
            </div>

            <div class="flex gap-3">
                <form action="{{ route('submissions.destroy', $submission->id) }}" method="POST"
                    onsubmit="return confirm('Discard this result?');">
                    @csrf @method('DELETE')
                    <button
                        class="px-4 py-3 bg-red-50 text-red-600 rounded-xl font-bold hover:bg-red-100 transition-colors">
                        Discard / Delete
                    </button>
                </form>

                <a href="{{ route('submissions.index') }}"
                    class="px-6 py-3 bg-[#764BA2] text-white rounded-xl font-bold hover:bg-[#633e8a] shadow-lg shadow-indigo-200 transition-transform transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
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

                <!-- File Section -->
                <div class="mb-8">
                    <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Submitted File</h2>
                    <div class="bg-transparent rounded-xl p-4 border border-indigo-50 shadow-sm">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="bg-white p-2 rounded-lg border border-gray-200">
                                <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-700 truncate"
                                title="{{ basename($submission->file_path) }}">
                                {{ basename($submission->file_path) }}
                            </p>
                        </div>
                        <a href="{{ route('submissions.download', $submission) }}"
                            class="flex items-center justify-center w-full px-4 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-50 hover:border-gray-300 transition-all text-sm shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download PDF
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-span-2">
                <div
                    class="bg-white rounded-[2rem] shadow-xl shadow-indigo-100 overflow-hidden border border-indigo-50">
                    <div
                        class="bg-gradient-to-r from-[#667EEA] to-[#764BA2] p-8 text-white flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white/20 rounded-lg">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold">Grading Result</h2>
                                <p class="text-indigo-100 text-sm">AI Analysis & Feedback</p>
                            </div>
                        </div>
                        @if ($submission->result)
                            <div class="text-3xl font-bold">{{ $submission->result->grade }}<span
                                    class="text-lg text-indigo-200">/100</span></div>
                        @endif
                    </div>

                    <div class="p-8">
                        @if ($submission->result)
                            <!-- Reasoning -->
                            <div class="mb-8">
                                <h3 class="text-lg font-bold text-gray-800 mb-3 border-b border-gray-100 pb-2">Reasoning
                                </h3>
                                <p class="text-gray-600 leading-relaxed">
                                    {{ $submission->result->reasoning }}
                                </p>
                            </div>

                            <!-- Feedback -->
                            @if ($submission->result->feedback)
                                <div class="mb-8">
                                    <h3 class="text-lg font-bold text-gray-800 mb-3 border-b border-gray-100 pb-2">
                                        Overall Feedback</h3>
                                    <p class="text-gray-600 leading-relaxed">
                                        {{ $submission->result->feedback }}
                                    </p>
                                </div>
                            @endif

                            <!-- Notable Points -->
                            @if ($submission->result->notable_points)
                                <div class="mb-8">
                                    <h3 class="text-lg font-bold text-gray-800 mb-3 border-b border-gray-100 pb-2">
                                        Notable Points</h3>
                                    <div
                                        class="rounded-xl text-gray-700 leading-relaxed">
                                        {!! nl2br(e($submission->result->notable_points)) !!}
                                    </div>
                                </div>
                            @endif

                            <!-- Breakdown -->
                            @if ($submission->result->breakdown)
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">
                                        Grading Breakdown</h3>
                                    <div class="grid gap-3">
                                        @foreach ($submission->result->breakdown as $item)
                                            <div
                                                class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-xl hover:border-indigo-200 hover:shadow-sm transition-all">
                                                <span class="font-medium text-gray-700">{{ $item['criterion'] }}</span>
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-24 h-2 bg-gray-100 rounded-full overflow-hidden hidden sm:block">
                                                        <div class="bg-[#764BA2] h-full rounded-full"
                                                            style="width: {{ ($item['score'] / $item['max_score']) * 100 }}%">
                                                        </div>
                                                    </div>
                                                    <span class="font-bold text-[#764BA2]">{{ $item['score'] }} <span
                                                            class="text-gray-400 text-sm font-normal">/
                                                            {{ $item['max_score'] }}</span></span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-12">
                                <div
                                    class="bg-indigo-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-[#764BA2]" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Ready to Grade</h3>
                                <p class="text-gray-500 mb-6 max-w-md mx-auto">This submission has not been graded yet.
                                    Use the AI grading tool to generate a comprehensive analysis based on the rubric.
                                </p>

                                <form id="grade-form" action="{{ route('submissions.grade', $submission) }}"
                                    method="POST" class="inline-block">
                                    @csrf
                                    <button id="grade-button" type="submit"
                                        class="px-8 py-3 bg-[#764BA2] text-white rounded-xl font-bold hover:bg-[#633e8a] shadow-lg shadow-indigo-200 transition-transform transform hover:-translate-y-0.5 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        Start AI Grading
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
