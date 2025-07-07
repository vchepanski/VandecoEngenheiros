<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        return Expense::with('expenseCategory','user')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'             => 'required|exists:users,id',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'value'               => 'required|numeric|min:0',
            'date'                => 'required|date',
            'description'         => 'nullable|string',
        ]);

        $expense = Expense::create($data);

        return response()->json($expense, 201);
    }

    public function show(Expense $expense)
    {
        return $expense->load('expenseCategory','user');
    }

    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'user_id'             => 'required|exists:users,id',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'value'               => 'required|numeric|min:0',
            'date'                => 'required|date',
            'description'         => 'nullable|string',
        ]);

        $expense->update($data);

        return response()->json($expense);
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return response()->noContent();
    }
}
