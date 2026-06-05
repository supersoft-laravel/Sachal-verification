@extends('layouts.app')

@section('title', 'Verification Result - Sachal Consulting Services')

@section('extra-css')
<style>
    body { background: #eef3fb; }

    .result-wrap {
        min-height: calc(100vh - 56px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .result-card {
        background: white;
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: 0 4px 30px rgba(26,92,184,0.1);
        width: 100%;
        max-width: 560px;
        overflow: hidden;
    }

    .result-logo {
        text-align: center;
        padding: 1.8rem 2rem 1.2rem;
        border-bottom: 1px solid var(--border);
    }

    .result-logo img {
        max-width: 210px;
        height: auto;
        object-fit: contain;
    }

    .status-strip {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.85rem 1.6rem;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .status-strip.ok {
        background: var(--success-bg);
        color: var(--success-text);
        border-bottom: 1px solid #b2dfcc;
    }

    .status-strip.fail {
        background: var(--danger-bg);
        color: var(--danger-text);
        border-bottom: 1px solid #f5c6c6;
    }

    .detail-body {
        padding: 0.4rem 1.6rem 1.2rem;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.8rem 0;
        border-bottom: 1px solid var(--border);
        gap: 1rem;
    }

    .detail-row:last-child { border-bottom: none; }

    .detail-key {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .detail-val {
        font-size: 0.93rem;
        font-weight: 700;
        color: var(--text);
        text-align: right;
    }

    .detail-val.course-title {
        font-size: 1.08rem;
        font-weight: 800;
    }

    .result-actions {
        padding: 1rem 1.6rem 1.6rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.7rem;
        flex-wrap: wrap;
    }

    .btn-back {
        background: var(--primary-light);
        color: var(--primary);
        border: 1px solid #c5d5f0;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all 0.2s;
    }

    .btn-back:hover { background: var(--primary); color: white; }

    .btn-pdf {
        background: var(--danger-bg);
        color: var(--danger-text);
        border: 1px solid #f5c6c6;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all 0.2s;
    }

    .btn-pdf:hover { background: var(--danger-text); color: white; }

    .btn-print {
        background: var(--accent-light);
        color: var(--accent);
        border: 1px solid #ffd9b8;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all 0.2s;
    }

    .btn-print:hover { background: var(--accent); color: white; }

    .not-found-body {
        padding: 2rem 1.6rem;
        text-align: center;
    }

    .not-found-body .nf-icon {
        font-size: 2.8rem;
        color: #f5c6c6;
        margin-bottom: 1rem;
    }

    .not-found-body h4 {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--danger-text);
        margin-bottom: 0.4rem;
    }

    .not-found-body p {
        font-size: 0.86rem;
        color: var(--muted);
        max-width: 320px;
        margin: 0 auto;
    }

    /* ── PRINT STYLES: hide everything except the result card ── */
    @media print {
        body * { visibility: hidden; }
        .result-card, .result-card * { visibility: visible; }
        .result-card {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            max-width: 100%;
            border: none;
            box-shadow: none;
            border-radius: 0;
        }
        .result-actions { display: none !important; }
        .site-footer { display: none !important; }
    }
</style>
@endsection

@section('content')
<main>
<div class="result-wrap">
    <div class="result-card" id="printArea">

        {{-- LOGO --}}
        <div class="result-logo">
            <img src="/Logo.png" alt="Sachal Consulting Services">
        </div>

        @if (!$notFound && $certificate)

            {{-- STATUS STRIP --}}
            <div class="status-strip ok">
                <i class="fas fa-check-circle"></i>
                Certificate Verified Successfully
            </div>

            {{-- DETAILS --}}
            <div class="detail-body">
                <div class="detail-row">
                    <span class="detail-key">Certificate ID</span>
                    <span class="detail-val">
                        <span class="cert-chip">{{ $certificate->certificate_id }}</span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Candidate Name</span>
                    <span class="detail-val">{{ $certificate->candidate_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Training / Course</span>
                    <span class="detail-val course-title">{{ $certificate->training_name }}</span>
                </div>
                @if($certificate->course_type)
                <div class="detail-row">
                    <span class="detail-key">Course Type</span>
                    <span class="detail-val">
                        <span style="display:inline-flex;align-items:center;gap:5px;">
                            @if($certificate->course_type === 'Physical')
                                <i class="fas fa-building" style="color:var(--primary);font-size:0.82rem;"></i>
                            @else
                                <i class="fas fa-wifi" style="color:var(--accent);font-size:0.82rem;"></i>
                            @endif
                            {{ $certificate->course_type }}
                        </span>
                    </span>
                </div>
                @endif
                @if($certificate->start_date)
                <div class="detail-row">
                    <span class="detail-key">Start Date</span>
                    <span class="detail-val">{{ \Carbon\Carbon::parse($certificate->start_date)->format('d M Y') }}</span>
                </div>
                @endif
                @if($certificate->end_date)
                <div class="detail-row">
                    <span class="detail-key">End Date</span>
                    <span class="detail-val">{{ \Carbon\Carbon::parse($certificate->end_date)->format('d M Y') }}</span>
                </div>
                @endif
                <div class="detail-row">
                    <span class="detail-key">Status</span>
                    <span class="detail-val">
                        <span class="badge-valid"><i class="fas fa-check"></i> Valid</span>
                    </span>
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="result-actions">
                <a href="/verification" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Verify Another
                </a>
                <a href="/verification/{{ $certificate->certificate_id }}/pdf" class="btn-pdf">
                    <i class="fas fa-file-pdf"></i> Download PDF
                </a>
                <button onclick="window.print()" class="btn-print">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>

        @else

            {{-- NOT FOUND --}}
            <div class="status-strip fail">
                <i class="fas fa-times-circle"></i>
                Certificate Not Found
            </div>
            <div class="not-found-body">
                <div class="nf-icon"><i class="fas fa-file-slash"></i></div>
                <h4>Invalid Certificate ID</h4>
                <p>The certificate ID you entered does not exist or has been marked as invalid. Please double-check and try again.</p>
            </div>
            <div class="result-actions">
                <a href="/verification" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Verify Another Certificate
                </a>
            </div>

        @endif

    </div>
</div>
</main>
@endsection
