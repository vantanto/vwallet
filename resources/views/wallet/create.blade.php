<x-app-layout>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">Wallet Create</h2>
        </div>
    </x-slot>

    <form id="mainForm" method="post" action="{{ route('wallets.store') }}" autocomplete="off">
        @csrf
        <div class="card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter name" 
                            required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Balance</label>
                        <input type="text" id="balance" name="balance" class="form-control" placeholder="Enter balance" 
                            data-type="thousand"
                            required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-check">
                        <input type="checkbox" name="is_main" class="form-check-input" value="1" />
                        <span class="form-check-label">Main Wallet</span>
                    </label>
                </div>
                <button type="submit" id="mainFormBtn" class="btn btn-primary">Submit</button>
                <a href="{{ route('wallets.index') }}" class="ms-3">Back</a>
            </div>
        </div>
    </form>
@section('script')
<script src="{{ asset('assets/js/submitForm.js') }}"></script>
<script>mainFormSubmit()</script>
@endsection
</x-app-layout>