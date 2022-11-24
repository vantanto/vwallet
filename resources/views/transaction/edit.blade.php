<x-app-layout>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">Transaction Edit</h2>
        </div>
    </x-slot>
    <form id="mainForm" method="post" action="{{ route('transactions.update', [request()->route('wallet'), $transaction->id]) }}" autocomplete="off">
        @csrf
        <div class="card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" id="type_in" name="type" class="btn-check" 
                                    value="in" required @if($transaction->type == "in") checked @endif>
                                <label for="type_in" type="button" class="btn text-success">Income</label>
                                <input type="radio" id="type_out" name="type" class="btn-check" 
                                    value="out" @if($transaction->type == "out") checked @endif>
                                <label for="type_out" type="button" class="btn text-danger">Expense</label>
                                <input type="radio" id="type_transfer" name="type" class="btn-check" 
                                    value="transfer" @if($transaction->type == "transfer") checked @endif>
                                <label for="type_transfer" type="button" class="btn text-info">Transfer</label>
                            </div>
                        </div>
                        <div id="parent_designated_wallet" style="@if($transaction->type != "transfer") display: none; @endif">
                            <label class="form-label">Designated Wallet</label>
                            <select id="designated_wallet" name="designated_wallet" class="form-select"
                                required @if($transaction->type != "transfer") disabled @endif>
                                <option value="" selected disabled>Select Designated Wallet</option>
                                @foreach ($designatedWallets as $designatedWallet)
                                <option value="{{ $designatedWallet->id }}"
                                    @if($transaction->type == "transfer"
                                        && ($transaction->designated_wallet_id ? $transaction->designated_wallet_id : $transaction->designatedWalletChild->id)
                                        == $designatedWallet->id) 
                                        selected 
                                    @endif>
                                    {{ $designatedWallet->name }}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Date</label>
                        <input type="date" id="date" name="date" class="form-control"
                            value="{{ $transaction->date }}" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Nominal</label>
                        <input type="text" id="nominal" name="nominal" class="form-control" placeholder="Enter nominal" 
                            value="{{ $transaction->nominal_format }}"
                            data-type="thousand"
                            required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Category</label>
                        <select id="category" name="category" class="form-select" style="width: 100%;" 
                            required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($categories['main'] as $mainCategory)
                            <optgroup label="{{ $mainCategory->name }}">
                                <option value="{{ $mainCategory->id }}"
                                    @if($transaction->category_id == $mainCategory->id) selected @endif>
                                    {{ $mainCategory->name }}
                                </option>
                                @foreach ($mainCategory->categories as $category)
                                <option value="{{ $category->id }}"
                                    @if($transaction->category_id == $category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </optgroup>
                            @endforeach
                            @if($categories['user']->isNotEmpty())
                            <optgroup label="User Category">
                                @foreach ($categories['user'] as $userCategory)
                                <option value="{{ $userCategory->id }}"
                                    @if($transaction->category_id == $userCategory->id) selected @endif>
                                    {{ $userCategory->name }}
                                </option>
                                @endforeach
                            </optgroup>
                            @endif
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="3">{{ $transaction->description }}</textarea>
                    </div>
                </div>
                <button type="submit" id="mainFormBtn" class="btn btn-primary">Submit</button>
                <a href="{{ route('wallets.detail', $wallet->id) }}" class="ms-3">Back</a>
                <button type="button" form="deleteForm" class="btn btn-danger float-end"
                    onclick="confirmSwalAlert(this)">
                    Delete
                </button>
            </div>
        </div>
    </form>
    <form id="deleteForm" method="post" action="{{ route('transactions.destroy', [$wallet->id, $transaction->id]) }}">
        @csrf
    </form>
@section('script')
<script src="{{ asset('assets/js/submitForm.js') }}"></script>
<script>mainFormSubmit()</script>
<script>
    new TomSelect('#category', settingsTomSelect);

    $(document).on('change', 'input[name="type"]', function() {
        const isVisible = this.value == "transfer";
        $("#parent_designated_wallet").toggle(isVisible);
        $("#designated_wallet").prop('disabled', !isVisible);
    });
</script>
@endsection
</x-app-layout>