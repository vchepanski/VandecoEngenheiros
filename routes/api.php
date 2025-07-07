<?php

use App\Http\Controllers\API\V1\ExpenseCategoryController;
use App\Http\Controllers\API\V1\ExpenseController;
use App\Http\Controllers\API\V1\IncomeCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\IncomeController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('incomes', IncomeController::class);
    Route::apiResource('income-categories',  IncomeCategoryController::class);
    Route::apiResource('expense-categories', ExpenseCategoryController::class);
    Route::apiResource('expenses', ExpenseController::class);
});
