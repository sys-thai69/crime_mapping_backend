<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showRegistrationForm()
    {
        return view('admin_page.register');
    }

    public function adminRegister(Request $request)
    {
        $registerField = $request->validate([
            'admin_username' => ['required', 'min:3', 'max:10', 'unique:admin'],
            'admin_email' => ['required', 'email', 'unique:admin'],
            'admin_pass' => ['required', 'min:8', 'confirmed'],
        ]);
        
        $registerField['admin_pass'] = Hash::make($registerField['admin_pass']);
        $admin = Admin::create($registerField);

        Auth::guard('admin')->login($admin);

        return redirect('/homepage'); 
    }

    public function showLoginForm()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin_page.login');
    }

    public function adminLogin(Request $request)
    {
        $loginField = $request->validate([
            'adminloginName' => 'required',
            'adminloginPass' => 'required',
        ]);

        $credentials = [
            'admin_username' => $loginField['adminloginName'],
            'password' => $loginField['adminloginPass'],
        ];

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/homepage'); 
        }

        return back()->withErrors([
            'adminloginName' => 'The provided credentials do not match our records.',
        ]);
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login_admin'); // Make sure this route exists
    }
}
