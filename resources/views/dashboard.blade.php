<x-app-layout title="Dashboard">
    <div class="mb-6 sm:mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-700 tracking-tight">
                Hello, {{ Auth::user()->name }}! 👋
            </h2>
        </div>
        <div class="self-start sm:self-auto">
            <span
                class="text-xs font-bold text-slate-400 uppercase tracking-widest bg-slate-100 px-4 py-2 rounded-full border border-slate-200">
                {{ now()->format('l, d M Y') }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-10">
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
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-black text-slate-700 tracking-tight flex items-center gap-3">
                Recent Activity
            </h3>
        </div>

        <div class="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-xl shadow-slate-200/50">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8F9FF] border-b border-slate-100 text-slate-400">
                            <th class="py-4 px-4 sm:py-5 sm:px-8 text-[11px] font-black uppercase tracking-[0.2em]">Activity Details
                            </th>
                            <th class="py-4 px-4 sm:py-5 sm:px-8 text-[11px] font-black uppercase tracking-[0.2em]">Date</th>
                            <th class="py-4 px-4 sm:py-5 sm:px-8 text-[11px] font-black uppercase tracking-[0.2em]">Category</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($activities as $activity)
                            <tr class="group hover:bg-[#F8F9FF] transition-all duration-300">
                                <td class="py-4 px-4 sm:py-5 sm:px-8">
                                    <div class="flex items-center gap-4">
                                        <span
                                            class="font-bold text-slate-700 text-sm tracking-tight group-hover:text-slate-900">{{ $activity->name }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 sm:py-5 sm:px-8">
                                    <span class="text-xs font-semibold text-slate-400 italic">
                                        {{ $activity->date->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 sm:py-5 sm:px-8">
                                    @if ($activity->type == 'Rubric')
                                        <span
                                            class="bg-purple-50 text-[#764BA2] px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border border-purple-100 shadow-sm">Rubric</span>
                                    @elseif($activity->type == 'Assignment')
                                        <span
                                            class="bg-blue-50 text-blue-600 px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border border-blue-100 shadow-sm">Assignment</span>
                                    @else
                                        <span
                                            class="bg-slate-100 text-slate-600 px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-200 shadow-sm">{{ $activity->type }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-20 text-center">
                                    <div class="flex flex-col items-center opacity-30">
                                        <svg class="w-12 h-12 mb-3" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-sm font-bold uppercase tracking-widest">No activity logged yet
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
