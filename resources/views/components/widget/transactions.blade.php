@props(['wallet', 'transactions'])

<div class="card">
    <div class="card-header border-0">
        @if($wallet)
        <div class="card-title">
            <a href="{{ route('wallets.detail', $wallet->id) }}" class="text-reset">{{ $wallet->name }}</a>
            <h3 class="mb-0">{{ $wallet->balance_format }}</h3>
        </div>
        <div class="card-actions">
            <a href="{{ route('transactions.create', $wallet->id) }}" class="btn btn-primary">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
            </a>
        </div>
        @else
        <div class="card-title">
            <div>No Main Wallet</div>
            <a href="{{ route('wallets.create') }}">Create new wallet</a>
        </div>
        @endif
    </div>
    
    @if($wallet)
    <div class="card-body pt-0">
        <x-list-transactions :transactions="$transactions" />
        @if (count($transactions) == 7)
        <a href="{{ route('wallets.detail', $wallet->id) }}" class="d-block text-center">View More</a>
        @endif
    </div>
    @endif
</div>