@extends('layouts.main')

@section('title', 'Employee Details')
@section('pagetitle', 'Employee Details - ' . $employee->nama)

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('employees.index') }}" class="text-decoration-none">
                    <i class="bi bi-people me-1"></i>Employees
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $employee->nama }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Employee Photo & Basic Info -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if($employee->photo_upload_path)
                        <img src="{{ $employee->photo_upload_path }}" alt="Photo of {{ $employee->nama }}"
                            class="rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;"
                            onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUwIiBoZWlnaHQ9IjE1MCIgdmlld0JveD0iMCAwIDE1MCAxNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxNTAiIGhlaWdodD0iMTUwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik03NSAxMDBDNjEuMTkzIDEwMCA1MCA4OC44MDcgNTAgNzVDNTAgNjEuMTkzIDYxLjE5MyA1MCA3NSA1MEM4OC44MDcgNTAgMTAwIDYxLjE5MyAxMDAgNzVDMTAwIDg4LjgwNyA4OC44MDcgMTAwIDc1IDEwMFoiIGZpbGw9IiM5QzlDOTQiLz4KPC9zdmc+Cg==';">
                        @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto shadow"
                            style="width: 150px; height: 150px;">
                            <i class="bi bi-person display-1 text-muted"></i>
                        </div>
                        @endif
                    </div>

                    <h4 class="card-title mb-1">{{ $employee->nama }}</h4>
                    <p class="text-muted mb-3">{{ $employee->jabatan ?? 'No Position' }}</p>
                    <span class="badge bg-primary fs-6">ID: {{ $employee->nomor }}</span>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h6 class="card-title">Quick Actions</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-2"></i>Edit Employee
                        </a>
                        <form action="{{ route('employees.destroy', $employee) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete {{ $employee->nama }}? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-trash me-2"></i>Delete Employee
                            </button>
                        </form>
                        <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employee Details -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle me-2"></i>Employee Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-muted small">Employee Number</label>
                            <p class="fs-5 fw-bold text-primary">{{ $employee->nomor }}</p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-muted small">Full Name</label>
                            <p class="fs-5">{{ $employee->nama }}</p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-muted small">Position</label>
                            <p class="fs-5">
                                @if($employee->jabatan)
                                <span class="badge bg-info fs-6">{{ $employee->jabatan }}</span>
                                @else
                                <span class="text-muted">Not specified</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-muted small">Date of Birth</label>
                            <p class="fs-5">
                                @if($employee->talahir)
                                @php
                                if (is_string($employee->talahir)) {
                                $date = \Carbon\Carbon::parse($employee->talahir);
                                } else {
                                $date = $employee->talahir;
                                }
                                $age = $date->age;
                                @endphp
                                {{ $date->format('d F Y') }}
                                <small class="text-muted">({{ $age }} years old)</small>
                                @else
                                <span class="text-muted">Not specified</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-gear me-2"></i>System Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row small">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Created By</label>
                            <p class="mb-0">{{ $employee->created_by ?? 'System' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Updated By</label>
                            <p class="mb-0">{{ $employee->updated_by ?? 'Not updated' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Created At</label>
                            <p class="mb-0">
                                @if($employee->created_on)
                                @php
                                if (is_string($employee->created_on)) {
                                $created = \Carbon\Carbon::parse($employee->created_on);
                                } else {
                                $created = $employee->created_on;
                                }
                                @endphp
                                {{ $created->format('d M Y, H:i') }}
                                <small class="text-muted">({{ $created->diffForHumans() }})</small>
                                @else
                                <span class="text-muted">Unknown</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Last Updated</label>
                            <p class="mb-0">
                                @if($employee->updated_on)
                                @php
                                if (is_string($employee->updated_on)) {
                                $updated = \Carbon\Carbon::parse($employee->updated_on);
                                } else {
                                $updated = $employee->updated_on;
                                }
                                @endphp
                                {{ $updated->format('d M Y, H:i') }}
                                <small class="text-muted">({{ $updated->diffForHumans() }})</small>
                                @else
                                <span class="text-muted">Never updated</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
