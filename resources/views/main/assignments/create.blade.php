<x-create-layout title="Create New Assignment" description="Set up a new task and choose the appropriate grading rubric." backRoute="{{ route('assignments.index') }}" maxWidth="5xl">
    <form method="POST" action="{{ route('assignments.store') }}" class="p-6 sm:p-8 space-y-8">
        @csrf

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                Assignment Title
            </label>
            <input type="text" name="title" placeholder="e.g. Mid-term Research Paper" required
                class="block w-full px-4 py-4 rounded-2xl border-slate-200 text-slate-700 text-xl font-bold focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all bg-white">
            @error('title')
                <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                Select Grading Rubric
            </label>
            <div class="relative group">
                <select name="rubric_id" required
                    class="w-full px-4 py-3 rounded-xl border-slate-200 text-slate-700 font-medium focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all bg-white appearance-none cursor-pointer">
                    <option value="" disabled selected>Select a Rubric</option>
                    @foreach ($rubrics as $rubric)
                        <option value="{{ $rubric->id }}">{{ $rubric->subject_name }}</option>
                    @endforeach
                </select>
                <div
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 group-hover:text-[#764BA2] transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
            <p class="text-[10px] text-slate-400 italic ml-1">This rubric will define the AI grading criteria.</p>
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                Description
            </label>
            <textarea name="description" rows="5" placeholder="Write the details and requirements of the assignment here..."
                class="w-full px-4 py-3 rounded-xl border-slate-200 text-slate-700 font-medium focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all bg-white resize-none"></textarea>
            @error('description')
                <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-100">
            <a href="{{ route('assignments.index') }}"
                class="w-full sm:w-auto px-6 py-3 text-slate-500 font-bold text-sm hover:text-slate-700 transition-colors text-center uppercase tracking-widest">
                Cancel
            </a>
            <button type="submit"
                class="w-full sm:w-auto px-10 py-3 bg-[#764BA2] hover:bg-[#633e8a] text-white font-bold rounded-2xl shadow-lg shadow-indigo-200/50 transition-all active:scale-95 text-sm uppercase tracking-widest">
                Create Assignment
            </button>
        </div>
    </form>
</x-create-layout>
