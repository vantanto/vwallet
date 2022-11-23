<x-app-layout>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">Transaction Create</h2>
        </div>
    </x-slot>
    <form id="mainForm" method="post" action="{{ route('transactions.store', request()->route('wallet')) }}" autocomplete="off">
        @csrf
        <div class="card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Type</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" id="type_in" name="type" class="btn-check" 
                                value="in" required>
                            <label for="type_in" type="button" class="btn text-success">Income</label>
                            <input type="radio" id="type_out" name="type" class="btn-check" 
                                value="out" checked>
                            <label for="type_out" type="button" class="btn text-danger">Expense</label>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Date</label>
                        <input type="date" id="date" name="date" class="form-control"
                            value="{{ date('Y-m-d') }}" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Nominal</label>
                        <input type="text" id="nominal" name="nominal" class="form-control" placeholder="Enter nominal" 
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
                                <option value="{{ $mainCategory->id }}">
                                    {{ $mainCategory->name }}
                                </option>
                                @foreach ($mainCategory->categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </optgroup>
                            @endforeach
                            @if($categories['user']->isNotEmpty())
                            <optgroup label="User Category">
                                @foreach ($categories['user'] as $userCategory)
                                <option value="{{ $userCategory->id }}">
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
                        <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <button type="submit" id="mainFormBtn" class="btn btn-primary">Submit</button>
                <a href="{{ route('wallets.detail', $wallet->id) }}" class="ms-3">Back</a>
            </div>
        </div>
    </form>
@section('script')
<script src="{{ asset('assets/js/submitForm.js') }}"></script>
<script>mainFormSubmit()</script>
<script>
    $("#category").select2({
        placeholder: 'Select Category 2',
        theme: 'bootstrap-5'
    })
</script>
@endsection
</x-app-layout>