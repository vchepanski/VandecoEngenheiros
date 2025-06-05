<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return '<h1>Chama na vozzzzx! 🚀</h1>';
});
Route::get('/test-db', function () {
    return DB::select('SELECT NOW()');
});
