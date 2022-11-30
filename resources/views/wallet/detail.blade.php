<x-app-layout>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">Wallet Detail</h2>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-body text-center">
                        <h3 class="m-0 mb-1">{{ $wallet->name }}</h3>
                        <h2 class="m-0 mb-2">{{ $wallet->balance_format }}</h2>
                        @if($wallet->is_main)
                        <div class="mt-3">
                            <span class="badge bg-primary-lt">Main</span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <a href="{{ route('wallets.edit', $wallet->id) }}" class="btn btn-outline-warning">Edit</a>
                        <form method="post" action="{{ route('wallets.destroy', $wallet->id) }}" class="ms-auto">
                            @csrf
                            <button type="button" class="btn btn-outline-danger"
                                onclick="confirmSwalAlert(this)">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-9 mb-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transaction <small class="text-muted">(current month)</small></h3>
                    <div class="card-actions">
                        <a href="{{ route('transactions.create', $wallet->id) }}" class="btn btn-primary">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                            Add new
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <x-list-transactions :transactions="$transactions" />
                </div>
            </div>
        </div>
    </div>
@section('script')
<script src="{{ asset('assets/js/submitForm.js') }}"></script>
<script>mainFormSubmit()</script>
@endsection
</x-app-layout>