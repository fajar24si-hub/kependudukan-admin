{{-- Komponen filter reusable --}}
<div class="card bg-dark border-0 mb-4">
    <div class="card-header bg-transparent border-bottom border-secondary">
        <h6 class="mb-0 text-white">
            <i class="fa fa-filter me-2"></i>Filter & Pencarian
        </h6>
    </div>
    <div class="card-body">
        <form action="{{ $action }}" method="GET" class="row g-3 align-items-end">
            {!! $slot !!}

            <div class="col-auto">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search me-1"></i> Terapkan
                </button>
                <a href="{{ $action }}" class="btn btn-outline-light">
                    <i class="fa fa-refresh me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>
