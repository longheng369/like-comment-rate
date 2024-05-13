<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/admin', function () {
    return view('admin');
})->middleware(['auth', 'verified'])->name('admin');

Route::get('/dashboard', function(){
    return view('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auth/google/redirect', function(){
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function(){
    $googleUser = Socialite::driver("google")->user();
    $user = User::updateOrCreate(
        ['google_id'=> $googleUser->id],
        [
            'name' => $googleUser->name,
            'email'=>$googleUser->email,
            'password' => Str::password(12),
        ]
    );

    Auth::login($user);
    // return redirect('/dashboard');
});

require __DIR__.'/auth.php';
