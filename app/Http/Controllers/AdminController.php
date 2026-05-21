<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // ────────────────────────────────
    //  AUTH
    // ────────────────────────────────

    public function loginPage()
    {
        if (session('admin_logged_in')) {
            return redirect('/admin/dashboard');
        }
        return view('admin.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        // Check user exists, password matches, and role is admin
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Invalid email or password. Please try again.');
        }

        if ($user->role !== 'admin') {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Access denied. You are not authorised to access the admin panel.');
        }

        // Store session
        session([
            'admin_logged_in' => true,
            'admin_name'      => $user->name,
            'admin_email'     => $user->email,
        ]);

        return redirect('/admin/dashboard');
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_name', 'admin_email']);
        return redirect('/admin');
    }

    // ────────────────────────────────
    //  DASHBOARD
    // ────────────────────────────────

    public function dashboard()
    {
        $this->checkAuth();
        $certificates = Certificate::latest()->get();
        return view('admin.dashboard', compact('certificates'));
    }

    // ────────────────────────────────
    //  CREATE
    // ────────────────────────────────

    public function createPage()
    {
        $this->checkAuth();
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $this->checkAuth();

        $request->validate([
            'candidate_name'  => 'required|string|max:255',
            'training_name'   => 'required|string|max:255',
            'completion_date' => 'required|date',
            'status'          => 'required|in:Valid,Invalid',
        ]);

        $certificate_id = $this->generateCertificateId();

        Certificate::create([
            'candidate_name'  => $request->candidate_name,
            'training_name'   => $request->training_name,
            'completion_date' => $request->completion_date,
            'status'          => $request->status,
            'certificate_id'  => $certificate_id,
        ]);

        return redirect('/admin/dashboard')
            ->with('success', 'Certificate created successfully! ID: ' . $certificate_id);
    }

    // ────────────────────────────────
    //  EDIT
    // ────────────────────────────────

    public function editPage($id)
    {
        $this->checkAuth();
        $certificate = Certificate::findOrFail($id);
        return view('admin.edit', compact('certificate'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAuth();

        $request->validate([
            'candidate_name'  => 'required|string|max:255',
            'training_name'   => 'required|string|max:255',
            'completion_date' => 'required|date',
            'status'          => 'required|in:Valid,Invalid',
        ]);

        $certificate = Certificate::findOrFail($id);
        $certificate->update([
            'candidate_name'  => $request->candidate_name,
            'training_name'   => $request->training_name,
            'completion_date' => $request->completion_date,
            'status'          => $request->status,
        ]);

        return redirect('/admin/dashboard')
            ->with('success', 'Certificate updated successfully!');
    }

    // ────────────────────────────────
    //  DELETE
    // ────────────────────────────────

    public function delete($id)
    {
        $this->checkAuth();
        $certificate = Certificate::findOrFail($id);
        $certificate->delete();

        return redirect('/admin/dashboard')
            ->with('success', 'Certificate deleted successfully!');
    }

    // ────────────────────────────────
    //  HELPERS
    // ────────────────────────────────

    private function generateCertificateId(): string
    {
        do {
            $numbers = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $letters = strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ'), 0, 4));
            $id      = 'SACHAL-' . $numbers . $letters;
        } while (Certificate::where('certificate_id', $id)->exists());

        return $id;
    }

    private function checkAuth(): void
    {
        if (!session('admin_logged_in')) {
            abort(redirect('/admin'));
        }
    }
}
