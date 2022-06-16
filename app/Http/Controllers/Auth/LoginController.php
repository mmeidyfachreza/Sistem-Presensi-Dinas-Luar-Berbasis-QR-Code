<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {


        $this->validate($request, [
            'username' => 'required|string', //VALIDASI KOLOM USERNAME
            //TAPI KOLOM INI BISA BERISI EMAIL ATAU USERNAME
            'password' => 'required|string|min:6',
            // 'captcha' => 'required|captcha'
        ]);
        $remember = ($request->has('remember')) ? true : false;
        //LAKUKAN LOGIN
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password],$remember)) {
            //JIKA BERHASIL, MAKA REDIRECT KE HALAMAN Dashboard
            return redirect()->route('dashboard');
        }
        //JIKA SALAH, MAKA KEMBALI KE LOGIN DAN TAMPILKAN NOTIFIKASI
        throw ValidationException::withMessages([
            'username' => ['Username/Password tidak ditemukan.'],
        ]);

        return redirect()->route('login')->with(['username' => 'Username/Password salah!']);
    }

    /**
     * Log the user out of the application.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('login')
            ->withSuccess('Terimakasih, selamat datang kembali!');
    }
}
