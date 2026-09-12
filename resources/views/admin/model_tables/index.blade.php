@extends('admin.layouts.app')

@section('title', 'Bảng so sánh model sản phẩm')

@section('content')
    <!-- Header Card -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-none position-relative overflow-hidden mb-4" style="background: linear-gradient(90deg, #00354f 0%, #005088 50%, #0070ba 100%) !important;">
                <div class="card-body px-4 py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h4 class="fw-semibold mb-1 text-white">Bảng so sánh model sản phẩm</h4>
                        <div class="text-white-50">Tạo ma trận thông số kỹ thuật, link chuyển hướng và giá real-time cho các model cùng dòng</div>
                    </div>
                    @can('products.create')
                        <a href="{{ route('admin.model-tables.create') }}" class="btn btn-primary d-flex align-items-center gap-1">
                            <i class="ti ti-plus fs-4"></i> Thêm bảng so sánh
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <!-- Hướng dẫn sử dụng nhanh -->
    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center gap-3 mb-4" role="alert">
        <i class="ti ti-info-circle fs-6 text-primary flex-shrink-0"></i>
        <div class="fs-3">
            <strong>Cách dùng:</strong> Sau khi tạo bảng, bạn có thể sao chép mã <code>[bang_so_sanh id="X"]</code> dán vào bất kỳ bài viết tin tức nào, hoặc chọn trực tiếp trong trang chỉnh sửa sản phẩm để tự động hiển thị dưới mô tả.
        </div>
    </div>

    <!-- Danh sách bảng -->
    <div class="card">
        <div class="card-body pb-0">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-10">
                    <input type="search" name="search" class="form-control" value="{{ request('search') }}" placeholder="Tìm theo tên bảng hoặc tiêu đề hiển thị...">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit"><i class="ti ti-search me-1"></i> Tìm kiếm</button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Tên quản trị</th>
                        <th>Tiêu đề ngoài web</th>
                        <th class="text-center">Số model</th>
                        <th>Mã nhúng (Shortcode)</th>
                        <th>Trạng thái</th>
                        <th class="text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tables as $table)
                        <tr>
                            <td class="ps-4 text-muted fw-semibold">#{{ $table->id }}</td>
                            <td>
                                <a href="{{ route('admin.model-tables.edit', $table) }}" class="fw-bold text-dark text-hover-primary">
                                    {{ $table->name }}
                                </a>
                                @if($table->subtitle)
                                    <div class="fs-2 text-muted text-truncate" style="max-width: 280px;">{{ $table->subtitle }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light-primary text-primary fw-semibold fs-2">
                                    {{ Str::limit($table->title, 45) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light-info text-info fw-bold">
                                    {{ $table->items_count }} models
                                </span>
                            </td>
                            <td>
                                <div class="d-inline-flex align-items-center gap-1 bg-light px-2 py-1 rounded border">
                                    <code class="text-primary fw-bold" id="shortcode-{{ $table->id }}">[bang_so_sanh id="{{ $table->id }}"]</code>
                                    <button type="button" class="btn btn-sm btn-ghost p-1 copy-btn" data-target="shortcode-{{ $table->id }}" title="Sao chép mã nhúng">
                                        <i class="ti ti-copy fs-4 text-muted"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                @if($table->is_active)
                                    <span class="badge bg-success-subtle text-success fw-semibold">Hoạt động</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-muted fw-semibold">Tạm ẩn</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="dropdown dropstart">
                                    <a href="#" class="text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical fs-5"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        @can('products.update')
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.model-tables.edit', $table) }}">
                                                    <i class="ti ti-pencil fs-4 text-primary"></i> Chỉnh sửa
                                                </a>
                                            </li>
                                        @endcan
                                        @can('products.create')
                                            <li>
                                                <form action="{{ route('admin.model-tables.duplicate', $table) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2">
                                                        <i class="ti ti-copy fs-4 text-info"></i> Nhân bản bảng
                                                    </button>
                                                </form>
                                            </li>
                                        @endcan
                                        @can('products.delete')
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.model-tables.destroy', $table) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bảng so sánh này không?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                                        <i class="ti ti-trash fs-4"></i> Xóa bảng
                                                    </button>
                                                </form>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="ti ti-table-off fs-9 text-muted d-block mb-2"></i>
                                <div class="fs-4 text-muted">Chưa có bảng so sánh model nào.</div>
                                @can('products.create')
                                    <a href="{{ route('admin.model-tables.create') }}" class="btn btn-primary btn-sm mt-3">
                                        <i class="ti ti-plus me-1"></i> Tạo bảng đầu tiên
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tables->hasPages())
            <div class="card-footer bg-transparent border-top">
                {{ $tables->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.copy-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const text = document.getElementById(targetId)?.textContent;
        if (!text) return;
        
        navigator.clipboard.writeText(text).then(() => {
            const icon = this.querySelector('i');
            if (icon) {
                icon.className = 'ti ti-check fs-4 text-success';
                setTimeout(() => {
                    icon.className = 'ti ti-copy fs-4 text-muted';
                }, 1500);
            }
        });
    });
});
</script>
@endpush
