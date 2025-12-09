@extends('layouts.app')

@section('content')
    <x-toast message="" type="warning" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                        Edit Rubric
                    </h2>

                    <form method="POST" action="{{ route('rubrics.update', $rubric) }}" id="rubricForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="subject_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject Name</label>
                            <input type="text" name="subject_name" id="subject_name" value="{{ $rubric->subject_name }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                            @error('subject_name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="criteria" class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Criteria</h3>
                            @foreach($rubric->criteria as $index => $criterion)
                                <div class="criterion mb-2" data-index="{{ $index }}">
                                    <div class="flex space-x-2 items-end">
                                        <div class="flex-1">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Criteria Name</label>
                                            <input type="text" name="criteria[{{ $index }}][name]" value="{{ $criterion['name'] }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Weight</label>
                                            <input type="number" name="criteria[{{ $index }}][weight]" value="{{ $criterion['weight'] }}" step="0.01" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm weight-input" required>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <button type="button" onclick="deleteCriterion(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" {{ count($rubric->criteria) <= 1 ? 'disabled' : '' }}>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Weight: <span id="totalWeight">0</span>%</p>
                        </div>

                        <button type="button" onclick="addCriterion()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                            Add Criterion
                        </button>

                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Update Rubric
                        </button>
                        <a href="{{ route('rubrics.index') }}" class="ml-4 text-gray-600 hover:text-white">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let count = {{ count($rubric->criteria) }};

        function addCriterion() {
            const div = document.createElement('div');
            div.className = 'criterion mb-2';
            div.setAttribute('data-index', count);
            div.innerHTML = `
        <div class="flex space-x-2 items-end">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Criteria Name</label>
                <input type="text" name="criteria[${count}][name]" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Weight</label>
                <input type="number" name="criteria[${count}][weight]" step="0.01" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm weight-input" required>
            </div>
            <div class="flex-shrink-0">
                <button type="button" onclick="deleteCriterion(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Delete
                </button>
            </div>
        </div>
    `;
            document.getElementById('criteria').appendChild(div);
            const newInput = div.querySelector('.weight-input');
            newInput.addEventListener('input', updateTotalWeight);
            count++;
            updateTotalWeight();
        }

        function deleteCriterion(button) {
            const criterionDiv = button.closest('.criterion');
            const criteria = document.querySelectorAll('.criterion');
            if (criteria.length > 1) {
                criterionDiv.remove();
                updateTotalWeight();
                // Re-enable delete buttons if now more than one
                const deleteButtons = document.querySelectorAll('button[onclick="deleteCriterion(this)"]');
                deleteButtons.forEach(btn => btn.disabled = false);
            } else {
                showToast('At least one criterion is required.', 'warning');
            }
        }

        function updateTotalWeight() {
            const weightInputs = document.querySelectorAll('.weight-input');
            let total = 0;
            weightInputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                total += value;
            });
            document.getElementById('totalWeight').textContent = total.toFixed(2);
        }

        function showToast(message, type = 'error') {
            const toast = document.getElementById('toast');
            const messageEl = document.getElementById('toast-message');
            messageEl.textContent = message;
            toast.classList.remove('hidden');
            // Auto-hide after 5 seconds
            setTimeout(() => {
                hideToast();
            }, 5000);
        }

        function hideToast() {
            const toast = document.getElementById('toast');
            toast.classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateTotalWeight();

            document.querySelectorAll('.weight-input').forEach(input => {
                input.addEventListener('input', updateTotalWeight);
            });

            document.getElementById('rubricForm').addEventListener('submit', function(e) {
                const totalWeight = parseFloat(document.getElementById('totalWeight').textContent);
                if (Math.abs(totalWeight - 100) > 0.01) {
                    e.preventDefault();
                    showToast('The total weight of all criteria must equal 100%. Current total: ' + totalWeight.toFixed(2) + '%', 'warning');
                }
            });
        });
    </script>
@endsection