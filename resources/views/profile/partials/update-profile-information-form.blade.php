<section>
    <header class="mb-6">
        <h2 class="text-2xl font-bold text-gray-700">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-base font-medium text-gray-700 mb-2">
                {{ __('Name') }}
            </label>
            <input id="name" name="name" type="text"
                class="w-full px-4 py-3.5 rounded-xl border border-gray-300 focus:border-[#667EEA] focus:ring focus:ring-[#667EEA] focus:ring-opacity-30 transition-all bg-white placeholder-gray-400"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-base font-medium text-gray-700 mb-2">
                {{ __('Email') }}
            </label>
            <input id="email" name="email" type="email"
                class="w-full px-4 py-3.5 rounded-xl border border-gray-300 focus:border-[#667EEA] focus:ring focus:ring-[#667EEA] focus:ring-opacity-30 transition-all bg-white placeholder-gray-400"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <p class="text-sm text-gray-700">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-[#667EEA] hover:text-[#5a6fd6] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#667EEA]">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-6 py-3 bg-[#667EEA] hover:bg-[#5a6fd6] text-white font-bold rounded-xl shadow-md transform transition hover:-translate-y-0.5 active:translate-y-0 text-base">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 font-medium">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
