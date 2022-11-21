<x-app-layout>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">Category</h2>
        </div>
        <div class="col-auto">
            <div class="btn-list">
                <a href="{{ route('categories.create') }}" class="btn">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    New Category
                </a>
            </div>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Category</h3>
        </div>
        <div class="list-group list-group-flush">
            @foreach ($categories as $category)
            <div class="d-flex align-items-center justify-content-between">
                <a href="#" class="list-group-item list-group-item-action">
                    {{ $category->name }}
                </a>
                <div>
                    <span class="dropdown">
                        <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('categories.edit', $category->id) }}">
                                Edit
                            </a>
                            <form method="post" action="{{ route('categories.destroy', $category->id) }}">
                                @csrf
                                <button type="button" class="dropdown-item text-danger"
                                    onclick="confirmSwalAlert(this)">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</x-app-layout>