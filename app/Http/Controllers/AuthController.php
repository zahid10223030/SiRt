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
        
        if(Auth::check()){
            return redirect('/dashboard');
        }
        // dd('Test: method login dipanggil');
        return view('pages.auth.login');
    }

    // autentikasi
    public function authenticate(Request $request){
        if(Auth::check()){
            return back();
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $userStatus= Auth::user()->status;

            // dd(Auth::user());
            if ($userStatus == 'submitted'){
                $this->_logout($request);
                // Flash message SETELAH session baru dibuat
                return redirect('/')->with('error', 'Akun anda masih menunggu persetujuan admin');
            }
            else if($userStatus == 'rejected'){
                $this->_logout($request);
                return redirect('/')->with('error', 'Akun anda telah ditolak oleh admin');
            }

            return redirect()->intended('dashboard');
        }

        return redirect('/')->with('error', 'Email atau password yang Anda masukkan salah.');

        // return redirect('/')
        // ->withErrors([
        //     'email' => 'Email atau password yang Anda masukkan salah.'
        // ])
        // ->withInput($request->only('email'));
    }

    // registrasi
    public function registerView(){
        if(Auth::check()){
            return back();
        }
        return view('pages.auth.register');
    }
    public function register(Request $request){

        if(Auth::check()){
            return back();
        }

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

        return redirect('/')->with('success', 'Berhasil mendafatrkan akun, 
        menunggu persetujuan dari Admin');
    }

    public function _logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    // logout
    public function logout(Request $request){
    if(!Auth::check()){
        return redirect('/');
    }
    
    $this->_logout($request); 
 
    return redirect('/');
    }
}
