<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'phone';
    }

    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['is_active' => true]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = \App\Models\User::where($this->username(), $request->{$this->username()})->first();

        if ($user && !$user->is_active) {
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    $this->username() => 'حساب کاربری شما غیرفعال است. لطفاً با پشتیبانی تماس بگیرید.',
                ]);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => trans('auth.failed'),
            ]);
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);
        
        $user = \App\Models\User::where($this->username(), $request->{$this->username()})->first();
        
        if ($user && !$user->is_active) {
            return false;
        }

        return $this->guard()->attempt(
            $credentials, $request->boolean('remember')
        );
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->intended($this->redirectPath());
    }
}
