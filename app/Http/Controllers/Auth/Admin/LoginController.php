<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/easy-hostel/back-end';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required',
            'password'  => 'required'            
        ]);
        
        $credentials = $request->only('email', 'password');
        // dd($credentials);
        if (auth()->guard('admin')->attempt($credentials)) {
            return redirect('/easy-hostel/back-end');
        }
        return back()->withErrors(['email' => 'Email or password is wrong.']);
    }

    public function logout(Request $request) {
        auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
