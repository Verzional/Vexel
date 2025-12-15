<x-guest-layout>
    <div class="mb-8"> <h2 class="text-4xl font-bold text-gray-900 text-center lg:text-left">Login Account</h2>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-6">
            <label for="email" class="block text-base font-medium text-gray-700 mb-2">Email</label>
            <input id="email" class="w-full px-4 py-3.5 rounded-xl border border-gray-300 focus:border-[#667EEA] focus:ring focus:ring-[#667EEA] focus:ring-opacity-30 transition-all bg-white placeholder-gray-400" 
                   type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-2" x-data="{ show: false }">
            <label for="password" class="block text-base font-medium text-gray-700 mb-2">Password</label>
            <div class="relative">
                <input id="password" 
                       class="w-full px-4 py-3.5 rounded-xl border border-gray-300 focus:border-[#667EEA] focus:ring focus:ring-[#667EEA] focus:ring-opacity-30 transition-all bg-white placeholder-gray-400 pr-12"
                       :type="show ? 'text' : 'password'" 
                       name="password" 
                       required 
                       autocomplete="current-password" />
                
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mb-8">
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-[#667EEA] hover:text-[#5a6fd6] hover:underline" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="w-full py-3.5 px-4 bg-[#667EEA] hover:bg-[#5a6fd6] text-white font-bold rounded-xl shadow-md transform transition hover:-translate-y-0.5 active:translate-y-0 text-lg">
            Login
        </button>

        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-bold text-[#667EEA] hover:text-[#5a6fd6] hover:underline">
                    Sign Up
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>