<x-show-layout badge="Rubric Detail" :title="$rubric->subject_name" :subtitle="'Created on ' . $rubric->created_at->format('M d, Y')" :backRoute="route('rubrics.index')" :editRoute="route('rubrics.edit', $rubric->id)"
    :deleteRoute="route('rubrics.destroy', $rubric->id)" deleteConfirm="Delete this rubric? This might affect assignments." maxWidth="7xl">

    <x-slot name="subtitleIcon">
        <svg class="w-5 h-5 text-[#764BA2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
    </x-slot>

    @php
        $criteriaList = is_string($rubric->criteria) ? json_decode($rubric->criteria, true) : $rubric->criteria;
        $criteriaList = is_array($criteriaList) ? $criteriaList : [];

        $totalWeight = array_reduce(
            $criteriaList,
            function ($carry, $item) {
                return $carry + ($item['weight'] ?? 0);
            },
            0,
        );
    @endphp

    {{-- Assignment Info --}}
    @if ($rubric->assignment)
        <div class="mb-6 bg-indigo-50 rounded-2xl p-4 border border-indigo-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-[#764BA2] shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Linked Assignment</p>
                    <a href="{{ route('assignments.show', $rubric->assignment_id) }}"
                        class="text-[#764BA2] font-bold hover:underline">
                        {{ $rubric->assignment->title }}
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- Criteria Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
            Assessment Criteria with Performance Levels
        </h3>

        <div class="flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Weight</span>
            <span class="text-lg font-bold {{ $totalWeight == 100 ? 'text-green-600' : 'text-red-500' }}">
                {{ $totalWeight }}%
            </span>
        </div>
    </div>

    {{-- Criteria List --}}
    <div class="space-y-6">
        @forelse($criteriaList as $index => $item)
            <div
                class="bg-gradient-to-br from-[#F4F4FF] to-[#EBEBFF] rounded-2xl border border-indigo-100 overflow-hidden">
                {{-- Criterion Header --}}
                <div class="p-5 border-b border-indigo-100">
                    <div class="flex flex-col md:flex-row gap-4 md:items-center justify-between">
                        <div class="flex items-start gap-4">
                            {{-- Number Badge --}}
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-[#764BA2] text-white rounded-xl flex items-center justify-center font-bold text-lg shadow-lg">
                                {{ $loop->iteration }}
                            </div>

                            <div class="min-w-0">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Graduate
                                    Outcome Indicator</p>
                                <h4 class="text-lg font-bold text-slate-700">
                                    {{ $item['indicator'] ?? ($item['name'] ?? 'N/A') }}</h4>
                                <p class="text-slate-500 text-sm mt-1">
                                    {{ $item['criteria'] ?? ($item['description'] ?? 'No description provided.') }}</p>
                            </div>
                        </div>

                        {{-- Weight Badge --}}
                        <div
                            class="flex-shrink-0 bg-white rounded-xl px-4 py-3 border border-slate-200 text-center shadow-sm">
                            <span
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Weight</span>
                            <span class="text-2xl font-black text-[#764BA2]">{{ $item['weight'] }}%</span>
                        </div>
                    </div>
                </div>

                {{-- Performance Levels Table --}}
                @if (isset($item['levels']) && is_array($item['levels']) && count($item['levels']) > 0)
                    <div class="p-5">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3">Performance
                            Levels (Score Bands)</p>
                        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                            <table class="w-full">
                                <thead class="bg-slate-100">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            Score Range</th>
                                        <th
                                            class="px-4 py-3 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            Grade</th>
                                        <th
                                            class="px-4 py-3 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            Performance Descriptor</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($item['levels'] as $level)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-4 py-3 text-sm font-medium text-slate-600">
                                                {{ $level['min'] }} - {{ $level['max'] }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <span @class([
                                                    'inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold',
                                                    'bg-green-100 text-green-700' => in_array($level['grade'], [
                                                        'A',
                                                        'A-',
                                                        'A-, A',
                                                    ]),
                                                    'bg-blue-100 text-blue-700' => in_array($level['grade'], [
                                                        'B',
                                                        'B+',
                                                        'B-',
                                                        'B-, B, B+',
                                                    ]),
                                                    'bg-yellow-100 text-yellow-700' => in_array($level['grade'], [
                                                        'C',
                                                        'C+',
                                                        'C, C+',
                                                    ]),
                                                    'bg-orange-100 text-orange-700' => $level['grade'] === 'D',
                                                    'bg-red-100 text-red-700' => !in_array($level['grade'], [
                                                        'A',
                                                        'A-',
                                                        'A-, A',
                                                        'B',
                                                        'B+',
                                                        'B-',
                                                        'B-, B, B+',
                                                        'C',
                                                        'C+',
                                                        'C, C+',
                                                        'D',
                                                    ]),
                                                ])>
                                                    {{ $level['grade'] }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-slate-600">
                                                {{ $level['description'] ?? 'No description' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="p-5 text-center text-slate-400 text-sm">
                        <p>No performance levels defined for this criterion.</p>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-12 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-slate-400 font-medium">No criteria found.</p>
            </div>
        @endforelse
    </div>
</x-show-layout>
