@extends('layouts.app')

@section('title', 'Create Certificate - Sachal Consulting Services')

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
    <div class="card-box" style="max-width:640px;margin:0 auto;">
        <div class="card-box-header">
            <h5><i class="fas fa-plus-circle" style="color:var(--accent);margin-right:7px;"></i>New Certificate</h5>
        </div>
        <div class="card-box-body">



            {{-- Auto-ID notice --}}
            <div style="background:var(--primary-light);border:1px solid #c5d5f0;border-radius:9px;padding:0.85rem 1.1rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:10px;font-size:0.86rem;color:var(--primary);">
                <i class="fas fa-magic" style="font-size:1rem;flex-shrink:0;"></i>
                <div>
                    <strong>Certificate ID is auto-generated.</strong>
                    A unique ID like <code style="background:white;padding:0.1rem 0.4rem;border-radius:4px;font-size:0.82rem;">SACHAL-1234ABCD</code> will be assigned on save.
                </div>
            </div>

            <form action="/admin/certificates" method="POST">
                @csrf

                <div style="margin-bottom:1.1rem;">
                    <label class="f-label">Candidate Name <span style="color:var(--danger-text);">*</span></label>
                    <input type="text" name="candidate_name" class="f-control"
                        value="{{ old('candidate_name') }}" placeholder="e.g. Ahmed Ali" required>
                </div>

                <div style="margin-bottom:1.1rem;">
                    <label class="f-label">Training / Course Name <span style="color:var(--danger-text);">*</span></label>
                    <input type="text" name="training_name" class="f-control"
                        value="{{ old('training_name') }}" placeholder="e.g. Fire Safety Training" required>
                </div>

                <div style="margin-bottom:1.1rem;">
                    <label class="f-label">Completion Date <span style="color:var(--danger-text);">*</span></label>
                    <input type="date" name="completion_date" class="f-control"
                        value="{{ old('completion_date') }}" required>
                </div>

                <div style="margin-bottom:1.6rem;">
                    <label class="f-label">Status <span style="color:var(--danger-text);">*</span></label>
                    <select name="status" class="f-control" required>
                        <option value="">-- Select --</option>
                        <option value="Valid"   {{ old('status') === 'Valid'   ? 'selected' : '' }}>✔ Valid</option>
                        <option value="Invalid" {{ old('status') === 'Invalid' ? 'selected' : '' }}>✖ Invalid</option>
                    </select>
                </div>

                <div style="display:flex;justify-content:flex-end;gap:0.8rem;">
                    <a href="/admin/dashboard"
                        style="background:var(--bg);border:1px solid var(--border);border-radius:8px;padding:0.5rem 1.2rem;font-size:0.88rem;font-weight:600;text-decoration:none;color:var(--text);">
                        Cancel
                    </a>
                    <button type="submit" class="btn-accent">
                        <i class="fas fa-save"></i> Save Certificate
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
    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                showToast(@json($error), 'err');
            @endforeach
        @endif
    });
</script>
@endsection

