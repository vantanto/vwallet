<section>
    <header>
        <h2>Profile Information</h2>
        <p class="mt-1">Update your account's profile information and email address.</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" autocomplete="off"
        enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Enter name"
                value="{{ old('name', $user->name) }}"
                required>
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="mb-3">
            <label class="form-label">Avatar</label>
            <input type="file" id="avatar" name="avatar" class="form-control"
                accept=".png, .jpg, .jpeg">
            <x-input-error :messages="$errors->get('avatar')" />
        </div>

        <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-primary">Save</button>
            @if (session('status') === 'profile-updated')
                <div class="text-success ms-3">Saved</div>
            @endif
        </div>
    </form>
</section>
