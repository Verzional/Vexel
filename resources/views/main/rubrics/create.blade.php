<x-create-layout title="Create New Rubric" description="Define your subject name and distribute weight across criteria."
    backRoute="{{ route('rubrics.index') }}" maxWidth="5xl">
    <form method="POST" action="{{ route('rubrics.store') }}" x-data="rubricHandler()" class="p-6 sm:p-8 space-y-8">
        @csrf

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                Rubric Title
            </label>
            <input type="text" name="subject_name" placeholder="e.g. English Composition 101"
                class="block w-full px-4 py-4 rounded-2xl border-slate-200 text-slate-700 text-xl font-bold focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all bg-white"
                required autofocus>
        </div>

        <div class="space-y-4">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                Assessment Criteria
            </label>

            <template x-for="(item, index) in criterias" :key="item.id">
                <div
                    class="bg-[#F4F4FF] p-6 rounded-2xl border border-indigo-50 relative group hover:shadow-md transition-all">

                    <button type="button" @click="removeCriteria(index)"
                        class="absolute top-4 right-4 text-slate-400 hover:text-red-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <div class="md:col-span-12 font-black text-sm text-slate-500 uppercase tracking-widest">
                            Criteria #<span x-text="index + 1"></span>
                        </div>
                        <div class="md:col-span-8 space-y-3">
                            <input type="text" :name="`criteria[${index}][name]`"
                                placeholder="Criteria Name (e.g. Grammar)"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 focus:border-[#764BA2] focus:ring-0 font-bold text-slate-700"
                                required>

                            <textarea :name="`criteria[${index}][description]`" rows="2"
                                placeholder="What are the requirements for this criteria?"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 focus:border-[#764BA2] focus:ring-0 text-sm text-slate-600 resize-none"></textarea>
                        </div>

                        <div
                            class="md:col-span-4 flex flex-col justify-center bg-white/60 rounded-2xl p-4 border border-white">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 flex justify-between items-center">
                                Weight
                            </label>

                            <div class="flex items-center gap-3">
                                <input type="range" x-model="item.weight" :name="`criteria[${index}][weight]`"
                                    min="0" max="100" step="1"
                                    class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-[#764BA2]">

                                <input type="number" x-model="item.weight" :min="0" x:max="100"
                                    step="1" :name="`criteria[${index}][weight]`"
                                    class="w-14 text-center border border-slate-200 rounded-lg py-1 text-xs font-black text-slate-700 focus:border-[#764BA2] focus:ring-0">
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="pt-6 border-t border-slate-100 space-y-6">
            <div class="flex items-center gap-3">
                <span class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Weight</span>
                <div :class="totalWeight === 100 ? 'bg-green-50 text-green-600 border-green-200' :
                    'bg-red-50 text-red-500 border-red-200'"
                    class="flex items-center gap-2 px-4 py-2 rounded-2xl border transition-all duration-500 shadow-sm">
                    <span class="text-lg font-black leading-none" x-text="totalWeight + '%'"></span>

                    <template x-if="totalWeight === 100">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </template>
                    <template x-if="totalWeight !== 100">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </template>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                <button type="button" @click="addCriteria()"
                    class="w-full sm:w-auto px-6 py-3 bg-white text-[#764BA2] border-2 border-[#764BA2]/10 font-bold rounded-2xl hover:bg-indigo-50 transition-all flex items-center justify-center gap-2 shadow-sm text-sm uppercase tracking-widest">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Criteria
                </button>

                <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                    <a href="{{ route('rubrics.index') }}"
                        class="w-full sm:w-auto px-6 py-3 text-slate-500 font-bold text-sm hover:text-slate-700 transition-colors text-center uppercase tracking-widest">
                        Cancel
                    </a>
                    <button type="submit" :disabled="totalWeight !== 100"
                        :class="totalWeight !== 100 ? 'bg-slate-300 cursor-not-allowed shadow-none' :
                            'bg-[#764BA2] hover:bg-[#633e8a] shadow-lg shadow-indigo-200/50 active:scale-95'"
                        class="w-full sm:w-auto px-10 py-3 text-white font-bold rounded-2xl transition-all text-sm uppercase tracking-widest">
                        Save Rubric
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        function rubricHandler() {
            return {
                criterias: [{
                    id: Date.now(),
                    weight: 0
                }],
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
</x-create-layout>
