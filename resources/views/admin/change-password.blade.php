@extends('layouts.app')

@section('title', 'Change Password - Sachal Consulting Services')

@section('content')

<nav class="admin-navbar">
    <div class="brand">
        <img src="/Logo.png" alt="Sachal Consulting Services">
        <span class="brand-text">Admin Panel</span>
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
    <div class="card-box" style="max-width:480px;margin:0 auto;">
        <div class="card-box-header">
            <h5><i class="fas fa-key" style="color:var(--primary);margin-right:7px;"></i>Change Password</h5>
        </div>
        <div class="card-box-body">

            <div style="background:var(--primary-light);border:1px solid #c5d5f0;border-radius:9px;padding:0.8rem 1rem;margin-bottom:1.4rem;font-size:0.85rem;color:var(--primary);display:flex;align-items:center;gap:8px;">
                <i class="fas fa-user-circle" style="font-size:1rem;flex-shrink:0;"></i>
                <span>Changing password for <strong>{{ session('admin_email') }}</strong></span>
            </div>

            <form action="/admin/change-password" method="POST">
                @csrf

                <div style="margin-bottom:1.1rem;">
                    <label class="f-label">Current Password <span style="color:var(--danger-text);">*</span></label>
                    <div style="position:relative;">
                        <input
                            type="password"
                            name="current_password"
                            id="currentPwd"
                            class="f-control"
                            placeholder="Enter current password"
                            required
                            style="padding-right:2.5rem;"
                        >
                        <button type="button" onclick="togglePwd('currentPwd', 'eyeC')"
                            style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--muted);cursor:pointer;font-size:0.85rem;padding:0;">
                            <i class="fas fa-eye" id="eyeC"></i>
                        </button>
                    </div>
                </div>

                <div style="margin-bottom:1.1rem;">
                    <label class="f-label">New Password <span style="color:var(--danger-text);">*</span></label>
                    <div style="position:relative;">
                        <input
                            type="password"
                            name="new_password"
                            id="newPwd"
                            class="f-control"
                            placeholder="Minimum 6 characters"
                            required
                            minlength="6"
                            style="padding-right:2.5rem;"
                        >
                        <button type="button" onclick="togglePwd('newPwd', 'eyeN')"
                            style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--muted);cursor:pointer;font-size:0.85rem;padding:0;">
                            <i class="fas fa-eye" id="eyeN"></i>
                        </button>
                    </div>
                </div>

                <div style="margin-bottom:1.6rem;">
                    <label class="f-label">Confirm New Password <span style="color:var(--danger-text);">*</span></label>
                    <div style="position:relative;">
                        <input
                            type="password"
                            name="new_password_confirmation"
                            id="confPwd"
                            class="f-control"
                            placeholder="Repeat new password"
                            required
                            style="padding-right:2.5rem;"
                        >
                        <button type="button" onclick="togglePwd('confPwd', 'eyeCo')"
                            style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--muted);cursor:pointer;font-size:0.85rem;padding:0;">
                            <i class="fas fa-eye" id="eyeCo"></i>
                        </button>
                    </div>
                </div>

                <div style="display:flex;justify-content:flex-end;gap:0.8rem;">
                    <a href="/admin/dashboard"
                        style="background:var(--bg);border:1px solid var(--border);border-radius:8px;padding:0.5rem 1.2rem;font-size:0.88rem;font-weight:600;text-decoration:none;color:var(--text);">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary-c">
                        <i class="fas fa-save"></i> Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
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
