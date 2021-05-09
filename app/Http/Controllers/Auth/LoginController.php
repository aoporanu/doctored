<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Auth;
use Log;

use Illuminate\Support\Facades\Hash;

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
        //$this->middleware('guest')->except('logout');
        $this->middleware('guest:doctor')->except('logout');
        $this->middleware('guest:patient')->except('logout');
    }

    public function loginForm()
    {
        return view('Frontend::login');
    }

    public function userLogin(Request $request)
    {
        $data = $request->all();
        if ($request->Logintype == 'doctor') {
            session()->put('tab_name_log', 'doc_log');
        } else {
            session()->put('tab_name_log', 'pat_log');
        }
        $validatedData = $request->validate([
            'email'   => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (isset($request->Logintype)) {
            $password = $data['password'];
            if ($request->Logintype == 'doctor') {

                if (Auth::guard('doctor')->attempt(['email' => $request->email, 'password' => $password])) {
                    $user = json_decode(json_encode(Auth::guard('doctor')->user()), 1);
                    $user['is_active'] = 1;
                    $user['is_verified'] = 1;
                    $user['is_delete'] = 0;
                    if (isset($user['is_active']) && 
                        isset($user['is_verified']) && 
                        isset($user['is_delete']) && 
                        $user['is_active'] == 1 && 
                        $user['is_verified'] == 1 && 
                        $user['is_delete'] == 0) {
                        return redirect()->intended('/doctor-dashboard');
                    } else if (isset($user['is_active']) && $user['is_active'] == 0) {
                        Auth::guard('doctor')->logout();
                        return redirect()->route('login')
                            ->with('error', 'Your account is not active');
                    } else if (isset($user['is_verified']) && !$user['is_verified']) {
                        Auth::guard('doctor')->logout();
                        return redirect()->route('login')
                            ->with('error', 'Your account is not verified');
                    } else {
                        Auth::guard('doctor')->logout();
                        return redirect()->route('login')
                            ->with('error', 'Invalid Credentials');
                    }
                } else {
                    return redirect()->route('login')
                        ->with('error', 'Invalid Credentials');
                }
            }
            else {
                if (Auth::guard('patient')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                    return redirect()->intended('/patient-dashboard');
                } else {
                    return redirect()->route('login')
                        ->with('error', 'Invalid Credentials');
                }
            }
        }

        return back()->withInput($request->only('email', 'remember'));
    }
    public function logout()
    {
        Auth::guard('doctor')->logout();
        Auth::guard('patient')->logout();
        return redirect()->intended('/login');
    }
}
