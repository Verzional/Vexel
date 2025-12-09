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

                    <!-- Assignment Section -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                            Assignment
                        </h2>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-gray-700 dark:text-gray-300">{{ $submission->assignment->title }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 text-wrap whitespace-pre-line   ">
                                {{ $submission->assignment->description }}</p>
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
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <p class="text-gray-700 dark:text-gray-300"><strong>Grade:</strong>
                                    {{ $submission->result->grade }}/100</p>
                                <p class="text-gray-700 dark:text-gray-300 mt-2"><strong>Reasoning: <br /> </strong>
                                    {{ $submission->result->reasoning }}</p>
                                @if ($submission->result->feedback)
                                    <p class="text-gray-700 dark:text-gray-300 mt-2"><strong>Overall Feedback: <br />
                                        </strong>
                                        {{ $submission->result->feedback }}</p>
                                @endif
                                @if ($submission->result->notable_points)
                                    <p class="text-gray-700 dark:text-gray-300 mt-2"><strong>Notable Points: </br> </strong>
                                        {!! nl2br(e($submission->result->notable_points)) !!}</p>
                                @endif
                                @if ($submission->result->breakdown)
                                    <p class="text-gray-700 dark:text-gray-300 mt-2"><strong> Grading Breakdown: <br />
                                        </strong>
                                        @foreach ($submission->result->breakdown as $item)
                                            <p class="text-gray-700 dark:text-gray-300 mt-2">{{ $item['criterion'] }}
                                                Score: {{ $item['score'] }} / {{ $item['max_score'] }}</p>
                                        @endforeach
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                Grade Submission
                            </h2>
                            <form id="grade-form" action="{{ route('submissions.grade', $submission) }}" method="POST"
                                class="inline">
                                @csrf
                                <button id="grade-button" type="submit"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    AI Grade Submission
                                </button>
                            </form>
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
