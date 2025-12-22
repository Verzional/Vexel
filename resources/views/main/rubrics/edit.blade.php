<x-app-layout>
    <div class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('rubrics.index') }}"
                class="inline-flex items-center gap-2 text-slate-500 font-semibold hover:text-[#764BA2] transition-colors group">
                <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 overflow-hidden border border-slate-100">
            <div class="bg-[#e7e2ff] p-6 sm:p-8 border-b border-slate-100">
                <h2 class="text-2xl font-extrabold text-slate-700">Edit Rubric</h2>
                <p class="text-slate-500 text-sm font-medium mt-1">Update subject name or modify assessment criteria
                    weight.</p>
            </div>

            @php
                $existingCriteria = is_string($rubric->criteria)
                    ? json_decode($rubric->criteria, true)
                    : $rubric->criteria;
                if (!is_array($existingCriteria)) {
                    $existingCriteria = [];
                }
            @endphp

            <form method="POST" action="{{ route('rubrics.update', $rubric->id) }}" x-data="rubricHandler(@js($existingCriteria))"
                class="p-6 sm:p-8 space-y-4">

                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                        Rubric Title
                    </label>
                    <input type="text" name="subject_name" value="{{ old('subject_name', $rubric->subject_name) }}"
                        class="block w-full px-4 py-4 rounded-2xl border-slate-200 text-slate-700 text-xl font-bold focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all"
                        placeholder="Enter Subject Name..." required>
                </div>

                <div class="space-y-4">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                        Assessment Criteria
                    </label>

                    <template x-for="(item, index) in criterias" :key="index">
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
                                <div class="md:col-span-8 space-y-3">
                                    <input type="text" x-model="item.name" :name="`criteria[${index}][name]`"
                                        placeholder="Criteria Name (e.g. Grammar, Logic)"
                                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 focus:border-[#764BA2] focus:ring-0 font-bold text-slate-700"
                                        required>

                                    <textarea x-model="item.description" :name="`criteria[${index}][description]`" rows="2"
                                        placeholder="Brief description of what to assess..."
                                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 focus:border-[#764BA2] focus:ring-0 text-sm text-slate-600 resize-none"></textarea>
                                </div>

                                <div
                                    class="md:col-span-4 flex flex-col justify-center bg-white/60 rounded-2xl p-4 border border-white">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 flex justify-between items-center">
                                        Weight
                                        <span class="bg-[#764BA2] text-white px-2 py-0.5 rounded-md text-[10px]"
                                            x-text="item.weight + '%'"></span>
                                    </label>

                                    <div class="flex items-center gap-3">
                                        <input type="range" x-model="item.weight" :name="`criteria[${index}][weight]`"
                                            min="0" max="100" step="1"
                                            class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-[#764BA2]">

                                        <input type="number" x-model="item.weight"
                                            class="w-14 text-center border border-slate-200 rounded-lg py-1 text-xs font-black text-slate-700 focus:border-[#764BA2] focus:ring-0">
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </template>
                </div>

                <div
                    class="fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-md border-t border-slate-200 p-4 sm:ml-64 z-40 shadow-[0_-10px_25px_-5px_rgba(0,0,0,0.05)]">
                    <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">

                        <div class="flex items-center gap-3">
                            <span class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Total Weight
                            </span>

                            <div :class="totalWeight === 100 ? 'bg-green-50 text-green-600 border-green-200' :
                                'bg-red-50 text-red-500 border-red-200'"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-2xl border transition-all duration-500 shadow-sm min-w-[140px]">

                                <span class="text-xl font-black leading-none tracking-tighter"
                                    x-text="totalWeight + '%'"></span>

                                <div class="w-px h-4 bg-current opacity-20"></div>

                                <div class="flex-shrink-0">
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
                        </div>

                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <button type="button" @click="addCriteria()"
                                class="flex-1 md:flex-none px-6 py-3.5 bg-white text-[#764BA2] border-2 border-[#764BA2]/10 font-bold rounded-2xl hover:bg-indigo-50 transition-all flex items-center justify-center gap-2 shadow-sm text-xs uppercase tracking-widest">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Add Criteria
                            </button>

                            <button type="submit" :disabled="totalWeight !== 100"
                                :class="totalWeight !== 100 ? 'bg-slate-300 cursor-not-allowed shadow-none text-slate-500' :
                                    'bg-[#764BA2] hover:bg-[#633e8a] shadow-lg shadow-indigo-200/50 active:scale-95'"
                                class="flex-1 md:flex-none px-10 py-3.5 text-white font-bold rounded-2xl transition-all text-xs uppercase tracking-widest">
                                Update Rubric
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    <script>
        function rubricHandler(initialData) {
            return {
                criterias: (initialData && initialData.length > 0) ? initialData : [{
                    name: '',
                    description: '',
                    weight: 0
                }],
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
