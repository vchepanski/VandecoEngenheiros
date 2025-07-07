<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/access', function (Request $request) {
    if ($request->isMethod('post')) {
        if ($request->input('password') === 'Dev-Vanderlei@123') {
            session(['access_granted' => true]);
            return redirect()->intended('/');
        }

        return back()->withErrors(['password' => 'Senha incorreta.']);
    }

    return response()->view('auth.access');
})->name('access');
Route::middleware('protected')->group(function () {
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
});
