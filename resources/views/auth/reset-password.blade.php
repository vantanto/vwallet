<x-guest-layout>
    <form class="card card-md" action="{{ route('password.store') }}" method="POST">
        @csrf
        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter email"
                    value="{{ old('email', $request->email) }}"
                    required>
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password"
                    required>
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Enter password confirmation"
                    required>
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>
            
            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">
                    Reset Password
                </button>
            </div>
        </div>
    </form>
</x-guest-layout>
