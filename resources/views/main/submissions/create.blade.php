@if ($errors->any())
    <div class="mb-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
        <strong class="font-bold">Whoops! Ada masalah input:</strong>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<x-app-layout>
    <div class="max-w-4xl mx-auto relative">
        
        <div id="loading-overlay" class="hidden fixed inset-0 bg-[#764BA2]/90 z-[9999] flex flex-col items-center justify-center backdrop-blur-sm transition-opacity">
            <div class="relative w-24 h-24 mb-6">
                <div class="absolute inset-0 border-4 border-white/30 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-white rounded-full border-t-transparent animate-spin"></div>
                <div class="absolute inset-0 flex items-center justify-center text-white">
                    <svg class="w-10 h-10 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-white mb-2 animate-pulse">Analyzing Document...</h2>
            <p class="text-indigo-100 text-lg">AI is extracting text & grading against rubric.</p>
        </div>

        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-700">Upload Submission</h2>
            <p class="text-gray-500 mt-2">Submit student work and let AI grade it.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-[2rem] shadow-xl shadow-indigo-100 p-8 sm:p-12 border border-indigo-50">
            
            <form id="submissionForm" action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div>
                    <label class="block text-lg font-bold text-gray-700 mb-3">Step 1: Select Rubric</label>
                    <div class="relative">
                        <select name="rubric_id" required class="w-full px-5 py-4 rounded-xl bg-gray-50 border-gray-200 text-gray-700 focus:ring-2 focus:ring-[#764BA2]">
                            <option value="" disabled selected>Choose a rubric...</option>
                            @foreach($rubrics as $rubric)
                                <option value="{{ $rubric->id }}">{{ $rubric->subject_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-lg font-bold text-gray-700 mb-3">Step 2: Select Assignment</label>
                    <div class="relative">
                        <select name="assignment_id" required class="w-full px-5 py-4 rounded-xl bg-gray-50 border-gray-200 text-gray-700 focus:ring-2 focus:ring-[#764BA2]">
                            <option value="" disabled selected>Choose assignment...</option>
                            @foreach($assignments as $assignment)
                                <option value="{{ $assignment->id }}">{{ $assignment->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-lg font-bold text-gray-700 mb-3">Step 3: Student Name</label>
                    <input type="text" name="student_name" placeholder="Enter student's full name..."
                           class="w-full px-5 py-4 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 focus:ring-2 focus:ring-[#764BA2]">
                </div>

                <div>
                    <label class="block text-lg font-bold text-gray-700 mb-3">Step 4: Upload PDF Files</label>
                    <div class="relative group">
                        <input type="file" name="pdf_files[]" multiple required accept=".pdf"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                               onchange="document.getElementById('file-name-display').innerText = this.files.length + ' file(s) selected';">
                        
                        <div class="bg-[#EBEBFF] border-2 border-dashed border-[#764BA2]/30 rounded-2xl h-48 flex flex-col items-center justify-center transition-all group-hover:border-[#764BA2] group-hover:bg-[#e6e8ff]">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-3 shadow-sm text-[#764BA2]">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                            </div>
                            <p class="text-gray-700 font-bold text-lg">Drag & Drop PDF files here</p>
                            <p class="text-[#764BA2] font-medium mt-1">or click to browse</p>
                            <p id="file-name-display" class="mt-4 text-sm text-gray-500 font-medium"></p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-[#764BA2] hover:bg-[#633e8a] text-white font-bold text-lg rounded-xl shadow-lg transition-transform transform hover:-translate-y-1">
                    Analyze with AI
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('submissionForm').addEventListener('submit', function() {
            // Tampilkan Overlay saat form disubmit
            document.getElementById('loading-overlay').classList.remove('hidden');
        });
    </script>
</x-app-layout>