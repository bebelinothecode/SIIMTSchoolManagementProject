{{-- @extends('layouts.app')

@section('title', 'Expenses Generated Report')

@section('content')
<style>
    @media print {
        /* Hide everything except the table and logo */
        body * {
            visibility: hidden;
        }
        
        /* Show only the table, logo, and their contents */
        .print-section,
        .print-section *,
        .print-logo {
            visibility: visible;
        }
        
        /* Position the logo at the top of the printed page */
        .print-logo {
            position: absolute;
            top: 0;
            left: 0;
            width: 150px; /* Adjust the width as needed */
            height: auto;
            margin-bottom: 20px; /* Add space below the logo */
        }
        
        /* Position the table below the logo */
        .print-section {
            position: absolute;
            left: 0;
            top: 100px; /* Adjust based on logo height */
            width: 100%;
        }
        
        /* Hide the print button when printing */
        .no-print {
            display: none !important;
        }
        
        /* Ensure table looks good on paper */
        .print-section table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }
        
        .print-section tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        
        .print-section th,
        .print-section td {
            padding: 8px;
            border: 1px solid #ddd;
        }
    }
</style>
<div class="container mx-auto mt-6">
    <!-- Back Button -->
    <div class="mb-4 no-print">
        <a href="{{ url()->previous() }}" 
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back
        </a>
    </div>

    <!-- Logo (Visible only during printing) -->
    <div class="print-logo hidden">
        <img src="{{ asset('public/logo/SIIMT-logo.png') }}" alt="Company Logo" class="w-full h-auto">
    </div>

    <h1 class="text-2xl font-bold text-gray-700">Expenses Generated Report</h1>

    <!-- Report Parameters -->
    <div class="mt-4 p-6 bg-white rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700">Report Parameters</h2>
        <div class="mt-2 text-sm text-gray-600">
            <p><strong>Range:</strong> {{ $startDate ?? 'N/A' }}-{{$endDate ?? 'N/A'}}</p>
            <p><strong>Current Date:</strong> {{ $currentDate ?? 'N/A' }}</p>
            <p><strong>Category:</strong> {{ $category ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Students Table -->
    <div class="print-section mt-6 bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Source of Expense</th>
                    <th class="py-3 px-6 text-left">Description of Expense</th>
                    <th class="py-3 px-6 text-left">Category</th>
                    <th class="py-3 px-6 text-left">Currency</th>
                    <th class="py-3 px-6 text-left">Amount</th>
                    <th class="py-3 px-6 text-left">Mode of Payment</th>
                    <th class="py-3 px-6 text-left">Created on</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($expenses as $expense)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $expense->source_of_expense }}</td>
                        <td class="py-3 px-6 text-left">{{ $expense->description_of_expense }}</td>
                        <td class="py-3 px-6 text-left">{{ $expense->category }}</td>
                        <td class="py-3 px-6 text-left">{{ $expense->currency }}</td>
                        <td class="py-3 px-6 text-left">{{ $expense->amount }}</td>
                        <td class="py-3 px-6 text-left">{{ $expense->mode_of_payment }}</td>
                        <td class="py-3 px-6 text-left">{{ $expense->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 px-6 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-lg font-medium">No expenses found for the selected criteria.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Print Button -->
    <div class="mt-8 no-print">
        <button 
            onclick="window.print()" 
            class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
        >
            Print Report
        </button>
    </div>
</div>
@endsection --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Report</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-height: 80px;
        }
        .report-title {
            color: #007bff;
            text-align: center;
            margin-bottom: 5px;
        }
        .report-date {
            text-align: center;
            color: #6c757d;
            margin-bottom: 20px;
        }
        .filters-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .section-title {
            color: #007bff;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        .table {
            font-size: 14px;
        }
        .table thead {
            background-color: #007bff;
            color: white;
        }
        .total-highlight {
            font-weight: bold;
            background-color: #e9f7fe;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }
        .category-title {
            background-color: #e9ecef;
            padding: 8px 15px;
            border-radius: 4px;
            margin-top: 25px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-4 mb-5">
        <!-- Header with Logo -->
        <div class="header">
            <div class="logo-container">
                <img src="resources/views/backend/fees/siimtlogo.jpeg" alt="Institution Logo" class="logo">
            </div>
            <h1 class="report-title">EXPENSES REPORT</h1>
            <div class="report-date">
                <i class="far fa-calendar-alt"></i> Generated on: {{ \Carbon\Carbon::now()->format('F j, Y h:i A') }}
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <h4><i class="fas fa-filter"></i> Filters Applied</h4>
            <div class="row">
                @if ($currentDate)
                    <div class="col-md-3">
                        <strong>Current Date:</strong><br>
                        <span class="badge badge-primary">{{ \Carbon\Carbon::parse($currentDate)->format('M j, Y') }}</span>
                    </div>
                @endif
                @if ($startDate)
                    <div class="col-md-3">
                        <strong>Start Date:</strong><br>
                        <span class="badge badge-info">{{ \Carbon\Carbon::parse($startDate)->format('M j, Y') }}</span>
                    </div>
                @endif
                @if ($endDate)
                    <div class="col-md-3">
                        <strong>End Date:</strong><br>
                        <span class="badge badge-info">{{ \Carbon\Carbon::parse($endDate)->format('M j, Y') }}</span>
                    </div>
                @endif
                @if ($category)
                    <div class="col-md-3">
                        <strong>Category:</strong><br>
                        <span class="badge badge-success">{{ $category }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Payment Method Summary -->
        <h4 class="section-title"><i class="fas fa-money-bill-wave"></i> Payment Method Summary</h4>
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Mobile Money</h5>
                        <p class="card-text display-4">GHS{{ number_format($sumMomoTransactions,2) ?? "0.00" }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Cash</h5>
                        <p class="card-text display-5">GHS{{ number_format($sumCashTransactions, 2) ?? "0.00" }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Cheque</h5>
                        <p class="card-text display-4">{{ number_format($sumBankTransactions,2) ?? "0.00" }}</p>
                    </div>
                </div>
            </div>
        </div>

         <!-- Detailed Transactions -->
         <h4 class="section-title"><i class="fas fa-list-ul"></i> Detailed Cash Expenses</h4>
                 <div class="table-responsive">
                     <table class="table table-sm table-hover">
                         <thead class="thead-dark">
                             <tr>
                                 <th>Source of Expense</th>
                                 <th>Description of Expense</th>
                                 <th>Category</th>
                                 <th>Currency</th>
                                 <th>Amount</th>
                                 <th>Mode of Payment</th>
                                 <th>Mobile Money Details</th>
                                 <th>Cash Details</th>
                                 <th>Bank Details</th>
                                 <th>Cheque Details</th>
                                 <th>Date</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($cashTransactions as $cashTransaction)
                                 <tr>
                                     <td>{{ $cashTransaction->source_of_expense }}</td>
                                     <td>{{ $cashTransaction->description_of_expense }}</td>
                                     <td>{{ $cashTransaction->category }}</td>
                                     <td>{{ $cashTransaction->currency }}</td>
                                     <td>{{ $cashTransaction->amount }}</td>
                                     <td>{{ $cashTransaction->mode_of_payment }}</td>
                                     <td>{{ $cashTransaction->mobile_money_details }}</td>
                                     <td>{{ $cashTransaction->cash_details }}</td>
                                     <td>{{ $cashTransaction->bank_details }}</td>
                                     <td>{{ $cashTransaction->cheque_details }}</td>
                                     <td>{{ $cashTransaction->created_at }}</td>
                                 </tr>
                             @endforeach
                         </tbody>
                     </table>
                 </div>

                 <h4 class="section-title"><i class="fas fa-list-ul"></i> Detailed Mobile Money Expenses</h4>
                 <div class="table-responsive">
                     <table class="table table-sm table-hover">
                         <thead class="thead-dark">
                             <tr>
                                 <th>Source of Expense</th>
                                 <th>Description of Expense</th>
                                 <th>Category</th>
                                 <th>Currency</th>
                                 <th>Amount</th>
                                 <th>Mode of Payment</th>
                                 <th>Mobile Money Details</th>
                                 <th>Cash Details</th>
                                 <th>Bank Details</th>
                                 <th>Cheque Details</th>
                                 <th>Date</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($momoTransactions as $momoTransaction)
                                 <tr>
                                     <td>{{ $momoTransaction->source_of_expense }}</td>
                                     <td>{{ $momoTransaction->description_of_expense }}</td>
                                     <td>{{ $momoTransaction->category }}</td>
                                     <td>{{ $momoTransaction->currency }}</td>
                                     <td>{{ $momoTransaction->amount }}</td>
                                     <td>{{ $momoTransaction->mode_of_payment }}</td>
                                     <td>{{ $momoTransaction->mobile_money_details }}</td>
                                     <td>{{ $momoTransaction->cash_details }}</td>
                                     <td>{{ $momoTransaction->bank_details }}</td>
                                     <td>{{ $momoTransaction->cheque_details }}</td>
                                     <td>{{ $momoTransaction->created_at }}</td>
                                 </tr>
                             @endforeach
                         </tbody>
                     </table>
                 </div>

                 <h4 class="section-title"><i class="fas fa-list-ul"></i> Detailed Bank Expenses</h4>
                 <div class="table-responsive">
                     <table class="table table-sm table-hover">
                         <thead class="thead-dark">
                             <tr>
                                 <th>Source of Expense</th>
                                 <th>Description of Expense</th>
                                 <th>Category</th>
                                 <th>Currency</th>
                                 <th>Amount</th>
                                 <th>Mode of Payment</th>
                                 <th>Mobile Money Details</th>
                                 <th>Cash Details</th>
                                 <th>Bank Details</th>
                                 <th>Cheque Details</th>
                                 <th>Date</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($bankTransactions as $bankTransaction)
                                 <tr>
                                     <td>{{ $bankTransaction->source_of_expense }}</td>
                                     <td>{{ $bankTransaction->description_of_expense }}</td>
                                     <td>{{ $bankTransaction->category }}</td>
                                     <td>{{ $bankTransaction->currency }}</td>
                                     <td>{{ $bankTransaction->amount }}</td>
                                     <td>{{ $bankTransaction->mode_of_payment }}</td>
                                     <td>{{ $bankTransaction->mobile_money_details }}</td>
                                     <td>{{ $bankTransaction->cash_details }}</td>
                                     <td>{{ $bankTransaction->bank_details }}</td>
                                     <td>{{ $bankTransaction->cheque_details }}</td>
                                     <td>{{ $bankTransaction->created_at }}</td>
                                 </tr>
                             @endforeach
                         </tbody>
                     </table>
                 </div>

                 <h4 class="section-title"><i class="fas fa-list-ul"></i> Detailed {{$category}} Expenses</h4>
                 <div class="table-responsive">
                     <table class="table table-sm table-hover">
                         <thead class="thead-dark">
                             <tr>
                                 <th>Source of Expense</th>
                                 <th>Description of Expense</th>
                                 <th>Category</th>
                                 <th>Currency</th>
                                 <th>Amount</th>
                                 <th>Mode of Payment</th>
                                 <th>Mobile Money Details</th>
                                 <th>Cash Details</th>
                                 <th>Bank Details</th>
                                 <th>Cheque Details</th>
                                 <th>Date</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($expenses as $expense)
                                 <tr>
                                     <td>{{ $expense->source_of_expense }}</td>
                                     <td>{{ $expense->description_of_expense }}</td>
                                     <td>{{ $expense->category }}</td>
                                     <td>{{ $expense->currency }}</td>
                                     <td>{{ $expense->amount }}</td>
                                     <td>{{ $expense->mode_of_payment }}</td>
                                     <td>{{ $expense->mobile_money_details }}</td>
                                     <td>{{ $expense->cash_details }}</td>
                                     <td>{{ $expense->bank_details }}</td>
                                     <td>{{ $expense->cheque_details }}</td>
                                     <td>{{ $expense->created_at }}</td>
                                 </tr>
                             @endforeach
                         </tbody>
                     </table>
                 </div>

        <!-- Footer -->
        <div class="footer">
            <p>This report was automatically generated by the University Financial System</p>
            <p><i class="far fa-copyright"></i> {{ date('Y') }} - All Rights Reserved</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>