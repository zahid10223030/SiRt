<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // login
    public function login(){
        return view('pages.auth.login');
    }

    // autentikasi
    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $userStatus= Auth::user()->status;

            // dd(Auth::user());
            if ($userStatus == 'submitted'){
                return back()->withErrors([
                    'email' => 'Akun anda masih menunggu persetujuan admin',]);
            }
            else if($userStatus == 'rejected'){
                return back()->withErrors([
                    'email' => 'Akun anda telah ditolak admin',]);
            }

            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'Terjadi kesalahan, periksa kembali email atau password anda!',
        ])->onlyInput('email');
    }

    // registrasi
    public function registerView(){
        return view('pages.auth.register');
    }
    public function register(Request $request){
        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user= new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role_id = 2; // User (penduduk)
        $user->saveOrFail();

        return redirect('/')->with('success', 'Berhasil mendafatarkan akun, 
        menunggu persetujuan dari Admin');
    }

    // logout
    public function logout(Request $request){
    Auth::logout();
 
    $request->session()->invalidate();
 
    $request->session()->regenerateToken();
 
    return redirect('/');
    }
}
