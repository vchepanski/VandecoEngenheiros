<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\IncomeCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IncomeCategoryController extends Controller
{
    public function index()
    {
        return IncomeCategory::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:20',
        ]);

        $category = IncomeCategory::create($data);

        return response()->json(['message' => 'Category created!', 'category' => $category]);
    }

    public function update(Request $request, IncomeCategory $incomeCategory){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:20',
    ]);

    $incomeCategory->update($validated);

    return response()->json(['message' => 'Category updated']);
    }

    public function destroy($id)
    {
        $category = IncomeCategory::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }
}
