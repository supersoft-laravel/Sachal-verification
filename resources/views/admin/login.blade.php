@extends('layouts.app')

@section('title', 'Admin Login - Sachal Consulting Services')

@section('extra-css')
<style>
    body { background: #eef3fb; }

    .login-wrap {
        min-height: calc(100vh - 56px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .login-card {
        background: white;
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: 0 4px 30px rgba(26,92,184,0.1);
        padding: 2.5rem 2.2rem;
        width: 100%;
        max-width: 420px;
    }

    .login-card .logo-area {
        text-align: center;
        margin-bottom: 1.8rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border);
    }

    .login-card .logo-area img {
        max-width: 220px;
        height: auto;
        object-fit: contain;
    }

    .login-card h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 0.25rem;
    }

    .login-card .sub {
        font-size: 0.86rem;
        color: var(--muted);
        margin-bottom: 1.6rem;
    }

    .input-wrap {
        position: relative;
        margin-bottom: 1.1rem;
    }

    .input-wrap .icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        font-size: 0.85rem;
        pointer-events: none;
    }

    .input-wrap input {
        width: 100%;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        padding: 0.65rem 0.9rem 0.65rem 2.4rem;
        font-size: 0.93rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .input-wrap input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26,92,184,0.1);
    }

    .btn-login {
        width: 100%;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.7rem;
        font-size: 0.97rem;
        font-weight: 700;
        cursor: pointer;
        margin-top: 0.4rem;
        transition: background 0.2s, transform 0.15s;
        letter-spacing: 0.3px;
    }

    .btn-login:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .verify-link {
        text-align: center;
        margin-top: 1.4rem;
        font-size: 0.83rem;
        color: var(--muted);
    }

    .verify-link a { color: var(--primary); text-decoration: none; font-weight: 500; }
    .verify-link a:hover { text-decoration: underline; }
</style>
@endsection

@section('content')
<main>
<div class="login-wrap">
    <div class="login-card">
        <div class="logo-area">
            <img src="/Logo.png" alt="Sachal Consulting Services">
        </div>

        <h2>Admin Sign In</h2>
        <p class="sub">Enter your credentials to access the admin panel.</p>

        @if (session('error'))
            <div class="alert-err">
                <i class="fas fa-exclamation-circle" style="margin-top:2px;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="/admin/login" method="POST">
            @csrf
            <div style="margin-bottom:0.4rem;">
                <label class="f-label" for="email">Email Address</label>
            </div>
            <div class="input-wrap">
                <i class="fas fa-envelope icon"></i>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@sachal.com" required>
            </div>

            <div style="margin-bottom:0.4rem;margin-top:0.3rem;">
                <label class="f-label" for="password">Password</label>
            </div>
            <div class="input-wrap">
                <i class="fas fa-lock icon"></i>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt" style="margin-right:6px;"></i>Login
            </button>
        </form>

        <div class="verify-link">
            <a href="/verification"><i class="fas fa-shield-alt" style="margin-right:4px;"></i>Go to Certificate Verification</a>
        </div>
    </div>
</div>
</main>
@endsection
