@extends('layouts.app')

@section('title', 'Login Admin - '.config('app.name'))

@push('styles')
<style>
    .admin-login {
        align-items: center;
        background:
            radial-gradient(circle at 80% 10%, rgba(242, 201, 76, .24), transparent 30%),
            linear-gradient(135deg, #063d2a 0%, #0f5d3e 58%, #1f7a43 100%);
        display: flex;
        min-height: 620px;
        padding: 80px 0;
    }
    .admin-login__card {
        background: #fff;
        border: 1px solid #dfe9c9;
        border-radius: 8px;
        box-shadow: 0 34px 80px rgba(6,61,42,.28);
        margin: 0 auto;
        max-width: 460px;
        padding: 32px;
    }
    .admin-login__brand {
        display: block;
        margin-bottom: 22px;
        max-width: 160px;
    }
    .admin-login__card h1 {
        color: #063d2a;
        font-size: 32px;
        margin-bottom: 10px;
    }
    .admin-login__card p {
        color: #4f6759;
        line-height: 1.7;
        margin-bottom: 22px;
    }
</style>
@endpush

@section('content')
<section class="admin-login">
    <div class="container">
        <div class="admin-login__card">
            <div class="admin-login__brand">
                @include('layouts.kso-wordmark', ['variant' => 'login', 'compact' => true])
            </div>
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
