@extends('layouts.app')

@section('title', 'Certificate Verification - Sachal Consulting Services')

@section('extra-css')
<style>
    body { background: #eef3fb; }

    .verify-wrap {
        min-height: calc(100vh - 56px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .verify-card {
        background: white;
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: 0 4px 30px rgba(26,92,184,0.1);
        padding: 2.5rem 2.2rem;
        width: 100%;
        max-width: 460px;
        text-align: center;
    }

    .verify-card .logo-area {
        margin-bottom: 1.6rem;
        padding-bottom: 1.4rem;
        border-bottom: 1px solid var(--border);
    }

    .verify-card .logo-area img {
        max-width: 230px;
        height: auto;
        object-fit: contain;
    }

    .verify-card h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 0.25rem;
    }

    .verify-card .sub {
        font-size: 0.86rem;
        color: var(--muted);
        margin-bottom: 1.6rem;
    }

    .verify-card input {
        width: 100%;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        padding: 0.68rem 1rem;
        font-size: 0.95rem;
        text-align: center;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 1rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .verify-card input::placeholder {
        text-transform: none;
        letter-spacing: 0;
        color: #aab2c8;
    }

    .verify-card input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26,92,184,0.1);
    }

    .btn-verify {
        width: 100%;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.7rem;
        font-size: 0.97rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        letter-spacing: 0.3px;
    }

    .btn-verify:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .hint {
        margin-top: 1.2rem;
        font-size: 0.8rem;
        color: var(--muted);
    }
</style>
@endsection

@section('content')
<main>
<div class="verify-wrap">
    <div class="verify-card">
        <div class="logo-area">
            <img src="/Logo.png" alt="Sachal Consulting Services">
        </div>

        <h2><i class="fas fa-shield-alt" style="color:var(--accent);margin-right:7px;"></i>Certificate Verification</h2>
        <p class="sub">Enter a Certificate ID to verify its authenticity.</p>


        <form action="/verification" method="POST">
            @csrf
            <input
                type="text"
                name="certificate_id"
                placeholder="e.g. SACHAL-1234ABCD"
                value="{{ old('certificate_id') }}"
                required
            >
            <button type="submit" class="btn-verify">
                <i class="fas fa-search" style="margin-right:6px;"></i>Verify Certificate
            </button>
        </form>

        <p class="hint">
            <i class="fas fa-info-circle" style="color:var(--accent);"></i>
            The Certificate ID is printed on your issued certificate document.
        </p>
    </div>
</div>
</main>
@endsection
@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->any())
            showToast(@json($errors->first()), 'err');
        @endif
    });
</script>
@endsection
