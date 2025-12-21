<section>
    <header class="mb-6">
        <h2 class="text-2xl font-bold text-gray-700">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-base font-medium text-gray-700 mb-2">
                {{ __('Current Password') }}
            </label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="w-full px-4 py-3.5 rounded-xl border border-gray-300 focus:border-[#667EEA] focus:ring focus:ring-[#667EEA] focus:ring-opacity-30 transition-all bg-white placeholder-gray-400"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="block text-base font-medium text-gray-700 mb-2">
                {{ __('New Password') }}
            </label>
            <input id="update_password_password" name="password" type="password"
                class="w-full px-4 py-3.5 rounded-xl border border-gray-300 focus:border-[#667EEA] focus:ring focus:ring-[#667EEA] focus:ring-opacity-30 transition-all bg-white placeholder-gray-400"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-base font-medium text-gray-700 mb-2">
                {{ __('Confirm Password') }}
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="w-full px-4 py-3.5 rounded-xl border border-gray-300 focus:border-[#667EEA] focus:ring focus:ring-[#667EEA] focus:ring-opacity-30 transition-all bg-white placeholder-gray-400"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-6 py-3 bg-[#667EEA] hover:bg-[#5a6fd6] text-white font-bold rounded-xl shadow-md transform transition hover:-translate-y-0.5 active:translate-y-0 text-base">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 font-medium">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
