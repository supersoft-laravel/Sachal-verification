@extends('layouts.app')

@section('title', 'Edit Certificate - Sachal Consulting Services')

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
            <h5><i class="fas fa-pen" style="color:var(--primary);margin-right:7px;"></i>Edit Certificate</h5>
        </div>
        <div class="card-box-body">



            {{-- Locked Certificate ID --}}
            <div style="background:var(--bg);border:1.5px solid var(--border);border-radius:9px;padding:0.85rem 1.1rem;margin-bottom:1.5rem;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <div style="font-size:0.75rem;font-weight:600;color:var(--muted);text-transform:uppercase;margin-bottom:4px;">Certificate ID (locked)</div>
                    <span class="cert-chip" style="font-size:0.95rem;">{{ $certificate->certificate_id }}</span>
                </div>
                <i class="fas fa-lock" style="color:var(--muted);"></i>
            </div>

            <form action="/admin/certificates/{{ $certificate->id }}" method="POST">
                @csrf
                @method('PUT')

                <div style="margin-bottom:1.1rem;">
                    <label class="f-label">Candidate Name <span style="color:var(--danger-text);">*</span></label>
                    <input type="text" name="candidate_name" class="f-control"
                        value="{{ old('candidate_name', $certificate->candidate_name) }}" required>
                </div>

                <div style="margin-bottom:1.1rem;">
                    <label class="f-label">Training / Course Name <span style="color:var(--danger-text);">*</span></label>
                    <input type="text" name="training_name" class="f-control"
                        value="{{ old('training_name', $certificate->training_name) }}" required>
                </div>

                <div style="margin-bottom:1.1rem;">
                    <label class="f-label">Completion Date <span style="color:var(--danger-text);">*</span></label>
                    <input type="date" name="completion_date" class="f-control"
                        value="{{ old('completion_date', $certificate->completion_date) }}" required>
                </div>

                <div style="margin-bottom:1.6rem;">
                    <label class="f-label">Status <span style="color:var(--danger-text);">*</span></label>
                    <select name="status" class="f-control" required>
                        <option value="Valid"   {{ old('status', $certificate->status) === 'Valid'   ? 'selected' : '' }}>✔ Valid</option>
                        <option value="Invalid" {{ old('status', $certificate->status) === 'Invalid' ? 'selected' : '' }}>✖ Invalid</option>
                    </select>
                </div>

                <div style="display:flex;justify-content:flex-end;gap:0.8rem;">
                    <a href="/admin/dashboard"
                        style="background:var(--bg);border:1px solid var(--border);border-radius:8px;padding:0.5rem 1.2rem;font-size:0.88rem;font-weight:600;text-decoration:none;color:var(--text);">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary-c">
                        <i class="fas fa-save"></i> Update Certificate
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
