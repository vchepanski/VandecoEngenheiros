<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/access', function (Request $request) {
    if ($request->isMethod('post')) {
        if ($request->input('password') === env('ACCESS_PASSWORD')) {
            session(['access_granted' => true]);
            return redirect()->intended('/');
        }

        return back()->withErrors(['password' => 'Pamonha.']);
    }

    return response()->view('auth.access');
})->name('access');
Route::middleware('protected')->group(function () {
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
});
