<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomRegisterController;

use Illuminate\Support\Facades\Http;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


use Livewire\Livewire;
use App\Http\Livewire\CustomLogin;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', function () {
    return view('register');  
})->name('register');
Route::get('/register', [CustomRegisterController::class, 'showForm'])->name('register.form');
Route::post('/register', [CustomRegisterController::class, 'register'])->name('register.custom');



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



Route::post('/ask-chatbot', function (Request $request) {
    $request->validate([
        'query' => 'required|string',
    ]);

   
    try {
        $response = Http::timeout(120)->post('http://127.0.0.1:5000/ask', [
            'query' => $request->input('query'),
        ]);
        $answer = $response->json('response') ?? 'famech response';
    } catch (\Exception $e) {
        $answer = '  fama mochkol : ' . $e->getMessage();
    }

    return response()->json([
        'response' => $answer,
    ]);
})->name('ask-chatbot');
