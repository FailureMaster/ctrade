<?php
namespace App\Http\Controllers\Admin\Auth;

use Pusher\Pusher;
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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = 'admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('admin.guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $pageTitle = "Admin Login";
        return view('admin.auth.login', compact('pageTitle'));
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return auth()->guard('admin');
    }

    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {

        $this->validateLogin($request);

        $request->session()->regenerateToken();

        if(!verifyCaptcha()){
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }



        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $admin->last_activity = null;
        $admin->save();
        
        $pusher = new Pusher(
            'c5afd2b879ff37c4a429',
             'bc91ce796e70e0861721',
             '1688847',
             [
                 'cluster' => 'ap2',
                 'useTLS' => true,
             ]
         );

         // Data to send to Pusher
         $data = [
             'adminId' => $admin->id,
             'isActive' => false,
             'message' => 'Admin is offline',
         ];

         // Trigger the event on Pusher
         $pusher->trigger('admin-status-channel', 'admin-online-status', $data);
     
        $this->guard('admin')->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect($this->redirectTo);
    }
}
