@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 720px;">
    <div class="mb-3">
        <h1 class="fw-bold" style="letter-spacing:.2px;">Tambah User (Admin)</h1>
        <p class="text-muted mb-0">Admin dapat menambahkan user baru untuk role admin/kasir.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 18px; overflow:hidden;">
        <div class="card-body" style="background: #0b1220; color:#fff;">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label text-white-50">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label text-white-50">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label text-white-50">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="kasir" {{ old('role') === 'kasir' ? 'selected' : '' }}>kasir</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>admin</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-white-50">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="form-text" style="color: rgba(255,255,255,.65);">Password akan di-hash otomatis.</div>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label text-white-50">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-warning rounded-3 fw-semibold">Simpan</button>
                    <a href="{{ route('admin.home') }}" class="btn btn-outline-light rounded-3 fw-semibold">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

