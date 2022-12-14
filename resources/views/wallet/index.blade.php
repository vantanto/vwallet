<x-app-layout>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">Wallet</h2>
        </div>
        <div class="col-auto">
            <div class="btn-list">
                <a href="{{ route('wallets.create') }}" class="btn">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    New Wallet
                </a>
            </div>
        </div>
    </x-slot>

    <div class="row row-cards">
        @foreach ($wallets as $wallet)
        <div class="col-lg-6">
            <div class="card">
                @if ($wallet->is_main)
                <div class="ribbon bg-primary">Main</div>
                @endif
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 p-3">
                            <!-- Download SVG icon from http://tabler-icons.io/i/wallet -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg" style="width: 100%; height: 100%;" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12"></path>
                                <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4"></path>
                             </svg>
                        </div>
                        <div class="col">
                            <h3 class="card-title mb-1">
                                <a href="{{ route('wallets.detail', $wallet->id) }}" class="text-reset">{{ $wallet->name }}</a>
                            </h3>
                            <p>
                                {{ $wallet->balance_format }}
                            </p>
                            <div class="mt-3">
                                <div class="row g-2 align-items-center">
                                    <div class="col-auto">
                                        25%
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm">
                                            <div class="progress-bar" style="width: 25%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                <span class="visually-hidden">25% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown">
                                <a href="#" class="card-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/dots-vertical -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <circle cx="12" cy="12" r="1" />
                                        <circle cx="12" cy="19" r="1" />
                                        <circle cx="12" cy="5" r="1" />
                                    </svg>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="#" class="dropdown-item">Import</a>
                                    <a href="#" class="dropdown-item">Export</a>
                                    <a href="#" class="dropdown-item">Download</a>
                                    <a href="#" class="dropdown-item">Another action</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>