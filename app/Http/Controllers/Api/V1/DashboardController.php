<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function index()
    {
        $totalReceitas = Income::sum('value');
        $totalDespesas = Expense::sum('value');
        $saldo         = $totalReceitas - $totalDespesas;

        $receitasPorUser = Income::with('user')
            ->get()
            ->groupBy(fn($inc) => $inc->user->name)
            ->map(fn($group) => $group->sum('value'));

        $despesasPorUser = Expense::with('user')
            ->get()
            ->groupBy(fn($exp) => $exp->user->name)
            ->map(fn($group) => $group->sum('value'));

        return response()->json([
            'totalReceitas'    => $totalReceitas,
            'totalDespesas'    => $totalDespesas,
            'saldo'            => $saldo,
            'receitasPorUser'  => $receitasPorUser,
            'despesasPorUser'  => $despesasPorUser,
        ]);
    }
}
