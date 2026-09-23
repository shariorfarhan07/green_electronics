<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

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

    /** Overrides AuthenticatesUsers::showLoginForm(), which renders a Blade view. */
    public function showLoginForm()
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
        ]);
    }



    public function redirectToProvider($platform)
    {
        return Socialite::driver($platform)->redirect();

    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($platform)
    {
        $userinfo = Socialite::driver($platform)->stateless()->user();

        // add user to data base

        $user=User::where('providerid',$userinfo->getId())->first();


        if(!$user) {
            $user = User::create([
                'email' => $userinfo->getEmail(),
                'name' => $userinfo->getName(),
                'providerid' => $userinfo->getId(),
                'provider' => $platform,
                'admin'=>0,

            ]);
        }


        // login user
        Auth::login($user,true);
        return redirect($this->redirectTo);
    }














}
