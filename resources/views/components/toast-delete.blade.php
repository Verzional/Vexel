@props(['message' => 'Are you sure you want to delete this item? This action cannot be undone.'])

<script>
    function confirmDelete(id) {
        const toast = document.createElement('div');
        toast.id = 'confirm-toast';
        toast.className = 'fixed bottom-4 right-4 z-50';
        toast.innerHTML = `
            <div class="w-96 bg-white dark:bg-gray-800 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Confirm Deletion</p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $message }}</p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex space-x-2">
                            <button type="button" onclick="proceedDelete(${id})" class="inline-flex text-red-600 hover:text-red-900">Yes</button>
                            <button type="button" onclick="hideConfirmToast()" class="inline-flex text-gray-400 hover:text-gray-500">No</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(toast);
    }

    function hideConfirmToast() {
        const toast = document.getElementById('confirm-toast');
        if (toast) toast.remove();
    }

    function proceedDelete(id) {
        document.getElementById(`delete-form-${id}`).submit();
        hideConfirmToast();
    }
</script>