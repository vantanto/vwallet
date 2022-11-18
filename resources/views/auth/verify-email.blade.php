<x-guest-layout>
    <div class="card card-md">
        <div class="card-body">
            <p class="text-muted mb-4">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-success">
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            @endif

            <div class="mt-4 d-flex align-items-center justify-content-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link">
                        Log Out
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>
