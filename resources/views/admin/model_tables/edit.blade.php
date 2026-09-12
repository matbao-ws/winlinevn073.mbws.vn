@extends('admin.layouts.app')

@section('title', 'Chỉnh Sửa Bảng So Sánh Model: ' . $table->name)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-none position-relative overflow-hidden mb-4" style="background: linear-gradient(90deg, #00354f 0%, #005088 50%, #0070ba 100%) !important;">
                <div class="card-body px-4 py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h4 class="fw-semibold mb-1 text-white">Chỉnh Sửa Bảng So Sánh Model</h4>
                        <div class="text-white-50">Mã nhúng: <code class="text-warning">[bang_so_sanh id="{{ $table->id }}"]</code></div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('admin.model-tables.index') }}" class="btn btn-outline-light">
                            <i class="ti ti-arrow-left me-1"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.model-tables.update', $table) }}" method="POST" id="model-table-form">
        @csrf
        @method('PUT')
        @include('admin.model_tables._form')
    </form>
@endsection
