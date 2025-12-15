<x-app-layout>
    <div class="max-w-5xl mx-auto">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Edit Rubric</h2>
                <p class="text-gray-500 text-sm mt-1">Update subject name or modify assessment criteria.</p>
            </div>
            <a href="{{ route('rubrics.index') }}" class="text-gray-500 hover:text-gray-700 font-medium">
                Cancel
            </a>
        </div>

        @php
            // Decode JSON dari database agar menjadi Array PHP
            $existingCriteria = is_string($rubric->criteria) ? json_decode($rubric->criteria, true) : $rubric->criteria;
            // Pastikan formatnya array agar tidak error di JS
            if (!is_array($existingCriteria)) {
                $existingCriteria = [];
            }
        @endphp

        <form method="POST" action="{{ route('rubrics.update', $rubric->id) }}" 
              x-data="rubricHandler(@js($existingCriteria))" 
              class="space-y-8">
            
            @csrf
            @method('PUT') <div class="bg-gray-100 p-6 rounded-2xl border border-gray-200">
                <label class="block text-gray-500 text-sm font-bold mb-2">Rubric Title / Subject Name</label>
                <input type="text" 
                       name="subject_name" 
                       value="{{ old('subject_name', $rubric->subject_name) }}"
                       placeholder="Enter Subject Name..." 
                       class="w-full bg-transparent border-none text-2xl font-bold text-gray-800 placeholder-gray-400 focus:ring-0 px-0"
                       required>
                <div class="h-0.5 w-full bg-gray-300 mt-2"></div>
            </div>

            <div class="space-y-4">
                <template x-for="(item, index) in criterias" :key="index">
                    
                    <div class="bg-[#EBEBFF] p-6 rounded-2xl border border-indigo-50 relative group hover:shadow-md transition-all">
                        
                        <button type="button" @click="removeCriteria(index)" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            
                            <div class="md:col-span-8 space-y-3">
                                <div>
                                    <input type="text" 
                                           x-model="item.name"
                                           :name="`criteria[${index}][name]`" 
                                           placeholder="Criteria Name" 
                                           class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 focus:border-[#764BA2] focus:ring focus:ring-[#764BA2] focus:ring-opacity-20 font-medium"
                                           required>
                                </div>
                                <div>
                                    <textarea x-model="item.description"
                                              :name="`criteria[${index}][description]`" 
                                              rows="2" 
                                              placeholder="Description" 
                                              class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 focus:border-[#764BA2] focus:ring focus:ring-[#764BA2] focus:ring-opacity-20 text-sm resize-none"></textarea>
                                </div>
                            </div>

                            <div class="md:col-span-4 flex flex-col justify-center bg-white/60 rounded-xl p-4">
                                <label class="text-sm font-bold text-gray-700 mb-3 flex justify-between items-center">
                                    Weight %
                                    <span class="bg-[#764BA2] text-white px-2 py-1 rounded-lg text-xs" x-text="item.weight + '%'"></span>
                                </label>
                                
                                <div class="flex items-center gap-3">
                                    <input type="range" 
                                           x-model="item.weight" 
                                           :name="`criteria[${index}][weight]`" 
                                           min="0" max="100" step="1"
                                           class="w-full h-2 bg-gray-300 rounded-lg appearance-none cursor-pointer accent-[#764BA2]">
                                    
                                    <input type="number" 
                                           x-model="item.weight" 
                                           min="0" max="100"
                                           class="w-16 text-center border border-gray-200 rounded-lg py-1 text-sm font-bold text-gray-700 focus:border-[#764BA2] focus:ring-0">
                                </div>
                            </div>

                        </div>
                    </div>
                </template>
            </div>

            <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 sm:ml-64 z-40 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]">
                <div class="max-w-5xl mx-auto flex items-center justify-between">
                    
                    <div class="text-sm font-bold">
                        Total Weight: 
                        <span :class="totalWeight === 100 ? 'text-green-600' : 'text-red-500'" class="text-lg ml-1" x-text="totalWeight + '%'"></span>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" 
                                @click="addCriteria()"
                                class="px-5 py-2.5 bg-gray-100 text-[#764BA2] font-bold rounded-xl hover:bg-gray-200 transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            Add Criteria
                        </button>

                        <button type="submit" 
                                :disabled="totalWeight !== 100"
                                :class="totalWeight !== 100 ? 'bg-gray-400 cursor-not-allowed' : 'bg-[#764BA2] hover:bg-[#633e8a] shadow-lg shadow-purple-200'"
                                class="px-8 py-2.5 text-white font-bold rounded-xl transition-all">
                            Update Rubric
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="h-24"></div>
        </form>
    </div>

    <script>
        function rubricHandler(initialData) {
            return {
                // Jika ada data lama, pakai itu. Jika tidak, mulai dengan 1 form kosong.
                criterias: (initialData && initialData.length > 0) ? initialData : [{ name: '', description: '', weight: 0 }],
                
                addCriteria() {
                    this.criterias.push({
                        name: '',
                        description: '',
                        weight: 0
                    });
                },
                removeCriteria(index) {
                    if (this.criterias.length > 1) {
                        this.criterias.splice(index, 1);
                    }
                },
                get totalWeight() {
                    return this.criterias.reduce((sum, item) => sum + parseInt(item.weight || 0), 0);
                }
            }
        }
    </script>
</x-app-layout>