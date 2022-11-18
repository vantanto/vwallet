<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form class="card card-md" action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Forgot password</h2>
            <p class="text-muted mb-4">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter email"
                    value="{{ old('email') }}"
                    required>
                <x-input-error :messages="$errors->get('email')" />
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">
                    <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <rect x="3" y="5" width="18" height="14" rx="2" />
                        <polyline points="3 7 12 13 21 7" />
                    </svg>
                    Email Password Reset Link
                </button>
            </div>
        </div>
    </form>
    <div class="text-center text-muted mt-3">
        Forget it, <a href="{{ route('login') }}">send me back</a> to the sign in screen.
    </div>
</x-guest-layout>