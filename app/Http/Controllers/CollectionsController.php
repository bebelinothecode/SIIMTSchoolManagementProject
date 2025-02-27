<?php

namespace App\Http\Controllers;

use App\FeesPaid;
use App\Student;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Foreach_;

class CollectionsController extends Controller
{
    private $data = null;


    public function getAcademicCollectionsForm() {
        if($this->data === null) {
            $this->data = $this->calculationsForCollections();
        }

        $transactionsByCategoryAndCurrency = $this->data['transactions_by_category_and_currency']['academic'];
        $totals_by_category_and_currency =  collect($this->data['totals_by_category_and_currency']['academic']);

        // return collect($transactionsByCategoryAndCurrency);

        return view('backend.collections.academic',compact('transactionsByCategoryAndCurrency','totals_by_category_and_currency'));
    }

    public function getProfessionalCollectionsForm() {
        return view('backend.collections.professional');
    }

    public function calculationsForCollections()
    {
        // Step 1: Get unique student index numbers from the collect_fees table
        $uniqueIndexNumbers = FeesPaid::distinct()->pluck('student_index_number');

        // Step 2: Fetch student categories for the unique index numbers
        $students = Student::whereIn('index_number', $uniqueIndexNumbers)
            ->pluck('student_category', 'index_number');

        // Step 3: Fetch all fee transactions
        $feeTransactions = FeesPaid::whereIn('student_index_number', $uniqueIndexNumbers)->get();

        // Step 4: Group transactions by student category and currency
        $transactionsByCategoryAndCurrency = [
            'academic' => [],
            'professional' => []
        ];

        foreach ($feeTransactions as $transaction) {
            $indexNumber = $transaction->student_index_number;
            $category = strtolower($students[$indexNumber] ?? 'unknown'); // Default to 'unknown' if category not found
            $currency = $transaction->currency;

            if (array_key_exists($category, $transactionsByCategoryAndCurrency)) {
                if (!isset($transactionsByCategoryAndCurrency[$category][$currency])) {
                    $transactionsByCategoryAndCurrency[$category][$currency] = [];
                }
                $transactionsByCategoryAndCurrency[$category][$currency][] = $transaction;
            }
        }

        // Step 5: Calculate totals for each category and currency
        $totalsByCategoryAndCurrency = [
            'academic' => [],
            'professional' => []
        ];

        foreach ($transactionsByCategoryAndCurrency as $category => $currencies) {
            foreach ($currencies as $currency => $transactions) {
                $totalsByCategoryAndCurrency[$category][$currency] = collect($transactions)->sum('amount');
            }
        }

        // Step 6: Prepare the response
        $response = [
            'transactions_by_category_and_currency' => $transactionsByCategoryAndCurrency,
            'totals_by_category_and_currency' => $totalsByCategoryAndCurrency
        ];

        // Return the response as JSON
        // return response()->json($response);
        return $response;
    }

}
