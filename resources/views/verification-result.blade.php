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
        max-width: 520px;
        overflow: hidden;
    }

    /* --- LOGO AREA --- */
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

    /* --- STATUS BANNER (thin strip, not full header) --- */
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

    /* --- DETAIL ROWS --- */
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

    /* --- ACTIONS --- */
    .result-actions {
        padding: 1rem 1.6rem 1.6rem;
        text-align: center;
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

    .btn-back:hover {
        background: var(--primary);
        color: white;
    }

    /* --- NOT FOUND --- */
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
</style>
@endsection

@section('content')
<main>
<div class="result-wrap">
    <div class="result-card">

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
                    <span class="detail-val">{{ $certificate->training_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Completion Date</span>
                    <span class="detail-val">{{ \Carbon\Carbon::parse($certificate->completion_date)->format('d M Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Status</span>
                    <span class="detail-val">
                        <span class="badge-valid"><i class="fas fa-check"></i> Valid</span>
                    </span>
                </div>
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

        @endif

        <div class="result-actions">
            <a href="/verification" class="btn-back">
                <i class="fas fa-arrow-left"></i> Verify Another Certificate
            </a>
        </div>

    </div>
</div>
</main>
@endsection
