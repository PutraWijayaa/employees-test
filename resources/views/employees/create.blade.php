@extends('layouts.main')

@section('title', 'Create Employee')
@section('pagetitle', 'Tambah Karyawan Baru')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Form Tambah Employee</h5>

    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Nomor</label>
        <div class="col-sm-10">
          <input type="text" name="nomor" class="form-control" required value="{{ old('nomor') }}">
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
          <input type="text" name="nama" class="form-control" required value="{{ old('nama') }}">
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Jabatan</label>
        <div class="col-sm-10">
          <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}">
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
        <div class="col-sm-10">
          <input type="date" name="talahir" class="form-control" value="{{ old('talahir') }}">
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Photo</label>
        <div class="col-sm-10">
          <input type="file" name="photo" class="form-control">
        </div>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
