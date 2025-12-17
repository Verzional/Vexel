<x-app-layout>
    <div class="max-w-3xl mx-auto">
        
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Edit Assignment</h2>
        </div>

        <form method="POST" action="{{ route('assignments.update', $assignment->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                <label class="block text-gray-700 font-bold mb-2">Assignment Title</label>
                <input type="text" name="title" value="{{ old('title', $assignment->title) }}" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#764BA2] focus:ring focus:ring-[#764BA2] focus:ring-opacity-20 transition-all bg-white">
            </div>

            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                <label class="block text-gray-700 font-bold mb-2">Grading Rubric</label>
                <div class="relative">
                    <select name="rubric_id" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#764BA2] focus:ring focus:ring-[#764BA2] focus:ring-opacity-20 transition-all bg-white appearance-none cursor-pointer">
                        
                        @foreach($rubrics as $rubric)
                            <option value="{{ $rubric->id }}" 
                                {{ $assignment->rubric_id == $rubric->id ? 'selected' : '' }}>
                                {{ $rubric->subject_name }}
                            </option>
                        @endforeach
                    </select>
                     <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                <label class="block text-gray-700 font-bold mb-2">Instructions</label>
                <textarea name="description" rows="5"
                          class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#764BA2] focus:ring focus:ring-[#764BA2] focus:ring-opacity-20 transition-all bg-white">{{ old('description', $assignment->description) }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4">
                <a href="{{ route('assignments.index') }}" class="text-gray-500 hover:text-gray-800 font-bold px-4">Cancel</a>
                <button type="submit" class="bg-[#764BA2] hover:bg-[#633e8a] text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-transform transform hover:-translate-y-0.5">
                    Update Assignment
                </button>
            </div>

        </form>
    </div>
</x-app-layout>