<x-guest-layout>
    <!-- Logo / Avatar -->
    <div class="flex justify-center mb-4">
        {{-- Kalau sudah ada logo brand, tinggal ganti src-nya --}}
        <img src="{{ asset('images/logo.png') }}" 
             onerror="this.src='https://cdn-icons-png.flaticon.com/512/847/847969.png'" 
             alt="Logo" 
             class="w-16 h-16 rounded-full border-2 border-blue-950 shadow-md">
    </div>

    <h1 class="text-center text-2xl font-bold text-blue-950 mb-6">Register</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-blue-950 font-semibold" />
            <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-blue-950 focus:ring-blue-950 rounded-md shadow-sm" 
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-blue-950 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-blue-950 focus:ring-blue-950 rounded-md shadow-sm"
                type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-blue-950 font-semibold" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-blue-950 focus:ring-blue-950 rounded-md shadow-sm"
                type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-blue-950 font-semibold" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-blue-950 focus:ring-blue-950 rounded-md shadow-sm"
                type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-between mt-6">
            <a class="text-sm font-medium text-blue-950 hover:text-blue-800 transition" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="bg-blue-950 hover:bg-blue-900 focus:ring-blue-950">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
