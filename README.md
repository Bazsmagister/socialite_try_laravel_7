composer require laravel/socialite
4.4.1

-   Installing league/oauth1-client (1.7.0): Downloading (100%)
-   Installing laravel/socialite (v4.4.1): Downloading (100%)

https://laravel.com/docs/7.x/socialite

in config/services.php add for github for example

'github' => [
'client_id' => env('GITHUB_CLIENT_ID'),
'client_secret' => env('GITHUB_CLIENT_SECRET'),
'redirect' => 'http://your-callback-url',
],

composer require laravel/ui

php artisan ui bootstrap --auth

npm install && npm run dev
(it installs vue-template-compiler)

in App\Http\Controllers\Auth\LoginController.php:

A number of OAuth providers support optional parameters in the redirect request. To include any optional parameters in the request, call the with method with an associative array:

return Socialite::driver('google')
->with(['hd' => 'example.com'])
->redirect();

The stateless method may be used to disable session state verification. This is useful when adding social authentication to an API:

return Socialite::driver('google')->stateless()->user();

---

in routes add:
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

Retrieving User Details From A Token (OAuth2)

If you already have a valid access token for a user, you can retrieve their details using the userFromToken method:

$user = Socialite::driver('github')->userFromToken($token);

Retrieving User Details From A Token And Secret (OAuth1)

If you already have a valid pair of token / secret for a user, you can retrieve their details using the userFromTokenAndSecret method:

$user = Socialite::driver('twitter')->userFromTokenAndSecret($token, \$secret);

Other providers, not just the main ones:
https://socialiteproviders.com/
