<x-app-layout>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">Category Create</h2>
        </div>
    </x-slot>

    <form id="mainForm" method="post" action="{{ route('categories.store') }}" autocomplete="off">
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
                </div>
                <button type="submit" id="mainFormBtn" class="btn btn-primary">Submit</button>
                <a href="{{ route('categories.index') }}" class="ms-3">Back</a>
            </div>
        </div>
    </form>
@section('script')
<script src="{{ asset('assets/js/submitForm.js') }}"></script>
<script>mainFormSubmit()</script>
@endsection
</x-app-layout>