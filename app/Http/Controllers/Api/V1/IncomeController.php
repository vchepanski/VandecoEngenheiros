<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        return response()->json(Income::with('incomeCategory', 'user')->latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'description' => 'nullable|string|max:255',
            'income_category_id' => 'required|exists:income_categories,id',
            'value' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $income = Income::create($validated);

        return response()->json([
            'message' => 'Income created successfully',
            'data' => $income
        ], 201);
    }

    public function show(string $id)
    {

    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
