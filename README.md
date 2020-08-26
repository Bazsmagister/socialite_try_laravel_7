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

in App\Http\Controllers\Auth;
