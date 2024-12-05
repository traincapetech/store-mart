<?php
use Illuminate\Support\Facades\Route;
use App\helper\helper;
use App\Http\Controllers\addons\GoogleLoginController;
/*
|--------------------------------------------------------------------------
| Web Routes

|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!
|
*/


//Login with Google
Route::get('checklogin/google/callback-{logintype}', [GoogleLoginController::class, 'check_login']);


Route::group(['namespace' => 'admin', 'prefix' => 'admin'], function () {
    Route::post('/google_login', [GoogleLoginController::class, 'googleloginsettings']);
   
       //Login with Google
    Route::get('login/google-{type}', [GoogleLoginController::class, 'redirectToGoogle']);

   
    
});

$domain = @env('WEBSITE_HOST');
$parsedUrl = parse_url(url()->current());
$host = $parsedUrl['host'];
if (array_key_exists('host', $parsedUrl)) {
    // if it is a path based URL
    if ($host == @env('WEBSITE_HOST')) {
        $domain = $domain;
        $prefix = '{vendor_slug}';
    }
    // if it is a subdomain / custom domain
    else {
        $prefix = '';
    }
}

Route::group(['namespace' => "web", 'prefix' => $prefix, 'middleware' => 'FrontMiddleware'], function () {
    //Login with Google
    Route::get('/login/google-{type}', [GoogleLoginController::class, 'redirectToGoogle']);

    

});
