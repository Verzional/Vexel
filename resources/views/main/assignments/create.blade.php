<x-create-layout title="Create New Assignment" description="Set up a new task and link it to a course."
    backRoute="{{ route('assignments.index') }}" maxWidth="5xl">
    <form method="POST" action="{{ route('assignments.store') }}" class="p-6 sm:p-8 space-y-8">
        @csrf

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                Select Course
            </label>
            <div class="relative group">
                <input type="hidden" name="course_id" id="course_id" required>
                <div class="relative">
                    <input type="text" id="course_search" placeholder="Search and select a course..."
                        class="w-full px-4 py-3 rounded-xl border-slate-200 text-slate-700 font-medium focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all bg-white cursor-pointer"
                        readonly onclick="toggleDropdown()">
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 group-hover:text-[#764BA2] transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                </div>
                <div id="course_dropdown"
                    class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-60 overflow-y-auto hidden">
                    <input type="text" id="course_filter" placeholder="Type to search..."
                        class="w-full px-4 py-2 border-b border-slate-200 text-slate-700 focus:outline-none focus:border-[#764BA2]">
                    <div id="course_options">
                        @foreach ($courses as $course)
                            <div class="course-option px-4 py-3 hover:bg-slate-50 cursor-pointer text-slate-700 font-medium"
                                data-value="{{ $course->id }}" data-text="{{ $course->name }} ({{ $course->year }})">
                                {{ $course->name }} ({{ $course->year }})
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <p class="text-[10px] text-slate-400 italic ml-1">This assignment will belong to the selected course.</p>
            @error('course_id')
                <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>

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
                Description
            </label>
            <textarea name="description" rows="5" placeholder="Write the details and requirements of the assignment here..."
                class="w-full px-4 py-3 rounded-xl border-slate-200 text-slate-700 font-medium focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all bg-white resize-none"
                required></textarea>
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

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('course_dropdown');
            dropdown.classList.toggle('hidden');
        }

        function selectCourse(value, text) {
            document.getElementById('course_id').value = value;
            document.getElementById('course_search').value = text;
            document.getElementById('course_dropdown').classList.add('hidden');
        }

        document.getElementById('course_filter').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const options = document.querySelectorAll('.course-option');
            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                if (text.includes(filter)) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        });

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('course_dropdown');
            const searchInput = document.getElementById('course_search');
            if (!dropdown.contains(event.target) && !searchInput.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        document.querySelectorAll('.course-option').forEach(option => {
            option.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                const text = this.getAttribute('data-text');
                selectCourse(value, text);
            });
        });
    </script>
</x-create-layout>
