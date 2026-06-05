<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificate - {{ $certificate->certificate_id }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            background: #ffffff;
            color: #1a2340;
            padding: 40px;
        }

        .page {
            width: 100%;
            max-width: 680px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            text-align: center;
            border-bottom: 2px solid #1a5cb8;
            padding-bottom: 20px;
            margin-bottom: 24px;
        }

        .header img {
            max-width: 200px;
            height: auto;
        }

        .header .org-name {
            font-size: 12px;
            color: #6b7a99;
            margin-top: 6px;
            letter-spacing: 0.5px;
        }

        /* Title banner */
        .cert-title {
            background: #1a5cb8;
            color: white;
            text-align: center;
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 24px;
        }

        .cert-title h2 {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .cert-title p {
            font-size: 11px;
            opacity: 0.85;
        }

        /* Detail table */
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
        }

        .detail-table tr {
            border-bottom: 1px solid #dde6f5;
        }

        .detail-table tr:last-child {
            border-bottom: none;
        }

        .detail-table td {
            padding: 10px 14px;
            font-size: 12px;
            vertical-align: top;
        }

        .detail-table td.key {
            font-weight: 700;
            color: #6b7a99;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            width: 38%;
            font-size: 10px;
        }

        .detail-table td.val {
            font-weight: 700;
            color: #1a2340;
        }

        .cert-id-val {
            font-family: 'Courier New', monospace;
            background: #e8f0fb;
            color: #1a5cb8;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
        }

        .course-name-val {
            font-size: 14px;
            font-weight: 800;
            color: #1a2340;
        }

        .badge-valid {
            background: #eafaf1;
            color: #1a7a45;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        /* Footer */
        .footer {
            border-top: 1px solid #dde6f5;
            padding-top: 14px;
            text-align: center;
        }

        .footer p {
            font-size: 10px;
            color: #6b7a99;
            line-height: 1.6;
        }

        .footer .verified-stamp {
            display: inline-block;
            border: 2px solid #1a7a45;
            color: #1a7a45;
            border-radius: 6px;
            padding: 4px 14px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
<div class="page">

    {{-- HEADER --}}
    <div class="header">
        <img src="{{ public_path('Logo.png') }}" alt="Sachal Consulting Services">
        <div class="org-name">Sachal Consulting Services</div>
    </div>

    {{-- TITLE --}}
    <div class="cert-title">
        <h2>Certificate of Completion</h2>
        <p>This is to certify that the following participant has successfully completed the training programme.</p>
    </div>

    {{-- DETAILS --}}
    <table class="detail-table">
        <tr>
            <td class="key">Certificate ID</td>
            <td class="val"><span class="cert-id-val">{{ $certificate->certificate_id }}</span></td>
        </tr>
        <tr>
            <td class="key">Candidate Name</td>
            <td class="val">{{ $certificate->candidate_name }}</td>
        </tr>
        <tr>
            <td class="key">Training / Course</td>
            <td class="val course-name-val">{{ $certificate->training_name }}</td>
        </tr>
        @if($certificate->course_type)
        <tr>
            <td class="key">Course Type</td>
            <td class="val">{{ $certificate->course_type }}</td>
        </tr>
        @endif
        @if($certificate->start_date)
        <tr>
            <td class="key">Start Date</td>
            <td class="val">{{ \Carbon\Carbon::parse($certificate->start_date)->format('d M Y') }}</td>
        </tr>
        @endif
        @if($certificate->end_date)
        <tr>
            <td class="key">End Date</td>
            <td class="val">{{ \Carbon\Carbon::parse($certificate->end_date)->format('d M Y') }}</td>
        </tr>
        @endif
        <tr>
            <td class="key">Status</td>
            <td class="val"><span class="badge-valid">&#10003; Valid</span></td>
        </tr>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        <div class="verified-stamp">&#10003; Verified</div>
        <p>
            This certificate has been verified and issued by Sachal Consulting Services.
        </p>
    </div>

</div>
</body>
</html>
