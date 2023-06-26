<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PassageAuthController;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::view('login', 'login')->name('login');
Route::view('/dashboard', 'dashboard')->middleware('auth');

Route::view('passwordless_login', 'passage_login')->name('passwordless_login');

Route::get('enable_passkeys', [PassageAuthController::class, "AddPassagePasskeysFromProfile"])
->middleware('auth')->name('enable_passkeys');

Route::get('/passage_auth', [PassageAuthController::class, 'AuthenticateUser'])->middleware('passage');
// Route::get('/{token}/profile', [PassageAuthController::class, 'RedirectToProfile'])->middleware('passage');

Route::get('profile', function (Request $request) {
    $user = $request->user();
    return view('profile', ["user" => $user]);  
})->middleware('auth')->name('profile');


