<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-teal-600 mb-2">Login</h2>
        <p class="text-gray-600 text-base">Sign in to your account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500" name="remember">
            <label for="remember_me" class="ms-2 text-sm text-gray-600">Remember me</label>
        </div>

        <div class="space-y-3">
            <button type="submit" class="form-button">
                Log in
            </button>

            @if (Route::has('password.request'))
                <div class="text-center">
                    <a class="form-link" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                </div>
            @endif

            <div class="text-center">
                <span class="text-sm text-gray-600">Don't have an account? </span>
                <a href="{{ route('register') }}" class="form-link">Register here</a>
            </div>
        </div>
    </form>
</x-guest-layout>
