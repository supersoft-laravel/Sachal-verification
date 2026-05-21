@extends('layouts.app')

@section('title', 'Dashboard - Sachal Consulting Services')

@section('content')

<nav class="admin-navbar">
    <div class="brand">
        <img src="/Logo.png" alt="Sachal Consulting Services">
        <span class="brand-text">Admin Panel</span>
    </div>
    <div class="nav-actions">
        <a href="/verification" target="_blank" class="nav-link-item">
            <i class="fas fa-external-link-alt"></i> Verification Page
        </a>
        <a href="/admin/logout" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</nav>

<main>
<div class="main-content">



    {{-- STAT CARDS --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:1.6rem;">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-certificate"></i></div>
            <div>
                <div class="stat-label">Total Certificates</div>
                <div class="stat-value">{{ $certificates->count() }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="stat-label">Valid Certificates</div>
                <div class="stat-value">{{ $certificates->where('status','Valid')->count() }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red"><i class="fas fa-times-circle"></i></div>
            <div>
                <div class="stat-label">Invalid Certificates</div>
                <div class="stat-value">{{ $certificates->where('status','Invalid')->count() }}</div>
            </div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="card-box">
        <div class="card-box-header">
            <h5><i class="fas fa-list" style="color:var(--primary);margin-right:7px;"></i>All Certificates</h5>
            <a href="/admin/certificates/create" class="btn-accent">
                <i class="fas fa-plus"></i> New Certificate
            </a>
        </div>

        @if ($certificates->isEmpty())
            <div style="text-align:center;padding:3rem 1rem;color:var(--muted);">
                <i class="fas fa-folder-open" style="font-size:2.5rem;opacity:0.35;display:block;margin-bottom:0.8rem;"></i>
                No certificates yet.
                <a href="/admin/certificates/create" style="color:var(--primary);">Create one now.</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table tbl mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Certificate ID</th>
                            <th>Candidate Name</th>
                            <th>Training / Course</th>
                            <th>Completion Date</th>
                            <th>Status</th>
                            <th style="text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($certificates as $i => $cert)
                        <tr>
                            <td style="color:var(--muted);font-weight:600;font-size:0.85rem;">{{ $i + 1 }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:6px;">
                                    <span class="cert-chip">{{ $cert->certificate_id }}</span>
                                    <button
                                        class="btn-copy"
                                        onclick="copyId(this, '{{ $cert->certificate_id }}')"
                                        title="Copy ID"
                                    >
                                        <i class="fas fa-copy"></i>
                                        <span class="copy-tooltip">Copied!</span>
                                    </button>
                                </div>
                            </td>
                            <td style="font-weight:600;">{{ $cert->candidate_name }}</td>
                            <td style="color:var(--muted);">{{ $cert->training_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($cert->completion_date)->format('d M Y') }}</td>
                            <td>
                                @if ($cert->status === 'Valid')
                                    <span class="badge-valid"><i class="fas fa-check"></i> Valid</span>
                                @else
                                    <span class="badge-invalid"><i class="fas fa-times"></i> Invalid</span>
                                @endif
                            </td>
                            <td style="text-align:center;white-space:nowrap;">
                                <a href="/admin/certificates/{{ $cert->id }}/edit" class="btn-edit me-1">
                                    <i class="fas fa-pen"></i> Edit
                                </a>
                                <button
                                    class="btn-del"
                                    onclick="confirmDelete({{ $cert->id }}, '{{ addslashes($cert->candidate_name) }}')"
                                >
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                                <form id="del-{{ $cert->id }}" action="/admin/certificates/{{ $cert->id }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
</main>

{{-- DELETE MODAL --}}
<div class="modal fade" id="delModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content" style="border-radius:14px;border:1px solid var(--border);box-shadow:0 12px 40px rgba(0,0,0,0.12);">
            <div class="modal-header" style="border-bottom:1px solid var(--border);padding:1.1rem 1.4rem;">
                <h6 class="modal-title" style="font-weight:700;color:var(--text);">
                    <i class="fas fa-trash" style="color:var(--danger-text);margin-right:7px;"></i>Delete Certificate
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:1.4rem;text-align:center;">
                <p style="color:var(--text);font-size:0.95rem;margin-bottom:0.4rem;">
                    Are you sure you want to delete the certificate for
                </p>
                <p id="delName" style="font-weight:700;color:var(--primary);font-size:1rem;margin-bottom:0.8rem;"></p>
                <p style="color:var(--danger-text);font-size:0.82rem;font-weight:600;">
                    <i class="fas fa-exclamation-triangle"></i> This cannot be undone.
                </p>
            </div>
            <div class="modal-footer" style="border-top:1px solid var(--border);padding:0.9rem 1.4rem;justify-content:flex-end;gap:0.7rem;">
                <button type="button" class="btn" data-bs-dismiss="modal"
                    style="background:var(--bg);border:1px solid var(--border);border-radius:7px;font-size:0.88rem;font-weight:600;padding:0.45rem 1.1rem;">
                    Cancel
                </button>
                <button type="button" id="delConfirmBtn"
                    style="background:var(--danger-text);color:white;border:none;border-radius:7px;font-size:0.88rem;font-weight:600;padding:0.45rem 1.1rem;cursor:pointer;">
                    <i class="fas fa-trash me-1"></i>Delete
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra-js')
<script>
    // Copy certificate ID
    function copyId(btn, id) {
        navigator.clipboard.writeText(id).then(() => {
            const tip = btn.querySelector('.copy-tooltip');
            tip.classList.add('show');
            setTimeout(() => tip.classList.remove('show'), 1800);
        });
    }

    // Delete confirmation
    let delTarget = null;
    function confirmDelete(id, name) {
        delTarget = id;
        document.getElementById('delName').textContent = name;
        new bootstrap.Modal(document.getElementById('delModal')).show();
    }

    document.getElementById('delConfirmBtn').addEventListener('click', () => {
        if (delTarget) document.getElementById('del-' + delTarget).submit();
    });
</script>
@endsection
