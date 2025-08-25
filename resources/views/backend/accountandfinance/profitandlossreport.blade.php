@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-lg">

    <!-- Report Header -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold uppercase">Profit & Loss Report</h2>
        <p class="text-sm text-gray-600">
            Branch: <strong>{{ $branch }}</strong>
        </p>
        <p class="text-sm text-gray-600">
            Period: {{ $startDate ?? $currentDate }}
            @if($endDate) - {{ $endDate }} @endif
        </p>
        <p class="text-sm text-gray-600">
            Report Generated: {{ \Carbon\Carbon::now()->toFormattedDateString() }}
        </p>
    </div>

    <!-- ================= INCOME ================= -->
    <h3 class="text-xl font-semibold mb-4 text-green-700">Income(Academic)</h3>
    <div class="space-y-4">
        @foreach($incomes as $income)
            <div x-data="{ open: false }" class="border rounded-md shadow-sm">
                <button @click="open = !open" class="w-full flex justify-between items-center p-3 bg-green-100 hover:bg-green-200">
                    <span class="font-medium">{{ $income->course_name }}</span>
                    <span class="font-bold">{{ number_format($income->total_income, 2) }}</span>
                </button>

                <div x-show="open" class="p-4 bg-gray-50">
                    <table class="w-full text-sm border">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2 text-left">Transaction ID</th>
                                <th class="p-2 text-left">Index Number</th>
                                <th class="p-2 text-left">Branch</th>
                                <th class="p-2 text-right">Amount</th>
                                <th class="p-2 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($incomeTransactions[$income->id] ?? [] as $txn)
                                <tr class="border-t">
                                    <td class="p-2">{{ $txn->id }}</td>
                                    <td class="p-2">{{ $txn->student_index_number }}</td>
                                    <td class="p-2">{{ $txn->branch }}</td>
                                    <td class="p-2 text-right">{{ number_format($txn->amount, 2) }}</td>
                                    <td class="p-2">{{ \Carbon\Carbon::parse($txn->created_at)->toFormattedDateString() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>

    <h3 class="text-xl font-semibold mb-4 text-green-700">Income(Professional)</h3>
    <div class="space-y-4">
        @foreach($incomesProfs as $incomesProf)
            <div x-data="{ open: false }" class="border rounded-md shadow-sm">
                <button @click="open = !open" class="w-full flex justify-between items-center p-3 bg-green-100 hover:bg-green-200">
                    <span class="font-medium">{{ $incomesProf->name }}</span>
                    <span class="font-bold">{{ number_format($incomesProf->total_income, 2) }}</span>
                </button>

                <div x-show="open" class="p-4 bg-gray-50">
                    <table class="w-full text-sm border">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2 text-left">Transaction ID</th>
                                <th class="p-2 text-left">Index Number</th>
                                <th class="p-2 text-left">Branch</th>
                                <th class="p-2 text-right">Amount</th>
                                <th class="p-2 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($incomeProfTransactions[$incomesProf->id] ?? [] as $txn)
                                <tr class="border-t">
                                    <td class="p-2">{{ $txn->id }}</td>
                                    <td class="p-2">{{ $txn->student_index_number }}</td>
                                    <td class="p-2">{{ $txn->branch }}</td>
                                    <td class="p-2 text-right">{{ number_format($txn->amount, 2) }}</td>
                                    <td class="p-2">{{ \Carbon\Carbon::parse($txn->created_at)->toFormattedDateString() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>

    <!-- ================= EXPENSES ================= -->
    <h3 class="text-xl font-semibold mt-8 mb-4 text-red-700">Expenses</h3>
    <div class="space-y-4">
        @foreach($expenses as $expense)
            <div x-data="{ open: false }" class="border rounded-md shadow-sm">
                <button @click="open = !open" class="w-full flex justify-between items-center p-3 bg-red-100 hover:bg-red-200">
                    <span class="font-medium">{{ $expense->expense_category }}</span>
                    <span class="font-bold">{{ number_format($expense->total_expense, 2) }}</span>
                </button>

                <div x-show="open" class="p-4 bg-gray-50">
                    <table class="w-full text-sm border">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2 text-left">Expense ID</th>
                                <th class="p-2 text-left">Description</th>
                                <th class="p-2 text-left">Branch</th>
                                <th class="p-2 text-right">Amount</th>
                                <th class="p-2 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenseTransactions[$expense->id] ?? [] as $txn)
                                <tr class="border-t">
                                    <td class="p-2">{{ $txn->id }}</td>
                                    <td class="p-2">{{ $txn->description ?? '-' }}</td>
                                    <td class="p-2">{{ $txn->branch }}</td>
                                    <td class="p-2 text-right">{{ number_format($txn->amount, 2) }}</td>
                                    <td class="p-2">{{ \Carbon\Carbon::parse($txn->created_at)->toFormattedDateString() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>

    <!-- ================= TOTALS ================= -->
    <div class="mt-8 p-4 border-t">
        <p><strong>Total Income:</strong> {{ number_format($totalIncome, 2) }}</p>
        <p><strong>Total Expenses:</strong> {{ number_format($totalExpenses, 2) }}</p>
        <p class="text-lg font-bold {{ $profit >= 0 ? 'text-green-600' : 'text-red-600' }}">
            Profit: {{ number_format($profit, 2) }}
        </p>
    </div>

</div>

<!-- Alpine.js for collapsibles -->
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
