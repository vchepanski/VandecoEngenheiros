<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubtaskController;


Route::match(['get', 'post'], '/access', function (Request $request) {
    if ($request->isMethod('post')) {
        if ($request->input('password') === 'Dev-Vanderlei@123') {
            session(['access_granted' => true]);
            return redirect()->intended('/tasks');
        }

        return back()->withErrors(['password' => 'Senha incorreta.']);
    }

    return response()->view('auth.access');
})->name('access');
Route::middleware('protected')->group(function () {
Route::resource('usuarios', UserController::class);
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

Route::post('/tasks/{task}/subtasks', [SubtaskController::class, 'store'])->name('subtasks.store');
Route::put('/subtasks/{subtask}', [SubtaskController::class, 'update'])->name('subtasks.update');
Route::delete('/subtasks/{subtask}', [SubtaskController::class, 'destroy'])->name('subtasks.destroy');
});
