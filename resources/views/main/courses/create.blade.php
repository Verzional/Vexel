<x-create-layout title="Create New Course" description="Add a new course for organizing assignments."
    backRoute="{{ route('courses.index') }}" maxWidth="2xl">
    <form method="POST" action="{{ route('courses.store') }}" class="p-6 sm:p-8 space-y-6">
        @csrf

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                Course Name
            </label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="block w-full px-4 py-4 rounded-2xl border-slate-200 text-slate-700 text-xl font-bold focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all"
                placeholder="e.g. Cloud Computing" required autofocus>
            @error('name')
                <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                Academic Year
            </label>
            <input type="number" name="year" value="{{ old('year', date('Y')) }}"
                min="2000" max="2100"
                class="block w-full px-4 py-4 rounded-2xl border-slate-200 text-slate-700 text-xl font-bold focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all"
                placeholder="e.g. 2025" required>
            @error('year')
                <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-6 border-t border-slate-100">
            <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
                <a href="{{ route('courses.index') }}"
                    class="w-full sm:w-auto px-6 py-3 text-slate-500 font-bold text-sm hover:text-slate-700 transition-colors text-center uppercase tracking-widest">
                    Cancel
                </a>
                <button type="submit"
                    class="w-full sm:w-auto px-10 py-3 bg-[#764BA2] text-white font-bold rounded-2xl hover:bg-[#633e8a] shadow-lg shadow-indigo-200/50 transition-all active:scale-95 text-sm uppercase tracking-widest">
                    Create Course
                </button>
            </div>
        </div>
    </form>
</x-create-layout>
