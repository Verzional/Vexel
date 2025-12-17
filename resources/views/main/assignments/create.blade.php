<x-app-layout>
    <div class="max-w-3xl mx-auto">
        
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Create Assignment</h2>
            <p class="text-gray-500 text-sm mt-1">Set up a new task for your students.</p>
        </div>

        <form method="POST" action="{{ route('assignments.store') }}" class="space-y-6">
            @csrf

            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                <label class="block text-gray-700 font-bold mb-2">Assignment Title</label>
                <input type="text" name="title" placeholder="Enter Assignment Title" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#764BA2] focus:ring focus:ring-[#764BA2] focus:ring-opacity-20 transition-all bg-white">
            </div>

            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                <label class="block text-gray-700 font-bold mb-2">Select Grading Rubric</label>
                <p class="text-xs text-gray-400 mb-3">Choose the rubric that will be used to grade this assignment.</p>
                
                <div class="relative">
                    <select name="rubric_id" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#764BA2] focus:ring focus:ring-[#764BA2] focus:ring-opacity-20 transition-all bg-white appearance-none cursor-pointer">
                        <option value="" disabled selected>-- Select a Rubric --</option>
                        
                        @foreach($rubrics as $rubric)
                            <option value="{{ $rubric->id }}">{{ $rubric->subject_name }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                <label class="block text-gray-700 font-bold mb-2">Instructions / Description</label>
                <textarea name="description" rows="5" placeholder="Write the details of the assignment here..."
                          class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#764BA2] focus:ring focus:ring-[#764BA2] focus:ring-opacity-20 transition-all bg-white"></textarea>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4">
                <a href="{{ route('assignments.index') }}" class="text-gray-500 hover:text-gray-800 font-bold px-4">Cancel</a>
                <button type="submit" class="bg-[#764BA2] hover:bg-[#633e8a] text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-transform transform hover:-translate-y-0.5">
                    Create Assignment
                </button>
            </div>

        </form>
    </div>
</x-app-layout>