@extends('layouts.app')

@section('title', 'Dashboard - Sachal Consulting Services')

@section('extra-css')
<style>
    /* ── COMPACT TABLE ── */
    .tbl-compact thead th {
        background: var(--primary-light);
        color: var(--primary);
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding: 0.6rem 0.65rem;
        border: none;
        white-space: nowrap;
    }

    .tbl-compact tbody td {
        padding: 0.55rem 0.65rem;
        font-size: 0.83rem;
        vertical-align: middle;
        border-color: var(--border);
        white-space: nowrap;
    }

    .tbl-compact tbody tr:hover { background: #fafbff; }

    /* ── ICON-ONLY ACTION BUTTONS ── */
    .btn-icon-edit {
        background: var(--primary-light);
        color: var(--primary);
        border: 1px solid #c5d5f0;
        width: 30px;
        height: 30px;
        border-radius: 6px;
        font-size: 0.78rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.18s;
    }

    .btn-icon-edit:hover { background: var(--primary); color: white; }

    .btn-icon-del {
        background: var(--danger-bg);
        color: var(--danger-text);
        border: 1px solid #f5c6c6;
        width: 30px;
        height: 30px;
        border-radius: 6px;
        font-size: 0.78rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.18s;
    }

    .btn-icon-del:hover { background: var(--danger-text); color: white; }

    /* ── PAGINATION ── */
    .pg-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 30px;
        height: 30px;
        padding: 0 0.45rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        color: var(--text);
        background: var(--bg);
        border: 1px solid var(--border);
        transition: all 0.15s;
    }

    .pg-btn:hover:not(.disabled):not(.active) {
        background: var(--primary-light);
        color: var(--primary);
        border-color: #c5d5f0;
    }

    .pg-btn.active { background: var(--primary); color: white; border-color: var(--primary); }
    .pg-btn.disabled { opacity: 0.4; cursor: default; pointer-events: none; }

    /* ── COURSE TYPE PILLS ── */
    .pill-physical {
        background: #e8f0fb;
        color: #1a5cb8;
        padding: 0.15rem 0.55rem;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .pill-online {
        background: #fff4ec;
        color: #f47920;
        padding: 0.15rem 0.55rem;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
    }

    /* ── SEARCH BAR ── */
    .search-input {
        border: 1.5px solid var(--border);
        border-radius: 8px;
        padding: 0.42rem 0.9rem 0.42rem 2rem;
        font-size: 0.85rem;
        color: var(--text);
        width: 200px;
        transition: border-color 0.2s, width 0.3s;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        width: 230px;
        box-shadow: 0 0 0 3px rgba(26,92,184,0.08);
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 640px) {
        .search-input { width: 150px; }
        .search-input:focus { width: 160px; }
        .card-box-header { flex-direction: column; align-items: flex-start !important; }
    }
</style>
@endsection

@section('content')

<nav class="admin-navbar">
    <div class="brand">
        <img src="/Logo.png" alt="Sachal Consulting Services">
        <span class="brand-text">Admin Panel</span>
    </div>
    <div class="nav-actions">
        <span style="font-size:0.82rem;color:var(--muted);display:flex;align-items:center;gap:5px;">
            <i class="fas fa-user-circle"></i>
            {{ session('admin_name') }}
            <span style="background:var(--primary-light);color:var(--primary);font-size:0.72rem;font-weight:700;padding:0.1rem 0.45rem;border-radius:20px;text-transform:uppercase;">
                {{ session('admin_role') }}
            </span>
        </span>
        <a href="/verification" target="_blank" class="nav-link-item">
            <i class="fas fa-external-link-alt"></i> Verification Page
        </a>
        <a href="/admin/change-password" class="nav-link-item">
            <i class="fas fa-key"></i> Change Password
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
                <div class="stat-value">{{ $totalCount }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="stat-label">Valid Certificates</div>
                <div class="stat-value">{{ $validCount }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red"><i class="fas fa-times-circle"></i></div>
            <div>
                <div class="stat-label">Invalid Certificates</div>
                <div class="stat-value">{{ $invalidCount }}</div>
            </div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="card-box">
        <div class="card-box-header" style="flex-wrap:wrap;gap:0.7rem;">
            <h5 style="margin:0;flex-shrink:0;">
                <i class="fas fa-list" style="color:var(--primary);margin-right:7px;"></i>All Certificates
            </h5>

            {{-- Search + New Certificate (search on left, button on right) --}}
            <div style="display:flex;align-items:center;gap:0.6rem;flex-wrap:wrap;margin-left:auto;">
                <form method="GET" action="/admin/dashboard" style="display:flex;align-items:center;gap:0.4rem;">
                    <div style="position:relative;">
                        <i class="fas fa-search" style="position:absolute;left:9px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:0.78rem;pointer-events:none;"></i>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Name or Certificate ID…"
                            class="search-input"
                        >
                    </div>
                    <button type="submit" class="btn-primary-c" style="padding:0.42rem 0.85rem;" title="Search">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request('search'))
                        <a href="/admin/dashboard" class="btn-primary-c" title="Clear search"
                            style="padding:0.42rem 0.85rem;background:var(--bg);color:var(--muted);border:1px solid var(--border);">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </form>

                <a href="/admin/certificates/create" class="btn-accent">
                    <i class="fas fa-plus"></i> New Certificate
                </a>
            </div>
        </div>

        @if ($certificates->isEmpty())
            <div style="text-align:center;padding:3rem 1rem;color:var(--muted);">
                <i class="fas fa-folder-open" style="font-size:2.5rem;opacity:0.35;display:block;margin-bottom:0.8rem;"></i>
                @if(request('search'))
                    No certificates found for <strong>"{{ request('search') }}"</strong>.
                    <a href="/admin/dashboard" style="color:var(--primary);">Clear search.</a>
                @else
                    No certificates yet.
                    <a href="/admin/certificates/create" style="color:var(--primary);">Create one now.</a>
                @endif
            </div>
        @else
            <div class="table-responsive" style="overflow-x:auto;">
                <table class="table tbl-compact mb-0" style="min-width:860px;">
                    <thead>
                        <tr>
                            <th style="width:38px;">#</th>
                            <th>Certificate ID</th>
                            <th>Candidate Name</th>
                            <th>Course</th>
                            <th>Type</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Status</th>
                            <th style="text-align:center;width:64px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($certificates as $cert)
                        <tr>
                            <td style="color:var(--muted);font-weight:600;">
                                {{ ($certificates->currentPage() - 1) * $certificates->perPage() + $loop->iteration }}
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:5px;">
                                    <span class="cert-chip" style="font-size:0.75rem;">{{ $cert->certificate_id }}</span>
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
                            <td style="font-weight:600;max-width:160px;overflow:hidden;text-overflow:ellipsis;">
                                {{ $cert->candidate_name }}
                            </td>
                            <td style="color:var(--muted);max-width:160px;overflow:hidden;text-overflow:ellipsis;">
                                {{ $cert->training_name }}
                            </td>
                            <td>
                                @if($cert->course_type === 'Physical')
                                    <span class="pill-physical"><i class="fas fa-building" style="margin-right:3px;"></i>Physical</span>
                                @elseif($cert->course_type === 'Online')
                                    <span class="pill-online"><i class="fas fa-wifi" style="margin-right:3px;"></i>Online</span>
                                @else
                                    <span style="color:var(--muted);font-size:0.78rem;">—</span>
                                @endif
                            </td>
                            <td style="color:var(--muted);">
                                {{ $cert->start_date ? \Carbon\Carbon::parse($cert->start_date)->format('d M Y') : '—' }}
                            </td>
                            <td style="color:var(--muted);">
                                {{ $cert->end_date ? \Carbon\Carbon::parse($cert->end_date)->format('d M Y') : '—' }}
                            </td>
                            <td>
                                @if ($cert->status === 'Valid')
                                    <span class="badge-valid"><i class="fas fa-check"></i> Valid</span>
                                @else
                                    <span class="badge-invalid"><i class="fas fa-times"></i> Invalid</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                @if(session('admin_role') === 'admin')
                                    <div style="display:flex;align-items:center;justify-content:center;gap:5px;">
                                        <a
                                            href="/admin/certificates/{{ $cert->id }}/edit"
                                            class="btn-icon-edit"
                                            title="Edit"
                                        ><i class="fas fa-pen"></i></a>
                                        <button
                                            class="btn-icon-del"
                                            onclick="confirmDelete({{ $cert->id }}, '{{ addslashes($cert->candidate_name) }}')"
                                            title="Delete"
                                        ><i class="fas fa-trash"></i></button>
                                        <form id="del-{{ $cert->id }}" action="/admin/certificates/{{ $cert->id }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                @else
                                    <span style="color:var(--border);font-size:1rem;" title="No access">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if($certificates->hasPages())
                <div style="padding:0.9rem 1.2rem;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.5rem;">
                    <span style="font-size:0.8rem;color:var(--muted);">
                        Showing {{ $certificates->firstItem() }}–{{ $certificates->lastItem() }} of {{ $certificates->total() }} records
                    </span>
                    <div style="display:flex;align-items:center;gap:0.3rem;">
                        @if($certificates->onFirstPage())
                            <span class="pg-btn disabled"><i class="fas fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $certificates->previousPageUrl() }}" class="pg-btn"><i class="fas fa-chevron-left"></i></a>
                        @endif

                        @foreach($certificates->getUrlRange(max(1, $certificates->currentPage()-2), min($certificates->lastPage(), $certificates->currentPage()+2)) as $page => $url)
                            @if($page == $certificates->currentPage())
                                <span class="pg-btn active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="pg-btn">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if($certificates->hasMorePages())
                            <a href="{{ $certificates->nextPageUrl() }}" class="pg-btn"><i class="fas fa-chevron-right"></i></a>
                        @else
                            <span class="pg-btn disabled"><i class="fas fa-chevron-right"></i></span>
                        @endif
                    </div>
                </div>
            @endif
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
    function copyId(btn, id) {
        navigator.clipboard.writeText(id).then(() => {
            const tip = btn.querySelector('.copy-tooltip');
            tip.classList.add('show');
            setTimeout(() => tip.classList.remove('show'), 1800);
        });
    }

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
