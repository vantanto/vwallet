<x-app-layout>
    <x-slot name="header">
        Profile
    </x-slot>

    <div class="row">
        <div class="col-md-6 col-lg-3 mb-3">
          <div class="card">
            <div class="card-body p-4 text-center">
              <span class="avatar avatar-xl mb-3 avatar-rounded" style="background-image: url({{ $user->avatar_url }})"></span>
              <h3 class="m-0 mb-1">{{ $user->name }}</h3>
              <div class="text-muted">{{ $user->username }}</div>
              <div class="mt-3">
                <span class="badge bg-muted-lt">Free</span>
              </div>
            </div>
            <div class="d-flex">
              <div class="card-footer">
                <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="5" width="18" height="14" rx="2" /><polyline points="3 7 12 13 21 7" /></svg>
                {{ $user->email }}</div>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-9 mb-3">
            <div class="card">
                <div class="p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
    
                <div class="p-4">
                    @include('profile.partials.update-password-form')
                </div>
    
                {{-- <div class="p-4">
                    @include('profile.partials.delete-user-form')
                </div> --}}
            </div>
        </div>
    </div>
</x-app-layout>
