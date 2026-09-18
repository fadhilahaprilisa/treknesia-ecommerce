<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\DataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Tampilkan halaman login user
     */
    public function showUserLogin()
    {
        if (session('user_id')) {
            return redirect('/products');
        }
        return view('auth.login-user');
    }

    /**
     * Proses login user
     */
    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = $this->dataService->getUserByEmail($request->email);

        if (!$user || $user['role'] !== 'user') {
            return back()->with('error', 'Email atau password salah, atau Anda bukan user.');
        }

        if (!Hash::check($request->password, $user['password'])) {
            return back()->with('error', 'Email atau password salah.');
        }

        // Set session
        session([
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'user_email' => $user['email'],
            'user_role' => 'user',
            'user_whatsapp' => $user['whatsapp'] ?? null
        ]);

        return redirect('/products')->with('success', 'Selamat datang, ' . $user['name']);
    }

    /**
     * Tampilkan halaman login admin
     */
    public function showAdminLogin()
    {
        if (session('admin_id')) {
            return redirect('/admin/dashboard');
        }
        return view('auth.login-admin');
    }

    /**
     * Proses login admin
     */
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = $this->dataService->getUserByEmail($request->email);

        if (!$user || $user['role'] !== 'admin') {
            return back()->with('error', 'Email atau password salah, atau Anda bukan admin.');
        }

        if (!Hash::check($request->password, $user['password'])) {
            return back()->with('error', 'Email atau password salah.');
        }

        // Set session admin
        session([
            'admin_id' => $user['id'],
            'admin_name' => $user['name'],
            'admin_email' => $user['email'],
            'admin_role' => 'admin'
        ]);

        return redirect('/admin/dashboard')->with('success', 'Selamat datang Admin, ' . $user['name']);
    }

    /**
     * Registrasi user baru
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'whatsapp' => 'required|string|max:20',
            'password' => 'required|min:6|confirmed'
        ]);

        // Cek email sudah terdaftar
        $existing = $this->dataService->getUserByEmail($request->email);
        if ($existing) {
            return back()->with('error', 'Email sudah terdaftar.');
        }

        // Simpan user baru
        $user = $this->dataService->saveUser([
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

        // Auto login
        session([
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'user_email' => $user['email'],
            'user_role' => 'user',
            'user_whatsapp' => $user['whatsapp']
        ]);

        return redirect('/products')->with('success', 'Registrasi berhasil! Selamat datang, ' . $user['name']);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/')->with('success', 'Anda telah logout.');
    }
}