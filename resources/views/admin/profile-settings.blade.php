@extends('layouts.app')

@section('title', 'Profile Settings - Sachal Consulting Services')

@section('extra-css')
<style>
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        align-items: start;
    }

    @media (max-width: 768px) {
        .profile-grid { grid-template-columns: 1fr; }
    }

    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--primary-light);
        color: var(--primary);
        border: 1px solid #c5d5f0;
        border-radius: 20px;
        padding: 0.3rem 0.9rem;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: capitalize;
        letter-spacing: 0.3px;
    }

    .avatar-lg {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        font-weight: 800;
        flex-shrink: 0;
        text-transform: uppercase;
        box-shadow: 0 4px 14px rgba(26,92,184,0.25);
    }

    .field-hint {
        font-size: 0.75rem;
        color: var(--muted);
        margin-top: 4px;
    }

    .divider {
        border: none;
        border-top: 1px solid var(--border);
        margin: 1.3rem 0;
    }

    .pwd-wrap { position: relative; }
    .pwd-wrap .f-control { padding-right: 2.6rem; }

    .pwd-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--muted);
        cursor: pointer;
        font-size: 0.85rem;
        padding: 0;
        transition: color 0.15s;
    }

    .pwd-toggle:hover { color: var(--primary); }

    .field-error {
        font-size: 0.78rem;
        color: var(--danger-text);
        margin-top: 4px;
    }
</style>
@endsection

@section('content')

<nav class="admin-navbar">
    <div class="brand">
        <img src="/Logo.png" alt="Sachal Consulting Services">
        <span class="brand-text">
            {{ session('admin_role') === 'coordinator' ? 'Coordinator Panel' : 'Admin Panel' }}
        </span>
    </div>
    <div class="nav-actions">
        <a href="/admin/dashboard" class="nav-link-item">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        <a href="/admin/logout" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</nav>

<main>
<div class="main-content">

    {{-- PAGE HEADING --}}
    <div style="margin-bottom:1.4rem;">
        <h4 style="font-size:1.05rem;font-weight:800;color:var(--text);margin:0 0 0.2rem;">
            <i class="fas fa-user-cog" style="color:var(--primary);margin-right:8px;"></i>Profile Settings
        </h4>
        <p style="font-size:0.83rem;color:var(--muted);margin:0;">
            Update your name, email address, and account password.
        </p>
    </div>

    <div class="profile-grid">

        {{-- ── CARD 1: PROFILE INFORMATION ── --}}
        <div class="card-box">
            <div class="card-box-header">
                <h5><i class="fas fa-id-card" style="color:var(--accent);margin-right:7px;"></i>Profile Information</h5>
            </div>
            <div class="card-box-body">

                {{-- Avatar + current identity --}}
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.4rem;padding-bottom:1.2rem;border-bottom:1px solid var(--border);">
                    <div class="avatar-lg">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <div>
                        <div style="font-size:1rem;font-weight:800;color:var(--text);margin-bottom:3px;">
                            {{ $user->name }}
                        </div>
                        <div style="font-size:0.82rem;color:var(--muted);margin-bottom:6px;">
                            {{ $user->email }}
                        </div>
                        <span class="role-badge">
                            <i class="fas fa-{{ $user->role === 'admin' ? 'shield-alt' : 'user' }}"></i>
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>

                <form action="/admin/profile" method="POST">
                    @csrf

                    {{-- Name --}}
                    <div style="margin-bottom:1.1rem;">
                        <label class="f-label" for="name">
                            Display Name <span style="color:var(--danger-text);">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="f-control"
                            value="{{ old('name', $user->name) }}"
                            placeholder="Your full name"
                            required
                            maxlength="255"
                        >
                        @error('name')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email (editable) --}}
                    <div style="margin-bottom:1.1rem;">
                        <label class="f-label" for="email">
                            Email Address <span style="color:var(--danger-text);">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="f-control"
                            value="{{ old('email', $user->email) }}"
                            placeholder="your@email.com"
                            required
                            maxlength="255"
                        >
                        @error('email')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                        <div class="field-hint">
                            <i class="fas fa-info-circle" style="font-size:0.7rem;"></i>
                            Changing your email will update your login credentials.
                        </div>
                    </div>

                    {{-- Role (read-only display) --}}
                    <div style="margin-bottom:1.4rem;">
                        <label class="f-label">Role</label>
                        <div style="padding:0.45rem 0;">
                            <span class="role-badge">
                                <i class="fas fa-{{ $user->role === 'admin' ? 'shield-alt' : 'user' }}"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>

                    <div style="display:flex;justify-content:flex-end;">
                        <button type="submit" class="btn-accent">
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                    </div>
                </form>

            </div>
        </div>

        {{-- ── CARD 2: CHANGE PASSWORD ── --}}
        <div class="card-box">
            <div class="card-box-header">
                <h5><i class="fas fa-lock" style="color:var(--primary);margin-right:7px;"></i>Change Password</h5>
            </div>
            <div class="card-box-body">

                <p style="font-size:0.84rem;color:var(--muted);margin-bottom:1.3rem;line-height:1.55;">
                    Choose a strong password of at least 6 characters. You will use it on your next login.
                </p>

                <form action="/admin/profile/password" method="POST">
                    @csrf

                    <div style="margin-bottom:1.1rem;">
                        <label class="f-label" for="current_password">
                            Current Password <span style="color:var(--danger-text);">*</span>
                        </label>
                        <div class="pwd-wrap">
                            <input
                                type="password"
                                id="current_password"
                                name="current_password"
                                class="f-control"
                                placeholder="Enter current password"
                                required
                            >
                            <button type="button" class="pwd-toggle" onclick="togglePwd('current_password','eye1')">
                                <i class="fas fa-eye" id="eye1"></i>
                            </button>
                        </div>
                    </div>

                    <hr class="divider">

                    <div style="margin-bottom:1.1rem;">
                        <label class="f-label" for="new_password">
                            New Password <span style="color:var(--danger-text);">*</span>
                        </label>
                        <div class="pwd-wrap">
                            <input
                                type="password"
                                id="new_password"
                                name="new_password"
                                class="f-control"
                                placeholder="Minimum 6 characters"
                                required
                                minlength="6"
                            >
                            <button type="button" class="pwd-toggle" onclick="togglePwd('new_password','eye2')">
                                <i class="fas fa-eye" id="eye2"></i>
                            </button>
                        </div>
                    </div>

                    <div style="margin-bottom:1.6rem;">
                        <label class="f-label" for="new_password_confirmation">
                            Confirm New Password <span style="color:var(--danger-text);">*</span>
                        </label>
                        <div class="pwd-wrap">
                            <input
                                type="password"
                                id="new_password_confirmation"
                                name="new_password_confirmation"
                                class="f-control"
                                placeholder="Repeat new password"
                                required
                            >
                            <button type="button" class="pwd-toggle" onclick="togglePwd('new_password_confirmation','eye3')">
                                <i class="fas fa-eye" id="eye3"></i>
                            </button>
                        </div>
                    </div>

                    <div style="display:flex;justify-content:flex-end;">
                        <button type="submit" class="btn-primary-c">
                            <i class="fas fa-key"></i> Update Password
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>{{-- /.profile-grid --}}

</div>
</main>

@endsection

@section('extra-js')
<script>
    function togglePwd(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                showToast(@json($error), 'err');
            @endforeach
        @endif
    });
</script>
@endsection
