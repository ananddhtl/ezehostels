<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.user.register');
    }
    public function showVendorRegistrationForm()
    {
        return view('auth.user.registerasvendor');
    }
    /* overriding default register */
    public function register(Request $request)
    {
        
        $request->validate([
            'name'          => ['required', 'string'],
            'address'       => ['required', 'string'],
            'phone'         => ['required'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $data = $request->all();
        User::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'phone'             => $data['phone'],
            'address'           => $data['address'],
            'password'          => Hash::make($data['password']),
        ]);
        return redirect()->route('login');   
    }

    /* register vendor */
    public function registervendor(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'              => ['required', 'string'],
            'address'           => ['required', 'string'],
            'hostelname'        => ['required', 'string'],
            'hosteladdress'     => ['required', 'string'],
            'phone'             => ['required'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'          => ['required', 'string', 'min:8', 'confirmed'],
        ]);
       
        $data = $request->all();
        User::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'phone'             => $data['phone'],
            'address'           => $data['address'],
            'type'              => 'vendor',
            'hostel_name'       => $data['hostelname'],
            'hostel_address'    => $data['hosteladdress'],
            'password'          => Hash::make($data['password']),
        ]); 
        return redirect()->route('login');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }

   
    
}
