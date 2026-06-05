<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Invalid email or password. Please try again.');
        }

        if (!in_array($user->role, ['admin', 'coordinator'])) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Access denied. You are not authorised to access this panel.');
        }

        session([
            'admin_logged_in' => true,
            'admin_name'      => $user->name,
            'admin_email'     => $user->email,
            'admin_role'      => $user->role,
        ]);

        return redirect('/admin/dashboard');
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_name', 'admin_email', 'admin_role']);
        return redirect('/admin');
    }

    // ────────────────────────────────
    //  DASHBOARD
    // ────────────────────────────────

    public function dashboard(Request $request)
    {
        $this->checkAuth();

        $query = Certificate::latest();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('candidate_name', 'like', "%{$search}%")
                  ->orWhere('certificate_id', 'like', "%{$search}%");
            });
        }

        $certificates = $query->paginate(25)->withQueryString();

        $totalCount   = Certificate::count();
        $validCount   = Certificate::where('status', 'Valid')->count();
        $invalidCount = Certificate::where('status', 'Invalid')->count();

        return view('admin.dashboard', compact(
            'certificates', 'totalCount', 'validCount', 'invalidCount'
        ));
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
            'status'          => 'required|in:Valid,Invalid',
            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date',
            'course_type'     => 'nullable|in:Physical,Online',
        ]);

        $certificate_id = $this->generateCertificateId();

        Certificate::create([
            'candidate_name'  => $request->candidate_name,
            'training_name'   => $request->training_name,
            'status'          => $request->status,
            'certificate_id'  => $certificate_id,
            'start_date'      => $request->start_date ?: null,
            'end_date'        => $request->end_date ?: null,
            'course_type'     => $request->course_type ?: null,
        ]);

        return redirect('/admin/dashboard')
            ->with('success', 'Certificate created successfully! ID: ' . $certificate_id);
    }

    // ────────────────────────────────
    //  EDIT  (admin only)
    // ────────────────────────────────

    public function editPage(int $id)
    {
        $this->checkFullAccess();
        $certificate = Certificate::findOrFail($id);
        return view('admin.edit', compact('certificate'));
    }

    public function update(Request $request, int $id)
    {
        $this->checkFullAccess();

        $request->validate([
            'candidate_name'  => 'required|string|max:255',
            'training_name'   => 'required|string|max:255',
            'status'          => 'required|in:Valid,Invalid',
            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date',
            'course_type'     => 'nullable|in:Physical,Online',
        ]);

        $certificate = Certificate::findOrFail($id);
        $certificate->update([
            'candidate_name'  => $request->candidate_name,
            'training_name'   => $request->training_name,
            'status'          => $request->status,
            'start_date'      => $request->start_date ?: null,
            'end_date'        => $request->end_date ?: null,
            'course_type'     => $request->course_type ?: null,
        ]);

        return redirect('/admin/dashboard')
            ->with('success', 'Certificate updated successfully!');
    }

    // ────────────────────────────────
    //  DELETE  (admin only)
    // ────────────────────────────────

    public function delete(int $id)
    {
        $this->checkFullAccess();
        $certificate = Certificate::findOrFail($id);
        $certificate->delete();

        return redirect('/admin/dashboard')
            ->with('success', 'Certificate deleted successfully!');
    }

    // ────────────────────────────────
    //  CHANGE PASSWORD
    // ────────────────────────────────

    public function changePasswordPage()
    {
        $this->checkAuth();
        return view('admin.change-password');
    }

    public function changePassword(Request $request)
    {
        $this->checkAuth();

        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('email', session('admin_email'))->firstOrFail();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully!');
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

    private function checkFullAccess(): void
    {
        $this->checkAuth();
        if (session('admin_role') !== 'admin') {
            abort(403, 'Access denied. You do not have permission to perform this action.');
        }
    }
}
