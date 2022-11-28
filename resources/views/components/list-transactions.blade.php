@props(['transactions'])

<div class="list-group list-group-flush list-group-hoverable">
    @forelse($transactions as $transaction)
    <div class="list-group-item">
        <div class="row align-items-center">
            @php 
                $typeColor = "";
                if ($transaction->type_in_out == "in") $typeColor = "success";
                else if ($transaction->type_in_out == "out") $typeColor = "danger";
            @endphp
            <div class="col-auto"><span class="badge bg-{{ $typeColor }}"></span></div>
            <div class="col-auto">
                <i class="{{ $transaction->category->icon }} display-6"></i>
            </div>
            <div class="col d-flex justify-content-between">
                <div class="col text-truncate">
                    <a href="{{ ($transaction->type == "transfer" && $transaction->designated_wallet_id)
                        ? route('transactions.edit', [$transaction->designated_wallet_id, $transaction->designated_transaction_id])
                        : route('transactions.edit', [$transaction->wallet_id, $transaction->id]) }}" 
                        class="text-reset d-block">
                        {{ $transaction->category->name }}
                    </a>
                    @if ($transaction->type == "transfer")
                    <div>
                        <span class="badge bg-info">
                            @if ($transaction->designated_wallet_id)
                            From {{ $transaction->designatedWallet->name }}
                            @else
                            To {{ $transaction->designatedWalletChild->name }}
                            @endif
                        </span>
                    </div>
                    @endif
                    <div class="d-block text-muted text-truncate mt-n1">{{ $transaction->description }}</div>
                </div>
                <div class="text-end">
                    <h3 class="text-{{ $typeColor }} mb-0">
                        @if($transaction->type_in_out == "in")
                        + 
                        @elseif($transaction->type_in_out == "out")
                        -
                        @endif
                        {{ $transaction->nominal_format }}
                    </h3>
                    <div class="text-muted mb-0">{{ $transaction->date_short }}</div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div>No Transaction</div>
    @endforelse
</div>