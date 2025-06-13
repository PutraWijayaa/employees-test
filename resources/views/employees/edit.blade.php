@extends('layouts.main')

@section('title', 'Edit Employee')
@section('pagetitle', 'Edit Employee - ' . $employee->nama)

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
            <li class="breadcrumb-item">
                <a href="{{ route('employees.show', $employee) }}" class="text-decoration-none">
                    {{ $employee->nama }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pencil me-2"></i>Edit Employee Information
                    </h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h6><i class="bi bi-exclamation-triangle me-2"></i>Please fix the following errors:</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('employees.update', $employee) }}" method="POST"
                        enctype="multipart/form-data" id="employeeForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-lg-8">
                                <!-- Basic Information -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="card-title mb-0">
                                            <i class="bi bi-person me-2"></i>Basic Information
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="nomor" class="form-label">Employee Number <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('nomor') is-invalid @enderror" id="nomor"
                                                    name="nomor" value="{{ old('nomor', $employee->nomor) }}"
                                                    placeholder="Enter employee number" required>
                                                @error('nomor')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="nama" class="form-label">Full Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('nama') is-invalid @enderror" id="nama"
                                                    name="nama" value="{{ old('nama', $employee->nama) }}"
                                                    placeholder="Enter full name" maxlength="150" required>
                                                @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">Maximum 150 characters</div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="jabatan" class="form-label">Position</label>
                                                <input type="text"
                                                    class="form-control @error('jabatan') is-invalid @enderror"
                                                    id="jabatan" name="jabatan"
                                                    value="{{ old('jabatan', $employee->jabatan) }}"
                                                    placeholder="Enter position/job title" maxlength="200">
                                                @error('jabatan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">Maximum 200 characters</div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="talahir" class="form-label">Date of Birth</label>
                                                <input type="date"
                                                    class="form-control @error('talahir') is-invalid @enderror"
                                                    id="talahir" name="talahir"
                                                    value="{{ old('talahir', $employee->talahir ? (is_string($employee->talahir) ? $employee->talahir : $employee->talahir->format('Y-m-d')) : '') }}"
                                                    max="{{ date('Y-m-d') }}">
                                                @error('talahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">Optional field</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-lg-4">
                                <!-- Photo Upload -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="card-title mb-0">
                                            <i class="bi bi-camera me-2"></i>Employee Photo
                                        </h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <!-- Current Photo Preview -->
                                        <div class="mb-3">
                                            @if($employee->photo_upload_path)
                                            <img src="{{ $employee->photo_upload_path }}" alt="Current photo"
                                                class="rounded-circle shadow current-photo"
                                                style="width: 120px; height: 120px; object-fit: cover;"
                                                id="currentPhoto">
                                            <p class="small text-muted mt-2">Current Photo</p>
                                            @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto current-photo"
                                                style="width: 120px; height: 120px;" id="currentPhoto">
                                                <i class="bi bi-person display-4 text-muted"></i>
                                            </div>
                                            <p class="small text-muted mt-2">No Photo</p>
                                            @endif
                                        </div>

                                        <!-- New Photo Preview (hidden by default) -->
                                        <div class="mb-3" id="newPhotoPreview" style="display: none;">
                                            <img src="" alt="New photo preview" class="rounded-circle shadow"
                                                style="width: 120px; height: 120px; object-fit: cover;" id="newPhoto">
                                            <p class="small text-success mt-2">New Photo Preview</p>
                                        </div>

                                        <!-- File Input -->
                                        <div class="mb-3">
                                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                                id="photo" name="photo" accept="image/*" onchange="previewPhoto(this)">
                                            @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="text-muted small">
                                            <i class="bi bi-info-circle me-1"></i>
                                            <div>Max file size: 2MB</div>
                                            <div>Allowed: JPG, PNG, GIF, WEBP</div>
                                        </div>

                                        @if($employee->photo_upload_path)
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="removeCurrentPhoto()">
                                                <i class="bi bi-trash me-1"></i>Remove Current Photo
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-warning" id="submitBtn">
                                                <i class="bi bi-check-circle me-2"></i>
                                                <span class="btn-text">Update Employee</span>
                                                <span class="spinner-border spinner-border-sm ms-2 d-none" role="status"
                                                    aria-hidden="true"></span>
                                            </button>

                                            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
                                                <i class="bi bi-arrow-left me-2"></i>Back to List
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.form-control,
.btn {
    border-radius: 10px;
}

.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.current-photo {
    transition: opacity 0.3s ease;
}

.current-photo.fade-out {
    opacity: 0.3;
}
</style>
@endpush

@push('scripts')
<script>
// Photo preview functionality
function previewPhoto(input) {
    const newPhotoPreview = document.getElementById('newPhotoPreview');
    const newPhoto = document.getElementById('newPhoto');
    const currentPhoto = document.getElementById('currentPhoto');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            newPhoto.src = e.target.result;
            newPhotoPreview.style.display = 'block';
            currentPhoto.classList.add('fade-out');
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        newPhotoPreview.style.display = 'none';
        currentPhoto.classList.remove('fade-out');
    }
}

function removeCurrentPhoto() {
    if (confirm('Are you sure you want to remove the current photo?')) {
        const currentPhoto = document.getElementById('currentPhoto');
        currentPhoto.style.display = 'none';

        const form = document.getElementById('employeeForm');
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'remove_photo';
        hiddenInput.value = '1';
        form.appendChild(hiddenInput);
    }
}

document.getElementById('employeeForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const spinner = submitBtn.querySelector('.spinner-border');

    btnText.textContent = 'Updating...';
    spinner.classList.remove('d-none');
    submitBtn.disabled = true;

    setTimeout(() => {
        submitBtn.disabled = false;
        btnText.textContent = 'Update Employee';
        spinner.classList.add('d-none');
    }, 3000);
});

setTimeout(function() {
    $('.alert').alert('close');
}, 5000);

document.getElementById('nama').addEventListener('input', function() {
    const maxLength = 150;
    const currentLength = this.value.length;
    const formText = this.parentNode.querySelector('.form-text');
    formText.textContent = `${currentLength}/${maxLength} characters`;

    if (currentLength > maxLength * 0.9) {
        formText.classList.add('text-warning');
    } else {
        formText.classList.remove('text-warning');
    }
});

document.getElementById('jabatan').addEventListener('input', function() {
    const maxLength = 200;
    const currentLength = this.value.length;
    const formText = this.parentNode.querySelector('.form-text');
    formText.textContent = `${currentLength}/${maxLength} characters`;

    if (currentLength > maxLength * 0.9) {
        formText.classList.add('text-warning');
    } else {
        formText.classList.remove('text-warning');
    }
});
</script>
@endpush
@endsection
