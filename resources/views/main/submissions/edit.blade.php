<x-edit-layout title="Edit Submission" description="Update student name, assignment category, or replace the PDF file."
    backRoute="{{ route('submissions.index') }}" maxWidth="5xl">
    <form method="POST" action="{{ route('submissions.update', $submission) }}" id="submissionForm"
        enctype="multipart/form-data" class="p-6 sm:p-8 space-y-4">
        @csrf
        @method('PUT')

        <div class="space-y-2">
            <label for="student_name" class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                Student Full Name
            </label>
            <input type="text" name="student_name" id="student_name"
                value="{{ old('student_name', $submission->student_name) }}"
                class="block w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-700 font-medium focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all bg-white"
                placeholder="e.g. John Doe" required>
        </div>

        <div class="space-y-2">
            <label for="assignment_id" class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                Assignment Category
            </label>
            <div class="relative group">
                <input type="hidden" name="assignment_id" id="assignment_id" value="{{ old('assignment_id', $submission->assignment_id) }}" required>
                <div class="relative">
                    <input type="text" id="assignment_search" placeholder="Search and select an assignment..."
                        class="block w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-700 font-medium focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all bg-white cursor-pointer"
                        readonly onclick="toggleDropdown()" value="{{ $assignments->where('id', old('assignment_id', $submission->assignment_id))->first() ? $assignments->where('id', old('assignment_id', $submission->assignment_id))->first()->title : '' }}">
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 group-hover:text-[#764BA2] transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <div id="assignment_dropdown" class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-60 overflow-y-auto hidden">
                    <input type="text" id="assignment_filter" placeholder="Type to search..."
                        class="w-full px-4 py-2 border-b border-slate-200 text-slate-700 focus:outline-none focus:border-[#764BA2]">
                    <div id="assignment_options">
                        @foreach ($assignments as $assignment)
                            <div class="assignment-option px-4 py-3 hover:bg-slate-50 cursor-pointer text-slate-700 font-medium {{ $submission->assignment_id == $assignment->id ? 'bg-[#764BA2]/10' : '' }}" data-value="{{ $assignment->id }}" data-text="{{ $assignment->title }}">
                                {{ $assignment->title }} ({{ $assignment->course->name ?? 'No Course' }})
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-2">
            <label for="pdf_file" class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                Replace PDF File (Optional)
            </label>
            <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="w-10 h-10 bg-indigo-50 text-[#764BA2] rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="overflow-hidden flex-1 min-w-0">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight leading-none mb-1">
                            Current File Exists</p>
                    </div>
                </div>

                <input type="file" name="pdf_file" id="pdf_file" accept=".pdf"
                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-[#764BA2] hover:file:bg-indigo-100 transition-all cursor-pointer">
            </div>
            <p class="text-[10px] text-slate-400 italic ml-1">*Uploading a new file will replace the old document and
                its extraction.</p>
        </div>

        <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-100">
            <a href="{{ route('submissions.index') }}"
                class="w-full sm:w-auto px-6 py-3 text-slate-500 font-bold text-sm hover:text-slate-700 transition-colors text-center uppercase tracking-widest">
                Cancel
            </a>
            <button type="submit"
                class="w-full sm:w-auto px-10 py-3 bg-[#764BA2] hover:bg-[#633e8a] text-white font-bold rounded-2xl shadow-lg shadow-indigo-200/50 transition-all active:scale-95 text-sm uppercase tracking-widest">
                Update Submission
            </button>
        </div>
    </form>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('assignment_dropdown');
            dropdown.classList.toggle('hidden');
        }

        function selectAssignment(value, text) {
            document.getElementById('assignment_id').value = value;
            document.getElementById('assignment_search').value = text;
            document.getElementById('assignment_dropdown').classList.add('hidden');
        }

        document.getElementById('assignment_filter').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const options = document.querySelectorAll('.assignment-option');
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
            const dropdown = document.getElementById('assignment_dropdown');
            const searchInput = document.getElementById('assignment_search');
            if (!dropdown.contains(event.target) && !searchInput.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        document.querySelectorAll('.assignment-option').forEach(option => {
            option.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                const text = this.getAttribute('data-text');
                selectAssignment(value, text);
            });
        });
    </script>
</x-edit-layout>