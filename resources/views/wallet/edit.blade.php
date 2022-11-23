<x-app-layout>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">Wallet Edit</h2>
        </div>
    </x-slot>

    <form id="mainForm" method="post" action="{{ route('wallets.update', $wallet->id) }}" autocomplete="off">
        @csrf
        <div class="card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter name" 
                            value="{{ $wallet->name }}"
                            required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Balance</label>
                        <input type="text" id="balance" name="balance" class="form-control" placeholder="Enter balance" 
                            data-type="thousand"
                            value="{{ $wallet->balance_format }}"
                            required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-check">
                        <input type="checkbox" name="is_main" class="form-check-input" value="1" 
                            @if($wallet->is_main) checked disabled @endif/>
                        <span class="form-check-label">Main Wallet</span>
                    </label>
                </div>
                <button type="submit" id="mainFormBtn" class="btn btn-primary">Submit</button>
                <a href="{{ route('wallets.detail', $wallet->id) }}" class="ms-3">Back</a>
            </div>
        </div>
    </form>
@section('script')
<script src="{{ asset('assets/js/submitForm.js') }}"></script>
<script>mainFormSubmit()</script>
@endsection
</x-app-layout>