<x-create-layout title="Submit New Work" description="Fill in the details to upload student assignments." backRoute="{{ route('submissions.index') }}" maxWidth="5xl">
    <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8"
        x-data="{ files: null }"> @csrf

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Student Name</label>
            <input type="text" name="student_name" placeholder="e.g. John Smith"
                class="block w-full px-4 py-4 rounded-2xl border-slate-200 text-slate-700 text-xl font-bold focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all bg-white" required>
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Assignment Target</label>
            <div class="relative group">
                <input type="hidden" name="assignment_id" id="assignment_id" required>
                <div class="relative">
                    <input type="text" id="assignment_search" placeholder="Search and select an assignment..."
                        class="w-full px-4 py-3 rounded-xl border-slate-200 text-slate-700 font-medium focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all bg-white cursor-pointer"
                        readonly onclick="toggleDropdown()">
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
                            <div class="assignment-option px-4 py-3 hover:bg-slate-50 cursor-pointer text-slate-700 font-medium" data-value="{{ $assignment->id }}" data-text="{{ $assignment->title }}">
                                {{ $assignment->title }} ({{ $assignment->course->name ?? 'No Course' }})
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <p class="text-[10px] text-slate-400 italic ml-1">Select which assignment this submission belongs to.</p>
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Upload PDF File</label>
            <div class="relative border-2 border-dashed rounded-2xl p-8 text-center transition-all duration-300"
                :class="files ? 'border-green-400 bg-green-50' : 'border-gray-200 hover:border-[#764BA2]'">

                <input type="file" name="pdf_files[]" accept=".pdf" multiple required
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                    @change="files = $event.target.files">
                <div class="space-y-2">
                    <svg class="w-12 h-12 mx-auto mb-2 transition-colors duration-300"
                        :class="files ? 'text-green-500' : 'text-gray-400'" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path x-show="!files" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        <path x-show="files" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                    <template x-if="!files">
                        <p class="text-sm text-gray-500">Click to upload or drag and drop</p>
                    </template>

                    <template x-if="files">
                        <div class="space-y-1">
                            <p class="text-sm font-bold text-green-700">Selected files:</p>
                            <div class="flex flex-wrap justify-center gap-2">
                                <template x-for="file in Array.from(files)" :key="file.name">
                                    <span
                                        class="bg-white border border-green-200 text-green-600 text-xs px-3 py-1 rounded-full shadow-sm"
                                        x-text="file.name"></span>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-100">
            <a href="{{ route('submissions.index') }}"
                class="w-full sm:w-auto px-6 py-3 text-slate-500 font-bold text-sm hover:text-slate-700 transition-colors text-center uppercase tracking-widest">
                Cancel
            </a>
            <button type="submit"
                class="w-full sm:w-auto px-10 py-3 bg-[#764BA2] hover:bg-[#633e8a] text-white font-bold rounded-2xl shadow-lg shadow-indigo-200/50 transition-all active:scale-95 text-sm uppercase tracking-widest">
                Submit
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
</x-create-layout>
