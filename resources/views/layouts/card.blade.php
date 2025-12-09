{{-- resources/views/components/card.blade.php --}}
<div class="card shadow-sm border-0 mb-4 fade-in">
    <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h5 class="mb-1 fw-bold text-dark">{{ $title }}</h5>
                @if(isset($subtitle))
                <p class="text-muted mb-0 small">{{ $subtitle }}</p>
                @endif
            </div>
            <div class="d-flex gap-2">
                @if(isset($export) && $export)
                <button class="btn btn-outline-primary btn-sm d-flex align-items-center">
                    <i class="fas fa-download me-1"></i> Export
                </button>
                @endif
                @if(isset($create) && $create)
                <a href="{{ $createUrl }}" class="btn btn-primary btn-sm d-flex align-items-center">
                    <i class="fas fa-plus me-1"></i> Tambah Data
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body px-4 pt-0">
        {{ $slot }}
    </div>
    @if(isset($footer))
    <div class="card-footer bg-white border-0 pt-0 px-4 pb-4">
       