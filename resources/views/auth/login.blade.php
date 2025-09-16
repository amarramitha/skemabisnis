<x-guest-layout>

    <div class="flex justify-center mb-4">
        <img src="{{ asset('images/logo.png') }}" 
             onerror="this.src='https://cdn-icons-png.flaticon.com/512/847/847969.png'" 
             alt="Logo" 
             class="w-16 h-16 rounded-full border-2 border-blue-950 shadow-md">
    </div>

    <h1 class="text-center text-2xl font-bold text-blue-950 mb-6">Login</h1>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-blue-950 font-semibold" />
            <x-text-input id="email" 
                class="block mt-1 w-full border-gray-300 focus:border-blue-950 focus:ring-blue-950 rounded-md shadow-sm" 
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-blue-950 font-semibold" />
            <x-text-input id="password" 
                class="block mt-1 w-full border-gray-300 focus:border-blue-950 focus:ring-blue-950 rounded-md shadow-sm"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-blue-950 hover:text-blue-800 transition" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="bg-blue-950 hover:bg-blue-900 focus:ring-blue-950">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
