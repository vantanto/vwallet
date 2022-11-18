<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form class="card card-md" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Login to your account</h2>
            <div class="mb-3">
                <label class="form-label">Username or Email address</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Enter username or email" 
                    value="{{ old('username') }}"
                    required autofocus tabindex="1">
                <x-input-error :messages="$errors->get('username')" />
            </div>
            <div class="mb-2">
                <label class="form-label">
                    Password
                    @if (Route::has('password.request'))
                    <span class="form-label-description">
                        <a href="{{ route('password.request') }}">I forgot password</a>
                    </span>
                    @endif
                </label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" autocomplete="off"
                    required tabindex="2">
                <x-input-error :messages="$errors->get('password')" />
            </div>
            <div class="mb-2">
                <label class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" />
                    <span class="form-check-label">Remember me on this device</span>
                </label>
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100" tabindex="3">Sign in</button>
            </div>
        </div>
    </form>
    @if (Route::has('register'))
    <div class="text-center text-muted mt-3">
        Don't have account yet? <a href="{{ route('register') }}" tabindex="-1">Sign up</a>
    </div>
    @endif
</x-guest-layout>
