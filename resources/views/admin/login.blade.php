@extends('layouts.app')

@section('title', 'Login Admin - '.config('app.name'))

@push('styles')
<style>
    .admin-login {
        align-items: center;
        background:
            radial-gradient(circle at 80% 10%, rgba(242, 182, 109, .22), transparent 30%),
            linear-gradient(135deg, #2a0710 0%, #5b0f1a 58%, #7a1626 100%);
        display: flex;
        min-height: 620px;
        padding: 80px 0;
    }
    .admin-login__card {
        background: #fff;
        border: 1px solid #efd0d0;
        border-radius: 8px;
        box-shadow: 0 34px 80px rgba(42,7,16,.3);
        margin: 0 auto;
        max-width: 460px;
        padding: 32px;
    }
    .admin-login__card img {
        display: block;
        margin-bottom: 22px;
        max-width: 160px;
    }
    .admin-login__card h1 {
        color: #3a0710;
        font-size: 32px;
        margin-bottom: 10px;
    }
    .admin-login__card p {
        color: #67464b;
        line-height: 1.7;
        margin-bottom: 22px;
    }
</style>
@endpush

@section('content')
<section class="admin-login">
    <div class="container">
        <div class="admin-login__card">
            <img src="{{ asset('assets/img/cea/1.png') }}" alt="{{ config('app.name') }}">
            <h1>Login Admin</h1>
            <p>Masuk untuk mengelola konten menu, submenu, tulisan, dan gambar website.</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <div class="admin-field">
                    <label>Username</label>
                    <input name="username" value="{{ old('username') }}" autocomplete="username" required autofocus>
                </div>
                <div class="admin-field">
                    <label>Password</label>
                    <input name="password" type="password" autocomplete="current-password" required>
                </div>
                <div class="admin-form-actions">
                    <button class="admin-button" type="submit">Masuk Panel</button>
                    <a class="admin-button secondary" href="{{ route('home') }}">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
