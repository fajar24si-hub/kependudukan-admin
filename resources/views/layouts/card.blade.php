{{-- Template card untuk konsistensi --}}
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h5 class="mb-1 text-white">{{ $title }}</h5>
                <p class="text-muted mb-0 small">{{ $subtitle ?? 'Kelola data dengan mudah' }}</p>
            </div>
            <div class="d-flex gap-2">
                @if(isset($export) && $export)
                <button class="btn btn-outline-info btn-sm">
                    <i class="fa fa-download me-1"></i>Export
                </button>
                @endif
                @if(isset($create) && $create)
                <a href="{{ $createUrl }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus me-1"></i>Tambah Data
                </a>
                @endif
            </div>
        </div>
        {{ $slot }}
    </div>
</div>
