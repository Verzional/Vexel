<x-edit-layout title="Edit Assignment" description="Adjust title, course, or instructions for this task."
    backRoute="{{ route('assignments.index') }}" maxWidth="5xl">
    <form method="POST" action="{{ route('assignments.update', $assignment->id) }}" class="p-6 sm:p-8 space-y-4">
        @csrf
        @method('PUT')

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                Select Course
            </label>
            <div class="relative group">
                <select name="course_id" required
                    class="block w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-700 font-medium focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all bg-white appearance-none cursor-pointer">
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}"
                            {{ $assignment->course_id == $course->id ? 'selected' : '' }}>
                            {{ $course->name }} ({{ $course->year }})
                        </option>
                    @endforeach
                </select>
                <div
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 group-hover:text-[#764BA2] transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
            @error('course_id')
                <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                Assignment Title
            </label>
            <input type="text" name="title" value="{{ old('title', $assignment->title) }}"
                class="block w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-700 font-medium focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all bg-white"
                placeholder="e.g. Final Essay: Literature Review" required>
            @error('title')
                <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                Description
            </label>
            <textarea name="description" rows="10"
                class="block w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-700 font-medium focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all bg-white resize-none"
                placeholder="Detail the expectations for this assignment..." required>{{ old('description', $assignment->description) }}</textarea>
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
                Update Assignment
            </button>
        </div>
    </form>
</x-edit-layout>
