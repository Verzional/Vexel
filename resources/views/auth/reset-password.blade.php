<x-guest-layout title="Reset Password">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Reset Password</h2>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-5">
            <label for="email" class="block text-base font-medium text-gray-700 mb-2">Email</label>
            <input id="email" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#667EEA] focus:ring focus:ring-[#667EEA] focus:ring-opacity-30 transition-all bg-white" 
                   type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-5">
            <label for="password" class="block text-base font-medium text-gray-700 mb-2">New Password</label>
            <input id="password" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#667EEA] focus:ring focus:ring-[#667EEA] focus:ring-opacity-30 transition-all bg-white" 
                   type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-base font-medium text-gray-700 mb-2">Confirm Password</label>
            <input id="password_confirmation" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#667EEA] focus:ring focus:ring-[#667EEA] focus:ring-opacity-30 transition-all bg-white"
                   type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="w-full py-3 px-4 bg-[#667EEA] hover:bg-[#5a6fd6] text-white font-bold rounded-xl shadow-md transform transition hover:-translate-y-0.5 active:translate-y-0 text-lg">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>