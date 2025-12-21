<x-app-layout>
    <div class="max-w-5xl mx-auto">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <a href="{{ route('rubrics.index') }}" class="flex items-center text-gray-500 hover:text-[#764BA2] font-bold transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to List
            </a>

            <div class="flex gap-2">
                <a href="{{ route('rubrics.edit', $rubric->id) }}" class="px-5 py-2.5 bg-indigo-50 text-[#764BA2] rounded-xl font-bold hover:bg-indigo-100 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                    Edit
                </a>
                
                <form action="{{ route('rubrics.destroy', $rubric->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this rubric? This might affect assignments using it.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2.5 bg-red-50 text-red-500 rounded-xl font-bold hover:bg-red-100 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-indigo-100 overflow-hidden border border-indigo-50">
            
            <div class="bg-gradient-to-r from-[#667EEA] to-[#764BA2] p-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>

                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">{{ $rubric->subject_name }}</h1>
                        <p class="text-indigo-100 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            Created on {{ $rubric->created_at->format('l, d F Y') }}
                        </p>
                    </div>
                    
                    <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-8">
                
                @php
                    // Logic Decode JSON Criteria
                    $criteriaList = is_string($rubric->criteria) ? json_decode($rubric->criteria, true) : $rubric->criteria;
                    $criteriaList = is_array($criteriaList) ? $criteriaList : [];
                    
                    // Hitung Total Weight
                    $totalWeight = array_reduce($criteriaList, function($carry, $item) {
                        return $carry + ($item['weight'] ?? 0);
                    }, 0);
                @endphp

                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-700 border-l-4 border-[#764BA2] pl-3">
                        Assessment Criteria
                    </h3>
                    
                    <div class="flex items-center gap-2 bg-indigo-50 px-4 py-2 rounded-xl border border-indigo-100">
                        <span class="text-xs font-bold text-gray-500 uppercase">Total Weight</span>
                        <span class="text-lg font-bold {{ $totalWeight == 100 ? 'text-green-600' : 'text-red-500' }}">
                            {{ $totalWeight }}%
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    
                    @forelse($criteriaList as $index => $item)
                        <div class="group bg-white rounded-2xl p-5 border border-gray-100 hover:border-indigo-200 hover:shadow-md transition-all flex flex-col md:flex-row gap-5 items-start">
                            
                            <div class="flex-shrink-0 w-12 h-12 bg-[#F0F2FF] text-[#764BA2] rounded-xl flex items-center justify-center font-bold text-lg group-hover:bg-[#764BA2] group-hover:text-white transition-colors">
                                {{ $loop->iteration }}
                            </div>

                            <div class="flex-grow">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-lg font-bold text-gray-700">{{ $item['name'] }}</h4>
                                    <span class="md:hidden bg-indigo-50 text-[#764BA2] px-2 py-1 rounded text-xs font-bold">{{ $item['weight'] }}%</span>
                                </div>
                                <p class="text-gray-500 text-sm leading-relaxed">
                                    {{ $item['description'] ?? 'No specific description provided for this criterion.' }}
                                </p>
                            </div>

                            <div class="hidden md:flex flex-col items-end justify-center self-center pl-6 border-l border-gray-100 min-w-[100px]">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Weight</span>
                                <span class="text-2xl font-bold text-[#764BA2]">{{ $item['weight'] }}%</span>
                            </div>

                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            <p class="text-gray-400 font-medium">No criteria found.</p>
                        </div>
                    @endforelse

                </div>

            </div>
        </div>
        
        <div class="h-20"></div>

    </div>
</x-app-layout>