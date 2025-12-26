<x-edit-layout title="Edit Rubric" description="Update criteria and performance levels."
    backRoute="{{ route('rubrics.index') }}" maxWidth="7xl">
    @php
        $existingCriteria = is_string($rubric->criteria) ? json_decode($rubric->criteria, true) : $rubric->criteria;
        if (!is_array($existingCriteria)) {
            $existingCriteria = [];
        }
    @endphp

    <form method="POST" action="{{ route('rubrics.update', $rubric->id) }}" x-data="rubricHandler(@js($existingCriteria))"
        class="p-6 sm:p-8 space-y-8">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                    Select Assignment
                </label>
                <div class="relative group">
                    <input type="hidden" name="assignment_id" id="assignment_id" value="{{ old('assignment_id', $rubric->assignment_id) }}" required>
                    <div class="relative">
                        <input type="text" id="assignment_search" placeholder="Search and select an assignment..."
                            class="w-full px-4 py-3 rounded-xl border-slate-200 text-slate-700 font-medium focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all bg-white cursor-pointer"
                            readonly onclick="toggleDropdown()" value="{{ $assignments->where('id', old('assignment_id', $rubric->assignment_id))->first() ? $assignments->where('id', old('assignment_id', $rubric->assignment_id))->first()->title . ' (' . ($assignments->where('id', old('assignment_id', $rubric->assignment_id))->first()->course->name ?? 'No Course') . ')' : '' }}">
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 group-hover:text-[#764BA2] transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <div id="assignment_dropdown" class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-60 overflow-y-auto hidden">
                        <input type="text" id="assignment_filter" placeholder="Type to search..."
                            class="w-full px-4 py-2 border-b border-slate-200 text-slate-700 focus:outline-none focus:border-[#764BA2]">
                        <div id="assignment_options">
                            @foreach ($assignments as $assignment)
                                <div class="assignment-option px-4 py-3 hover:bg-slate-50 cursor-pointer text-slate-700 font-medium {{ $rubric->assignment_id == $assignment->id ? 'bg-[#764BA2]/10' : '' }}" data-value="{{ $assignment->id }}" data-text="{{ $assignment->title }} ({{ $assignment->course->name ?? 'No Course' }})">
                                    {{ $assignment->title }} ({{ $assignment->course->name ?? 'No Course' }})
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @error('assignment_id')
                    <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                    Rubric Title
                </label>
                <input type="text" name="subject_name" value="{{ old('subject_name', $rubric->subject_name) }}"
                    class="block w-full px-4 py-3 rounded-xl border-slate-200 text-slate-700 font-bold focus:border-[#764BA2] focus:ring focus:ring-[#764BA2]/10 transition-all bg-white"
                    placeholder="Enter Subject Name..." required>
            </div>
        </div>

        {{-- Criteria Section --}}
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                    Assessment Criteria with Performance Levels
                </label>
            </div>

            <template x-for="(criterion, cIndex) in criteria" :key="cIndex">
                <div class="bg-gradient-to-br from-[#F4F4FF] to-[#EBEBFF] p-6 rounded-2xl border border-indigo-100 relative group hover:shadow-lg transition-all">
                    
                    {{-- Delete Criterion Button --}}
                    <button type="button" @click="removeCriterion(cIndex)"
                        class="absolute top-4 right-4 text-slate-400 hover:text-red-500 transition-colors p-2 hover:bg-red-50 rounded-lg">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>

                    {{-- Criterion Header --}}
                    <div class="mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-[#764BA2] text-white rounded-xl flex items-center justify-center font-bold text-lg shadow-lg">
                                <span x-text="cIndex + 1"></span>
                            </div>
                            <h3 class="font-black text-slate-700 uppercase tracking-wide">Criterion</h3>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                            <div class="lg:col-span-4 space-y-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    Graduate Outcome Indicator
                                </label>
                                <input type="text" x-model="criterion.indicator" :name="`criteria[${cIndex}][indicator]`"
                                    placeholder="e.g. KU1.2 The suitability of methods and data"
                                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 focus:border-[#764BA2] focus:ring-0 font-medium text-slate-700 text-sm"
                                    required>
                            </div>

                            <div class="lg:col-span-6 space-y-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    Criteria Description
                                </label>
                                <input type="text" x-model="criterion.criteria" :name="`criteria[${cIndex}][criteria]`"
                                    placeholder="e.g. Student understanding of the basic concepts of cloud computing"
                                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 focus:border-[#764BA2] focus:ring-0 font-medium text-slate-700 text-sm"
                                    required>
                            </div>

                            <div class="lg:col-span-2 space-y-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    Weight %
                                </label>
                                <input type="number" x-model="criterion.weight" :name="`criteria[${cIndex}][weight]`"
                                    min="0" max="100" step="0.01"
                                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 focus:border-[#764BA2] focus:ring-0 font-bold text-[#764BA2] text-center"
                                    required>
                            </div>
                        </div>
                    </div>

                    {{-- Performance Levels --}}
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                                Performance Levels (Score Bands)
                            </label>
                            <button type="button" @click="addLevel(cIndex)"
                                class="text-xs font-bold text-[#764BA2] hover:text-[#633e8a] flex items-center gap-1 px-3 py-1.5 bg-white rounded-lg border border-[#764BA2]/20 hover:bg-[#764BA2]/5 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Level
                            </button>
                        </div>

                        {{-- Levels Table --}}
                        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                            <div class="grid grid-cols-12 gap-0 bg-slate-100 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                <div class="col-span-2 px-4 py-3 border-r border-slate-200">Min Score</div>
                                <div class="col-span-2 px-4 py-3 border-r border-slate-200">Max Score</div>
                                <div class="col-span-2 px-4 py-3 border-r border-slate-200">Grade</div>
                                <div class="col-span-5 px-4 py-3 border-r border-slate-200">Description</div>
                                <div class="col-span-1 px-4 py-3 text-center">Action</div>
                            </div>

                            <template x-for="(level, lIndex) in criterion.levels" :key="lIndex">
                                <div class="grid grid-cols-12 gap-0 border-t border-slate-100 hover:bg-slate-50 transition-colors">
                                    <div class="col-span-2 px-2 py-2 border-r border-slate-100">
                                        <input type="number" x-model="level.min" :name="`criteria[${cIndex}][levels][${lIndex}][min]`"
                                            min="0" max="100" step="0.01"
                                            class="w-full border-slate-200 rounded-lg px-2 py-1.5 text-sm font-medium focus:border-[#764BA2] focus:ring-0"
                                            required>
                                    </div>
                                    <div class="col-span-2 px-2 py-2 border-r border-slate-100">
                                        <input type="number" x-model="level.max" :name="`criteria[${cIndex}][levels][${lIndex}][max]`"
                                            min="0" max="100" step="0.01"
                                            class="w-full border-slate-200 rounded-lg px-2 py-1.5 text-sm font-medium focus:border-[#764BA2] focus:ring-0"
                                            required>
                                    </div>
                                    <div class="col-span-2 px-2 py-2 border-r border-slate-100">
                                        <input type="text" x-model="level.grade" :name="`criteria[${cIndex}][levels][${lIndex}][grade]`"
                                            placeholder="A, B+, etc."
                                            class="w-full border-slate-200 rounded-lg px-2 py-1.5 text-sm font-bold text-[#764BA2] focus:border-[#764BA2] focus:ring-0"
                                            required>
                                    </div>
                                    <div class="col-span-5 px-2 py-2 border-r border-slate-100">
                                        <input type="text" x-model="level.description" :name="`criteria[${cIndex}][levels][${lIndex}][description]`"
                                            placeholder="Performance descriptor..."
                                            class="w-full border-slate-200 rounded-lg px-2 py-1.5 text-sm focus:border-[#764BA2] focus:ring-0"
                                            required>
                                    </div>
                                    <div class="col-span-1 px-2 py-2 flex items-center justify-center">
                                        <button type="button" @click="removeLevel(cIndex, lIndex)"
                                            class="text-slate-400 hover:text-red-500 transition-colors p-1 hover:bg-red-50 rounded"
                                            :disabled="criterion.levels.length <= 1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- Quick Add Default Levels --}}
                        <button type="button" @click="addDefaultLevels(cIndex)"
                            class="text-xs text-slate-500 hover:text-[#764BA2] underline">
                            + Add standard 5-level grading scale (E, D, C, B, A)
                        </button>
                    </div>
                </div>
            </template>
        </div>

        {{-- Footer --}}
        <div class="pt-6 border-t border-slate-100 space-y-6">
            <div class="flex items-center gap-4">
                <span class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Weight</span>
                <div :class="totalWeight === 100 ? 'bg-green-50 text-green-600 border-green-200' : 'bg-red-50 text-red-500 border-red-200'"
                    class="flex items-center gap-2 px-4 py-2 rounded-2xl border transition-all duration-500 shadow-sm">
                    <span class="text-lg font-black leading-none" x-text="totalWeight.toFixed(2) + '%'"></span>
                    <template x-if="totalWeight === 100">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </template>
                    <template x-if="totalWeight !== 100">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </template>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                <button type="button" @click="addCriterion()"
                    class="w-full sm:w-auto px-6 py-3 bg-white text-[#764BA2] border-2 border-[#764BA2]/20 font-bold rounded-2xl hover:bg-[#764BA2]/5 transition-all flex items-center justify-center gap-2 shadow-sm text-sm uppercase tracking-widest">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Criterion
                </button>

                <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                    <a href="{{ route('rubrics.index') }}"
                        class="w-full sm:w-auto px-6 py-3 text-slate-500 font-bold text-sm hover:text-slate-700 transition-colors text-center uppercase tracking-widest">
                        Cancel
                    </a>
                    <button type="submit" :disabled="totalWeight !== 100"
                        :class="totalWeight !== 100 ? 'bg-slate-300 cursor-not-allowed shadow-none' : 'bg-[#764BA2] hover:bg-[#633e8a] shadow-lg shadow-indigo-200/50 active:scale-95'"
                        class="w-full sm:w-auto px-10 py-3 text-white font-bold rounded-2xl transition-all text-sm uppercase tracking-widest">
                        Update Rubric
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        function rubricHandler(initialData) {
            return {
                criteria: (initialData && initialData.length > 0) ? initialData.map(c => ({
                    ...c,
                    levels: c.levels || [{ min: 0, max: 44.99, grade: 'E', description: '' }]
                })) : [{
                    indicator: '',
                    criteria: '',
                    weight: 0,
                    levels: [{ min: 0, max: 44.99, grade: 'E', description: '' }]
                }],

                addCriterion() {
                    this.criteria.push({
                        indicator: '',
                        criteria: '',
                        weight: 0,
                        levels: [{ min: 0, max: 44.99, grade: 'E', description: '' }]
                    });
                },

                removeCriterion(index) {
                    if (this.criteria.length > 1) {
                        this.criteria.splice(index, 1);
                    }
                },

                addLevel(criterionIndex) {
                    this.criteria[criterionIndex].levels.push({
                        min: 0,
                        max: 100,
                        grade: '',
                        description: ''
                    });
                },

                removeLevel(criterionIndex, levelIndex) {
                    if (this.criteria[criterionIndex].levels.length > 1) {
                        this.criteria[criterionIndex].levels.splice(levelIndex, 1);
                    }
                },

                addDefaultLevels(criterionIndex) {
                    this.criteria[criterionIndex].levels = [
                        { min: 0, max: 44.99, grade: 'E', description: 'Does not meet minimum expectations' },
                        { min: 45, max: 54.99, grade: 'D', description: 'Below expectations, needs significant improvement' },
                        { min: 55, max: 69.99, grade: 'C, C+', description: 'Meets basic expectations with some doubts' },
                        { min: 70, max: 84.99, grade: 'B-, B, B+', description: 'Meets expectations well' },
                        { min: 85, max: 100, grade: 'A-, A', description: 'Exceeds expectations, excellent work' }
                    ];
                },

                get totalWeight() {
                    return this.criteria.reduce((sum, c) => sum + parseFloat(c.weight || 0), 0);
                }
            }
        }
    </script>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('assignment_dropdown');
            dropdown.classList.toggle('hidden');
        }

        function selectAssignment(value, text) {
            document.getElementById('assignment_id').value = value;
            document.getElementById('assignment_search').value = text;
            document.getElementById('assignment_dropdown').classList.add('hidden');
        }

        document.getElementById('assignment_filter').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const options = document.querySelectorAll('.assignment-option');
            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                if (text.includes(filter)) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        });

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('assignment_dropdown');
            const searchInput = document.getElementById('assignment_search');
            if (!dropdown.contains(event.target) && !searchInput.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        document.querySelectorAll('.assignment-option').forEach(option => {
            option.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                const text = this.getAttribute('data-text');
                selectAssignment(value, text);
            });
        });
    </script>
</x-edit-layout>
