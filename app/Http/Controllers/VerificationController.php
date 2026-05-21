<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
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
}
