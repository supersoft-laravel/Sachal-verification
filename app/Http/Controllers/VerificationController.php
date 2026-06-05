<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        return view('verification');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'certificate_id' => 'required|string',
        ]);

        $certificate = Certificate::where('certificate_id', trim($request->certificate_id))->first();

        if (!$certificate || $certificate->status === 'Invalid') {
            return view('verification-result', ['certificate' => null, 'notFound' => true]);
        }

        return view('verification-result', ['certificate' => $certificate, 'notFound' => false]);
    }

    public function downloadPdf(string $certificate_id)
    {
        $certificate = Certificate::where('certificate_id', $certificate_id)
            ->where('status', 'Valid')
            ->first();

        if (!$certificate) {
            abort(404, 'Certificate not found.');
        }

        $pdf = Pdf::loadView('certificate-pdf', compact('certificate'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('certificate-' . $certificate->certificate_id . '.pdf');
    }
}
