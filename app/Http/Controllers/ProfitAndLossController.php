<?php

namespace App\Http\Controllers;

use App\FeesPaid;
use Illuminate\Http\Request;

class ProfitAndLossController extends Controller
{
    public function index() {
        return view('backend.accountandfinance.profitandloss');
    }

    public function generateProfitAndLossReport(Request $request) {
        // dd($request->all());
        $validatedData = $request->validate([
            'current_date' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $currentDate = $validatedData['current_date'];
        $startDate = $validatedData['start_date'];
        $endDate = $validatedData['end_date'];

        $queryIncome = FeesPaid::query();

        if($currentDate) {

        }

        return $validatedData;

    }
    //
}
