<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas.',
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'password'     => 'required|string|min:8|confirmed',
            'company_name' => 'required|string|max:255',
            'company_ice'  => 'nullable|string|size:15',
            'company_rc'   => 'nullable|string|max:100',
            'company_if'   => 'nullable|string|max:9',
            'company_city' => 'nullable|string|max:100',
        ]);

        $company = Company::create([
            'name'   => $request->company_name,
            'ice'    => $request->company_ice ?? '000000000000000',
            'rc'     => $request->company_rc,
            'if'     => $request->company_if,
            'phone'  => $request->company_phone,
            'city'   => $request->company_city,
            'status' => 'active',
        ]);

        $user = User::create([
            'company_id' => $company->id,
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'ADMIN',
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
