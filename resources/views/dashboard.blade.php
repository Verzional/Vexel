<x-app-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-700">
            Hello, {{ Auth::user()->name }} !
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div
            class="p-6 rounded-2xl bg-gradient-to-br from-[#667EEA] to-[#764BA2] text-white shadow-lg shadow-indigo-200">
            <div class="flex flex-col h-full justify-between">
                <div class="p-2 bg-white/20 rounded-lg w-fit mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-indigo-100 font-medium text-sm">Total Rubrics</p>
                    <h3 class="text-4xl font-bold mt-1">{{ $totalRubrics }}</h3>
                </div>
            </div>
        </div>

        <div
            class="p-6 rounded-2xl bg-gradient-to-br from-[#667EEA] to-[#764BA2] text-white shadow-lg shadow-indigo-200">
            <div class="flex flex-col h-full justify-between">
                <div class="p-2 bg-white/20 rounded-lg w-fit mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-indigo-100 font-medium text-sm">Total Assignments</p>
                    <h3 class="text-4xl font-bold mt-1">{{ $totalAssignments }}</h3>
                </div>
            </div>
        </div>

        <div
            class="p-6 rounded-2xl bg-gradient-to-br from-[#667EEA] to-[#764BA2] text-white shadow-lg shadow-indigo-200">
            <div class="flex flex-col h-full justify-between">
                <div class="p-2 bg-white/20 rounded-lg w-fit mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-indigo-100 font-medium text-sm">Total Submissions</p>
                    <h3 class="text-4xl font-bold mt-1">{{ $totalSubmissions }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-2xl font-bold text-gray-700 mb-6">Recent Activity</h3>

        <div class="bg-[#EBEBFF] rounded-3xl overflow-hidden p-1 border border-indigo-50">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-700 font-bold border-b border-gray-200/50">
                        <th class="py-4 px-6 text-sm uppercase">Activity Name</th>
                        <th class="py-4 px-6 text-sm uppercase">Date</th>
                        <th class="py-4 px-6 text-sm uppercase">Type</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/50">

                    @forelse($activities as $activity)
                        <tr class="hover:bg-white/50 transition-colors">
                            <td class="py-4 px-6 font-medium text-gray-700">{{ $activity->name }}</td>
                            <td class="py-4 px-6 text-gray-500">
                                {{ $activity->date->diffForHumans() }}
                            </td>
                            <td class="py-4 px-6">
                                @if ($activity->type == 'Rubric')
                                    <span
                                        class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">Rubric</span>
                                @elseif($activity->type == 'Assignment')
                                    <span
                                        class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Assignment</span>
                                @else
                                    <span
                                        class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">{{ $activity->type }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-8 text-center text-gray-500 italic">
                                No recent activity found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
