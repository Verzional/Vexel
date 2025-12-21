<x-app-layout>
    <div class="max-w-4xl mx-auto">
        
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-700">Edit Submission</h2>
            <p class="text-gray-500 mt-1">Update student name or replace the uploaded file.</p>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-indigo-100 p-8 sm:p-12 border border-indigo-50">
            
            <form action="{{ route('submissions.update', $submission->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-lg font-bold text-gray-700 mb-3">Step 1: Assignment</label>
                    <div class="relative">
                        <select name="assignment_id" required
                                class="w-full px-5 py-4 rounded-xl bg-gray-50 border-gray-200 text-gray-700 focus:ring-2 focus:ring-[#764BA2] focus:border-transparent appearance-none cursor-pointer text-base">
                            
                            @foreach($assignments as $assignment)
                                <option value="{{ $assignment->id }}" {{ $submission->assignment_id == $assignment->id ? 'selected' : '' }}>
                                    {{ $assignment->title }}
                                </option>
                            @endforeach

                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-lg font-bold text-gray-700 mb-3">Step 2: Student Name</label>
                    <input type="text" name="student_name" 
                           value="{{ old('student_name', $submission->student_name) }}" required
                           class="w-full px-5 py-4 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 focus:ring-2 focus:ring-[#764BA2] focus:border-transparent text-base">
                </div>

                <div>
                    <label class="block text-lg font-bold text-gray-700 mb-3">
                        Step 3: Replace File <span class="text-sm font-normal text-gray-500">(Optional)</span>
                    </label>
                    
                    @if($submission->file_path)
                        <div class="mb-4 flex items-center gap-2 text-sm text-[#764BA2] bg-[#EBEBFF] p-3 rounded-lg w-fit">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            <span>Current file exists. Upload below only if you want to replace it.</span>
                        </div>
                    @endif

                    <div class="relative group">
                        <input type="file" name="file" 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                               onchange="document.getElementById('file-name-display').innerText = 'Selected: ' + this.files[0].name;">
                        
                        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl h-40 flex flex-col items-center justify-center transition-all group-hover:border-[#764BA2] group-hover:bg-[#EBEBFF]">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mb-2 shadow-sm text-gray-400 group-hover:text-[#764BA2]">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                            </div>
                            <p class="text-gray-600 font-medium">Click to upload new file</p>
                            <p id="file-name-display" class="mt-2 text-sm text-[#764BA2] font-bold"></p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4">
                    <a href="{{ route('submissions.index') }}" class="text-gray-500 hover:text-gray-700 font-bold px-4">Cancel</a>
                    <button type="submit" 
                            class="bg-[#764BA2] hover:bg-[#633e8a] text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-transform transform hover:-translate-y-0.5">
                        Save Changes
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>