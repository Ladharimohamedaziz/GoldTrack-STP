<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomRegisterController;

use Illuminate\Support\Facades\Http;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


use Livewire\Livewire;
use App\Http\Livewire\CustomLogin;
use App\Http\Controllers\Auth\RegisterController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', function () {
    return view('register');  
})->name('register');
Route::get('/register', [CustomRegisterController::class, 'showForm'])->name('register.form');
Route::post('/register', [CustomRegisterController::class, 'register'])->name('register.custom');
// Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
// Route::post('/register', [RegisterController::class, 'register'])->name('register.custom');



Route::get('/login', fn() => view('auth.login'))->name('login');


Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin');
    }

    return back()->withErrors(['email' => 'The provided credentials do not match our records.'])
                 ->onlyInput('email');
});


Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

