@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Submission Details') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8">
                    <!-- Header Section -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ $submission->student_name }}'s Submission</h1>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">For
                                    {{ $submission->assignment->title }}</p>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('submissions.edit', $submission) }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    Edit Submission
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- File Section -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                            Submitted File
                        </h2>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-gray-700 dark:text-gray-300">{{ basename($submission->file_path) }}</p>
                            <a href="{{ route('submissions.download', $submission) }}"
                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">Download
                                PDF</a>
                        </div>
                    </div>

                    <!-- Grading Section -->
                    @if ($submission->result)
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                Grading Result
                            </h2>
                            <div
                                class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-6 shadow-sm">
                                <!-- Grade Display -->
                                <div class="mb-6">
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-medium text-gray-900 dark:text-gray-100">Grade</span>
                                        <span
                                            class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $submission->result->grade }}/100</span>
                                    </div>
                                    <div class="mt-2 bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full"
                                            style="width: {{ $submission->result->grade }}%"></div>
                                    </div>
                                </div>
                                <!-- Reasoning -->
                                <div class="mb-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Reasoning</h3>
                                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                        {{ $submission->result->reasoning }}</p>
                                </div>
                                @if ($submission->result->feedback)
                                    <div class="mb-4">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Overall
                                            Feedback</h3>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                            {{ $submission->result->feedback }}</p>
                                    </div>
                                @endif
                                @if ($submission->result->notable_points)
                                    <div class="mb-4">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Notable Points
                                        </h3>
                                        <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                            {!! nl2br(e($submission->result->notable_points)) !!}</div>
                                    </div>
                                @endif
                                @if ($submission->result->breakdown)
                                    <div class="mb-4">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Grading
                                            Breakdown</h3>
                                        <div class="space-y-3">
                                            @foreach ($submission->result->breakdown as $item)
                                                <div
                                                    class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                                    <span
                                                        class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $item['criterion'] }}</span>
                                                    <span
                                                        class="text-sm text-gray-600 dark:text-gray-400">{{ $item['score'] }}
                                                        / {{ $item['max_score'] }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                Grade Submission
                            </h2>
                            <div
                                class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-6 shadow-sm text-center">
                                <p class="text-gray-600 dark:text-gray-400 mb-4">Grade this submission using AI?
                                </p>
                                <form id="grade-form" action="{{ route('submissions.grade', $submission) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button id="grade-button" type="submit"
                                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                        AI Grade Submission
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Footer Actions -->
                    <div class="flex justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('submissions.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Submissions
                        </a>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Submitted: {{ $submission->created_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('grade-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const button = document.getElementById('grade-button');
            const originalText = button.textContent;
            button.disabled = true;
            button.textContent = 'Grading...';

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                    button.disabled = false;
                    button.textContent = originalText;
                }
            } catch (error) {
                alert('An error occurred while grading.');
                button.disabled = false;
                button.textContent = originalText;
            }
        });
    </script>
@endsection
