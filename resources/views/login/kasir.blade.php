@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    Login Kasir
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.kasir.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="email" class="form-control" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" name="password" type="password" class="form-control" required>
                        </div>

                        <button class="btn btn-warning w-100" type="submit">
                            Masuk sebagai Kasir
                        </button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ url('/login/admin') }}">Login Admin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

