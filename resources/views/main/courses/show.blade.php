<x-show-layout badge="Course Detail" :title="$course->name" :subtitle="'Academic Year ' . $course->year" :backRoute="route('courses.index')" :editRoute="route('courses.edit', $course->id)"
    :deleteRoute="route('courses.destroy', $course->id)" deleteConfirm="Delete this course? All associated assignments will also be deleted.">

    <x-slot name="subtitleIcon">
        <svg class="w-5 h-5 text-[#764BA2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
    </x-slot>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-indigo-50 rounded-2xl p-4 border border-indigo-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-[#764BA2] shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Assignments</p>
                    <p class="text-2xl font-black text-[#764BA2]">{{ $course->assignments->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-green-50 rounded-2xl p-4 border border-green-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-green-600 shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">With Rubrics</p>
                    <p class="text-2xl font-black text-green-600">{{ $course->assignments->filter(fn($a) => $a->rubric)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Assignments Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
            Course Assignments
        </h3>

        <a href="{{ route('assignments.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-[#764BA2] text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-[#633e8a] transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Assignment
        </a>
    </div>

    {{-- Assignments List --}}
    <div class="space-y-4">
        @forelse($course->assignments as $assignment)
            <a href="{{ route('assignments.show', $assignment->id) }}"
                class="group block bg-slate-50 rounded-2xl p-5 border border-slate-100 hover:border-[#764BA2]/30 hover:shadow-md transition-all">
                <div class="flex flex-col md:flex-row gap-4 md:items-center justify-between">
                    <div class="flex items-start gap-4">
                        {{-- Icon --}}
                        <div class="flex-shrink-0 w-12 h-12 bg-white text-[#764BA2] rounded-xl flex items-center justify-center border border-slate-100 shadow-sm group-hover:bg-[#764BA2] group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        
                        <div class="min-w-0">
                            <h4 class="text-lg font-bold text-slate-700 group-hover:text-[#764BA2] transition-colors">{{ $assignment->title }}</h4>
                            <p class="text-slate-500 text-sm mt-1 line-clamp-2">{{ Str::limit($assignment->description, 100) }}</p>
                            
                            <div class="flex flex-wrap gap-2 mt-3">
                                @if($assignment->rubric)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider rounded-lg">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Has Rubric
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-yellow-100 text-yellow-700 text-[10px] font-bold uppercase tracking-wider rounded-lg">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        No Rubric
                                    </span>
                                @endif
                                <span class="px-2 py-1 bg-slate-200 text-slate-600 text-[10px] font-bold uppercase tracking-wider rounded-lg">
                                    {{ $assignment->created_at->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Arrow --}}
                    <div class="flex-shrink-0 hidden md:block">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-[#764BA2] group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>
        @empty
            <div class="text-center py-12 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-slate-400 font-medium">No assignments in this course yet.</p>
                <a href="{{ route('assignments.create') }}" class="inline-block mt-3 text-[#764BA2] font-bold text-sm hover:underline">
                    Create the first assignment →
                </a>
            </div>
        @endforelse
    </div>
</x-show-layout>
