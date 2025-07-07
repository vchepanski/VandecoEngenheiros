<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{

    public function index()
    {
        return ExpenseCategory::with('children')
                            ->whereNull('parent_id')
                            ->get();
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:expense_categories,name',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:expense_categories,id',
            'recurring'   => 'boolean',
        ]);

        $category = ExpenseCategory::create($data);

        return response()->json($category, 201);
    }

    public function show(ExpenseCategory $expenseCategory)
    {
        return $expenseCategory->load('parent', 'children');
    }
    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:expense_categories,name,'.$expenseCategory->id,
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:expense_categories,id',
        ]);

        $expenseCategory->update($data);

        return response()->json($expenseCategory);
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();
        return response()->noContent();
    }
}
