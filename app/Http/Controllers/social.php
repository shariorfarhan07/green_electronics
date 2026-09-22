<?php
    namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class social extends Controller

{
    protected $redirectTo = RouteServiceProvider::HOME;
    public function handleProviderCallback($platform)
    {
        $userinfo = Socialite::driver($platform)->user();

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
    public function redirectToProvider($platform)
    {
        return Socialite::driver($platform)->redirect();

    }
    public function handleProviderCallbackgit(){
        handleProviderCallback('github');
    }
    public function redirectToProvidergit(){
        redirectToProvider('github');
    }

}
