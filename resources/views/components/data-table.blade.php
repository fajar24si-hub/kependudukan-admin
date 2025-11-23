{{-- Komponen table reusable --}}
<div class="table-responsive">
    <table class="table table-hover table-striped align-middle mb-0">
        <thead class="table-dark">
            <tr>
                {!! $header !!}
            </tr>
        </thead>
        <tbody>
            @if(isset($empty) && $empty)
                <tr>
                    <td colspan="100" class="text-center py-5">
                        <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">{{ $emptyMessage ?? 'Tidak ada data yang ditemukan' }}</p>
                        @if(isset($emptyAction) && $emptyAction)
                        <a href="{{ $emptyAction }}" class="btn btn-primary btn-sm mt-2">
                            <i class="fa fa-plus me-1"></i>Tambah Data Pertama
                        </a>
                        @endif
                    </td>
                </tr>
            @else
                {!! $body !!}
            @endif
        </tbody>
    </table>
</div>
