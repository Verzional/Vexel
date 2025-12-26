<x-index-layout title="Assignments List" description="Manage assignments and connect them with grading rubrics.">
    <x-slot name="actions">
        <x-search-input :action="route('assignments.index')" placeholder="Search assignments..." />

        <x-primary-link-button :href="Route::has('assignments.create') ? route('assignments.create') : '#'">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create New Assignment
        </x-primary-link-button>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($assignments ?? [] as $assignment)
            <div
                class="bg-[#EBEBFF] rounded-2xl p-6 relative hover:shadow-md transition-shadow group flex flex-col h-full border border-indigo-50">

                <div class="absolute top-4 right-4 flex gap-2 z-20">
                    <a href="{{ route('assignments.edit', $assignment->id) }}"
                        class="p-2 bg-[#D0D3F5] text-[#764BA2] rounded-lg hover:bg-[#764BA2] hover:text-white transition-colors shadow-sm"
                        title="Edit">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </a>

                    <form id="delete-form-{{ $assignment->id }}" action="{{ route('assignments.destroy', $assignment->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $assignment->id }})"
                            class="p-2 bg-[#ffdede] text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition-colors shadow-sm"
                            title="Delete">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>

                <a href="{{ route('assignments.show', $assignment->id) }}"
                    class="h-full flex flex-col justify-between relative z-10">
                    <div
                        class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mb-4 text-[#764BA2] shadow-sm">

                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>

                    <h3 class="text-lg font-bold text-gray-700 mb-2 pr-24 leading-tight">
                        {{ $assignment->title }}
                    </h3>

                    <p class="text-gray-500 text-sm mb-4 flex-grow">
                        {{ Str::limit($assignment->description ?? 'No description provided.', 80) }}
                    </p>

                    <div
                        class="pt-4 border-t border-indigo-200/50 flex flex-col gap-1 text-xs font-medium text-gray-500">
                        <div class="flex items-center gap-2">
                            Course:
                            <span
                                class="text-[#764BA2] font-bold bg-white px-2 py-1 rounded-md border border-indigo-100">
                                {{ $assignment->course->name ?? 'Unassigned' }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            Rubric:
                            <span
                                class="text-[#764BA2] font-bold bg-white px-2 py-1 rounded-md border border-indigo-100">
                                {{ $assignment->rubric->subject_name ?? 'Not Set' }}
                            </span>
                        </div>
                        
                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest flex justify-between items-center">
                            <span>Created On {{ $assignment->created_at->format('d M Y') }}</span>
                        </div>

                        
                    </div>
                </a>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-gray-500">
                No assignments found.
            </div>
        @endforelse

    </div>

    <x-toast-delete message="Are you sure you want to delete this assignment? This action cannot be undone." />
</x-index-layout>
