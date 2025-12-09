@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Rubric Details') }}
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
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $rubric->subject_name }}
                                </h1>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Rubric Overview</p>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('rubrics.edit', $rubric) }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    Edit Rubric
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Criteria Section -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                            Evaluation Criteria
                        </h2>
                        <div class="rounded-lg overflow-hidden">
                            <div class="py-4">
                                <div class="space-y-4">
                                    @foreach ($rubric->criteria as $index => $criterion)
                                        <div
                                            class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-md shadow-sm border border-gray-200 dark:border-gray-600">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 w-8 h-8 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center">
                                                    <span
                                                        class="text-sm font-medium text-indigo-600 dark:text-indigo-400">{{ $index + 1 }}</span>
                                                </div>
                                                <div class="ml-4">
                                                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $criterion['name'] }}</h3>
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    Weight: {{ $criterion['weight'] }}%
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="flex justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('rubrics.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Rubrics
                        </a>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Last updated: {{ $rubric->updated_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
