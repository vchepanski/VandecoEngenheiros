<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request){
        $query = Expense::with('expenseCategory', 'user');

        if ($request->filled('mes')) {
            $mes = $request->mes;
            $query->whereYear('created_at', substr($mes, 0, 4))
                ->whereMonth('created_at', substr($mes, 5, 2));
        }

        $sort = $request->get('sort', 'created_at');
        $dir  = $request->get('direction', 'desc');
        $query->orderBy($sort, $dir);

        $perPage = $request->get('per_page', 20);
        return $query->paginate($perPage);
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
