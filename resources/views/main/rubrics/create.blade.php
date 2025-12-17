<x-app-layout>
    <div class="max-w-5xl mx-auto">
        
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Create New Rubric</h2>
            <p class="text-gray-500 text-sm mt-1">Add a subject and define grading criteria.</p>
        </div>

        <form method="POST" action="{{ route('rubrics.store') }}" 
              x-data="rubricHandler()" 
              class="space-y-8">
            @csrf

            <div class="bg-gray-100 p-6 rounded-2xl border border-gray-200">
                <label class="block text-gray-500 text-sm font-bold mb-2">Rubric Title / Subject Name</label>
                <input type="text" 
                       name="subject_name" 
                       placeholder="Enter Subject Name" 
                       class="w-full bg-transparent border-none text-2xl font-bold text-gray-800 placeholder-gray-400 focus:ring-0 px-0"
                       required autofocus>
                <div class="h-0.5 w-full bg-gray-300 mt-2"></div>
            </div>

            <div class="space-y-4">
                <template x-for="(item, index) in criterias" :key="item.id">
                    
                    <div class="bg-[#EBEBFF] p-6 rounded-2xl border border-indigo-50 relative group hover:shadow-md transition-all">
                        
                        <button type="button" @click="removeCriteria(index)" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            
                            <div class="md:col-span-8 space-y-3">
                                <div>
                                    <input type="text" 
                                           :name="`criteria[${index}][name]`" 
                                           placeholder="Criteria Name" 
                                           class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 focus:border-[#764BA2] focus:ring focus:ring-[#764BA2] focus:ring-opacity-20 placeholder-gray-400 font-medium"
                                           required>
                                </div>
                                <div>
                                    <textarea :name="`criteria[${index}][description]`" 
                                              rows="2" 
                                              placeholder="Description" 
                                              class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 focus:border-[#764BA2] focus:ring focus:ring-[#764BA2] focus:ring-opacity-20 placeholder-gray-400 text-sm resize-none"></textarea>
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
                            Add New Criteria
                        </button>

                        <button type="submit" 
                                :disabled="totalWeight !== 100"
                                :class="totalWeight !== 100 ? 'bg-gray-400 cursor-not-allowed' : 'bg-[#764BA2] hover:bg-[#633e8a] shadow-lg shadow-purple-200'"
                                class="px-8 py-2.5 text-white font-bold rounded-xl transition-all">
                            Save Rubric
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="h-24"></div>

        </form>
    </div>

    <script>
        function rubricHandler() {
            return {
                criterias: [
                    { id: Date.now(), weight: 0 } // Mulai dengan 1 kriteria kosong
                ],
                addCriteria() {
                    this.criterias.push({
                        id: Date.now() + Math.random(),
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