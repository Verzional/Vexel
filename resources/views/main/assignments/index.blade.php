<x-app-layout>

    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-700">Assignments List</h2>
            <p class="text-gray-500">Manage assignments and connect them with grading rubrics.</p>
        </div>

        <div class="relative w-full sm:w-80">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" placeholder="Search assignments..."
                class="w-full py-2.5 pl-10 pr-4 bg-gray-50 border border-gray-200 text-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#764BA2] focus:border-transparent transition-all placeholder-gray-400">
        </div>
    </div>

    <a href="{{ Route::has('assignments.create') ? route('assignments.create') : '#' }}"
        class="block w-full py-4 bg-[#8B5CF6] hover:bg-[#7c4dff] text-white rounded-xl shadow-lg shadow-purple-200 transition-all transform hover:-translate-y-0.5 mb-10 flex items-center justify-center gap-2 group">
        <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <span class="text-lg font-bold">Create New Assignment</span>
    </a>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($assignments ?? [] as $assignment)
            <div
                class="bg-[#EBEBFF] rounded-2xl p-6 relative hover:shadow-md transition-shadow group flex flex-col h-full border border-indigo-50">

                <div class="absolute top-4 right-4 flex gap-2 z-10">

                    <a href="{{ route('assignments.show', $assignment->id) }}"
                        class="p-2 bg-white text-gray-600 rounded-lg hover:bg-[#764BA2] hover:text-white transition-colors shadow-sm"
                        title="View Detail">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>

                    <a href="{{ route('assignments.edit', $assignment->id) }}"
                        class="p-2 bg-[#D0D3F5] text-[#764BA2] rounded-lg hover:bg-[#764BA2] hover:text-white transition-colors shadow-sm"
                        title="Edit">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </a>

                    <form action="{{ route('assignments.destroy', $assignment->id) }}" method="POST"
                        onsubmit="return confirm('Delete this assignment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="p-2 bg-[#ffdede] text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition-colors shadow-sm"
                            title="Delete">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>

                <div
                    class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mb-4 text-[#764BA2] shadow-sm">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>

                <a href="{{ route('assignments.show', $assignment->id) }}"
                    class="hover:underline decoration-[#764BA2] decoration-2 underline-offset-2">
                    <h3 class="text-lg font-bold text-gray-700 mb-2 pr-24 leading-tight">
                        {{ $assignment->title }}
                    </h3>
                </a>

                <p class="text-gray-500 text-sm mb-4 flex-grow">
                    {{ Str::limit($assignment->description ?? 'No description provided.', 80) }}
                </p>

                <div class="pt-4 border-t border-indigo-200/50 flex flex-col gap-1 text-xs font-medium text-gray-500">
                    <div class="flex items-center justify-between">
                        <span>Rubric Used:</span>
                        <span
                            class="text-[#764BA2] font-bold bg-indigo-50 px-2 py-0.5 rounded-md border border-indigo-100">
                            {{ $assignment->rubric->subject_name ?? 'Unassigned' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between mt-1">
                        <span>Created:</span>
                        <span>{{ $assignment->created_at->format('d M Y') }}</span>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full py-12 text-center text-gray-500">
                No assignments found.
            </div>
        @endforelse

    </div>
</x-app-layout>
