@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card shadow-sm" style="border: 1px solid rgba(255,255,255,.08);">
                    <div class="card-header bg-dark text-white">
                        Login Customer
                    </div>

                    <div class="card-body" style="background: #0b1220;">
                        @if(session('error'))
                            <div class="alert alert-danger" role="alert" style="background: rgba(220,53,69,.15); border-color: rgba(220,53,69,.35); color: #fff;">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label text-white">Email</label>
                                <input id="email" name="email" type="email" class="form-control" required autofocus
                                       style="background: rgba(255,255,255,.06); color: #fff; border-color: rgba(255,255,255,.12);">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label text-white">Password</label>
                                <input id="password" name="password" type="password" class="form-control" required
                                       style="background: rgba(255,255,255,.06); color: #fff; border-color: rgba(255,255,255,.12);">
                            </div>

                            <button class="btn btn-warning w-100" type="submit" style="border-radius: 12px;">
                                Masuk sebagai Customer
                            </button>
                        </form>

                        <div class="mt-3 text-center">
                            <span class="text-white-50">Belum punya akun?</span>
                            <a href="{{ route('register') }}" class="text-warning ms-1">Daftar di sini</a>
                        </div>

                        <div class="mt-3 text-center">
                            <a href="{{ url('/login/admin') }}" class="text-white-50">Login Admin</a>
                            <span class="text-white-50 mx-2">|</span>
                            <a href="{{ url('/login/kasir') }}" class="text-white-50">Login Kasir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

