@extends('layouts.app')

@section('content')
    <x-toast message="" type="warning" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                        Edit Submission
                    </h2>

                    <form method="POST" action="{{ route('submissions.update', $submission) }}" id="submissionForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="student_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Student Name</label>
                            <input type="text" name="student_name" id="student_name" value="{{ $submission->student_name }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                            @error('student_name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assignment</label>
                            <p class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm p-2">{{ $submission->assignment->title }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">File</label>
                            <p class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm p-2">{{ basename($submission->file_path) }}</p>
                        </div>

                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Update Submission
                        </button>
                        <a href="{{ route('submissions.index') }}" class="ml-4 text-gray-600 hover:text-white">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
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
    </script>
@endsection