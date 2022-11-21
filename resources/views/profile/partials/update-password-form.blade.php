<section>
    <header>
        <h2>Update Password</h2>
        <p class="mt-1">Ensure your account is using a long, random password to stay secure.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Enter name"
                required>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter name"
                required>
            <x-input-error :messages="$errors->updatePassword->get('password')" />
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Enter name"
                required>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-primary">Save</button>
            @if (session('status') === 'password-updated')
                <div class="text-success ms-3">Saved</div>
            @endif
        </div>
    </form>
</section>
