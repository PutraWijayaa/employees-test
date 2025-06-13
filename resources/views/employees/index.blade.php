@extends('layouts.main')

@section('title', 'Employees List')
@section('pagetitle', 'Employee Management')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title">Employees</h5>
            <a href="{{ route('employees.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Employee
            </a>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Tanggal Lahir</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($emps as $index => $emp)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $emp->nomor }}</strong></td>
                        <td>{{ $emp->nama }}</td>
                        <td>{{ $emp->jabatan ?? '-' }}</td>
                        <td>
                            @if($emp->talahir)
                            @php
                            // Handle both string and Carbon date objects
                            if (is_string($emp->talahir)) {
                            $date = \Carbon\Carbon::parse($emp->talahir);
                            } else {
                            $date = $emp->talahir;
                            }
                            @endphp
                            {{ $date->format('d M Y') }}
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($emp->photo_upload_path)
                            <img src="{{ $emp->photo_upload_path }}" alt="Photo of {{ $emp->nama }}"
                                class="rounded-circle shadow-sm" style="width: 48px; height: 48px; object-fit: cover;"
                                onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDgiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA0OCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQ4IiBoZWlnaHQ9IjQ4IiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yNCAzMkMxOS41ODE3IDMyIDE2IDI4LjQxODMgMTYgMjRDMTYgMTkuNTgxNyAxOS41ODE3IDE2IDI0IDE2QzI4LjQxODMgMTYgMzIgMTkuNTgxNyAzMiAyNEMzMiAyOC40MTgzIDI4LjQxODMgMzIgMjQgMzJaIiBmaWxsPSIjOUM5Qzk0Ii8+Cjwvc3ZnPgo=';">
                            @else
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px;">
                                <i class="bi bi-person text-muted"></i>
                            </div>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Employee actions">
                                <a href="{{ route('employees.show', $emp) }}" class="btn btn-sm btn-outline-info"
                                    title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('employees.edit', $emp) }}" class="btn btn-sm btn-outline-warning"
                                    title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <a href="{{ route('employees.destroy', $emp) }}"
                                                    class="btn btn-danger" data-confirm-delete="true"><i
                                                        class="bi bi-trash"></i></a>

                                <!-- <form action="{{ route('employees.destroy', $emp) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete {{ $emp->nama }}? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Delete" type="submit">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form> -->
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="text-muted">
                                <i class="bi bi-inbox display-4"></i>
                                <p class="mt-2 mb-0">No employees found.</p>
                                <small>Start by adding your first employee.</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($emps->count() > 0)
        <div class="mt-3">
            <small class="text-muted">
                Total: {{ $emps->count() }} employee{{ $emps->count() !== 1 ? 's' : '' }}
            </small>
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
setTimeout(function() {
    $('.alert').alert('close');
}, 5000);
</script>
@endpush
@endsection
