# Login with Github and Facebook account using Laravel Socialite using laravel 7.

source:

https://laravel.com/docs/7.x/socialite

https://laracasts.com/series/learn-socialite/episodes/1

`composer require laravel/socialite`

it installed: 4.4.1

(Installing league/oauth1-client (1.7.0): Downloading (100%))
(Installing laravel/socialite (v4.4.1): Downloading (100%))

# login with Github

go to:

github.com/yourpage

settings

developer settings

OAuth apps

New OAuth app

fill the needed data

register, and create an app name. you get an ID, and a secret. This ones should you fill in your .env file.

## in config/services.php add for github for example

`'github' => [ 'client_id' => env('GITHUB_CLIENT_ID'), 'client_secret' => env('GITHUB_CLIENT_SECRET'), 'redirect' => 'http://localhost:8000/login/github/callback', ],`

## in .inv fill the data you got from github:

GITHUB_CLIENT_ID=

GITHUB_CLIENT_SECRET=

## then :

`composer require laravel/ui`

`php artisan ui bootstrap --auth`

`npm install && npm run dev`

(it installs vue-template-compiler for me also)

## in App\Http\Controllers\Auth\LoginController.php:

`
public function redirectToProvider()
{
return Socialite::driver('github')->redirect();
}

public function handleProviderCallback()
{

         $githubUser = Socialite::driver('github')->user();
        // $user->token;

        //User create:
        $user = User::firstOrCreate(
            [

            'provider_id' => $githubUser->getId()

            ],
            [
            'email' => $githubUser->getEmail(),
            'name' => $githubUser->getName(),
            // 'avatar' => $githubUser->getAvatar(),

            ]
        );

        //Log the user in:
        auth()->login($user, true);

        //redirect to dashboard
        return redirect('home');
    }

`

## in routes add:

Route::get('login/github', 'Auth\LoginController@redirectToProvider');

Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');

---

Once you have a user instance, you can grab a few more details about the user:

\$user = Socialite::driver('github')->user();

// OAuth Two Providers
$token = $user->token;
$refreshToken = $user->refreshToken; // not always provided
$expiresIn = $user->expiresIn;

// OAuth One Providers
$token = $user->token;
$tokenSecret = $user->tokenSecret;

// All Providers
$user->getId();
$user->getNickname();
$user->getName();
$user->getEmail();
\$user->getAvatar();

---

# login with facebook:

go to:

developers.facebook.com

register, and create an app name. you get an ID, and a secret. This ones should you fill in your .env file.

There is a products section : Facebook login

## in services.php:

'facebook' => [
'client_id' => env('FACEBOOK_CLIENT_ID'),
'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
'redirect' => 'http://localhost:8000/login/facebook/callback',
],

## in .inv fill the data you got from developers.facebook.com:

FACEBOOK_CLIENT_ID=

FACEBOOK_CLIENT_SECRET=

## in web.php:

Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');

Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

## in login.blade.php:

put:

`<a href="/login/facebook">Login with facebook</a>`

## in LoginController.php:

public function redirectToProvider()
{
return Socialite::driver('facebook')->redirect();
}

    /**
     * Obtain the user information from FB.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $fbuser = Socialite::driver('facebook')->user();

        //dd($fbuser);

        //User create:
        $user = User::firstOrCreate(
            [

            'provider_id' => $fbuser->getId()

            ],
            [
            'email' => $fbuser->getEmail(),
            'name' => $fbuser->getName(),
            ]
        );

        //Log the user in:
        auth()->login($user, true);

        //redirect to dashboard
        return redirect('home');
    }

## in User.php

add 'provider_id' to fillable, or make a:

`protected $guarded=[];`

## in database/migrations/user:

\$table->string('password')->nullable();

\$table->string('provider_id')->nullable();

### Other providers:

https://socialiteproviders.com/

## Other interesting things from Laravel7.docs:

Retrieving User Details From A Token (OAuth2)

If you already have a valid access token for a user, you can retrieve their details using the userFromToken method:

$user = Socialite::driver('github')->userFromToken($token);

Retrieving User Details From A Token And Secret (OAuth1)

If you already have a valid pair of token / secret for a user, you can retrieve their details using the userFromTokenAndSecret method:

$user = Socialite::driver('twitter')->userFromTokenAndSecret($token, \$secret);
