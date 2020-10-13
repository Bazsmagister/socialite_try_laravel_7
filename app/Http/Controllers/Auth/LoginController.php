<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
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

    //till that orig
    //I added for Socialite from documentation:


    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();

        // return Socialite::driver('github')->redirect();
        //A number of OAuth providers support optional parameters in the redirect request. To include any optional parameters in the request, call the with method with an associative array:

        // return Socialite::driver('google')
        // ->with(['hd' => 'example.com'])
        // ->redirect();
        //---

        //The stateless method may be used to disable session state verification. This is useful when adding social authentication to an API:
        //return Socialite::driver('google')->stateless()->user();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $fbuser = Socialite::driver('facebook')->user();

        dd($fbuser);
        // $user = Socialite::driver('github')->user();
        // $user->token;


        //User create:
        $user = User::firstOrCreate(
            [

            'provider_id' => $fbuser->getId()

            ],
            [
            'email' => $fbuser->getEmail(),
            'name' => $fbuser->getName(),
            // 'avatar' => $fbuser->getAvatar(),

            ]
        );

        //Log the user in:
        auth()->login($user, true);

        //redirect to dashboard
        return redirect('home');
    }

    //The redirect method takes care of sending the user to the OAuth provider, while the user method will read the incoming request and retrieve the user's information from the provider.
}
