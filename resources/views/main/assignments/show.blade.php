<x-show-layout badge="Assignment Detail" :title="$assignment->title" :subtitle="'Created on ' . $assignment->created_at->format('M d, Y')" :backRoute="route('assignments.index')" :editRoute="route('assignments.edit', $assignment->id)"
    :deleteRoute="route('assignments.destroy', $assignment->id)" deleteConfirm="Delete this assignment?">

    <x-slot name="subtitleIcon">
        <svg class="w-5 h-5 text-[#764BA2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Description Section --}}
        <div class="lg:col-span-2 space-y-6">
            <div>
                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 mb-3">
                    Description
                </h3>
                <div
                    class="bg-slate-50 p-6 rounded-2xl border border-slate-100 text-slate-600 leading-relaxed font-medium">
                    {{ $assignment->description ?? 'No description provided.' }}
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Course Info --}}
            @if($assignment->course)
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">
                    Course
                </h3>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Course Name</div>
                    <div class="font-bold text-[#764BA2] text-lg">
                        {{ $assignment->course->name }}
                    </div>
                    <div class="text-sm text-slate-500 mt-1">Year: {{ $assignment->course->year }}</div>
                </div>
            </div>
            @endif

            {{-- Rubric Info --}}
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">
                    Grading Rubric
                </h3>

                @if($assignment->rubric)
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm mb-4">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Rubric Name</div>
                    <div class="font-bold text-[#764BA2] text-lg">
                        {{ $assignment->rubric->subject_name }}
                    </div>
                </div>

                <a href="{{ route('rubrics.show', $assignment->rubric->id) }}"
                    class="block w-full py-2.5 text-center bg-[#764BA2]/10 text-[#764BA2] font-bold rounded-xl hover:bg-[#764BA2] hover:text-white transition-all text-sm">
                    View Full Rubric
                </a>
                @else
                <div class="bg-amber-50 p-4 rounded-xl border border-amber-200 text-amber-700 text-sm">
                    <p class="font-medium">No rubric assigned yet.</p>
                    <a href="{{ route('rubrics.create') }}" class="text-[#764BA2] hover:underline font-bold mt-2 inline-block">
                        Create a rubric for this assignment →
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-show-layout>
