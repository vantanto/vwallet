<x-guest-layout>
    <form class="card card-md" action="{{ route('register') }}" method="POST">
        @csrf
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Create new account</h2>
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter name"
                    value="{{ old('name') }}"
                    required>
                <x-input-error :messages="$errors->get('name')" />
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Enter username"
                    value="{{ old('username') }}"
                    required>
                <x-input-error :messages="$errors->get('username')" />
            </div>
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter email"
                    value="{{ old('email') }}"
                    required>
                <x-input-error :messages="$errors->get('email')" />
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group input-group-flat">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" autocomplete="off"
                    required>
                    <span class="input-group-text">
                        <button type="button" id="show_password" class="btn-link">
                            <!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="12" cy="12" r="2" />
                                <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                            </svg>
                        </button>
                    </span>
                </div>
                <x-input-error :messages="$errors->get('password')" />
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Create new account</button>
            </div>
        </div>
    </form>
    <div class="text-center text-muted mt-3">
        Already have account? <a href="{{ route('login') }}" tabindex="-1">Sign in</a>
    </div>

@section('script')
<script>
    const show_password = document.getElementById("show_password");
    show_password.addEventListener("click", function() {
        var password = document.getElementById("password");
        password.type = password.type === "password" ? "text" : "password";
    });
</script>
@endsection
</x-guest-layout>