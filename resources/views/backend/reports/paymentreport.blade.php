@extends('layouts.app')

@section('title', 'Payments Generated Report')

@section('content')
<style>
    @media print {
        /* Hide everything except the table */
        body * {
            visibility: hidden;
        }
        
        /* Show only the table and its contents */
        .print-section,
        .print-section * {
            visibility: visible;
        }
        
        /* Position the table at the top of the printed page */
        .print-section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            text-align: center;
        }

        .print-section .logo-title {
            margin-bottom: 20px;
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

    <h1 class="text-2xl font-bold text-gray-700">Payments Generated Report</h1>

    <!-- Report Parameters -->
    <div class="mt-4 p-6 bg-white rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700">Report Parameters</h2>
        <div class="mt-2 text-sm text-gray-600">
            <p><strong>Current Date:</strong> {{ $currentDate ?? 'N/A' }}</p>
            <p><strong>Start Date:</strong> {{ $startDate ?? 'N/A' }}</p>
            <p><strong>End Date:</strong> {{ $endDate ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Students Table -->
    <div class="print-section mt-6 bg-white rounded-lg shadow overflow-x-auto">
        <div class="logo-title">
            <img src="public/logo/SIIMT-logo.png" alt="Logo" style="max-height: 100px;">
            <h2 class="text-2xl font-bold">School Payments Report</h2>
        </div>
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Student Index Number</th>
                    <th class="py-3 px-6 text-left">Student Name</th>
                    <th class="py-3 px-6 text-left">Method of Payment</th>
                    <th class="py-3 px-6 text-left">Amount Paid</th>
                    <th class="py-3 px-6 text-left">Balance</th>
                    <th class="py-3 px-6 text-left">Currency</th>
                    <th class="py-3 px-6 text-left">Cheque Number</th>
                    <th class="py-3 px-6 text-left">Momo Number</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($payments as $payment)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $payment->id }}</td>
                        <td class="py-3 px-6 text-left">{{ $payment->student_index_number }}</td>
                        <td class="py-3 px-6 text-left">{{ $payment->student_name }}</td>
                        <td class="py-3 px-6 text-left">{{ $payment->method_of_payment }}</td>
                        <td class="py-3 px-6 text-left">{{ $payment->amount }}</td>
                        <td class="py-3 px-6 text-left">{{ $payment->balance }}</td>
                        <td class="py-3 px-6 text-left">{{ $payment->currency }}</td>
                        <td class="py-3 px-6 text-left">{{ $payment->cheque_number ?? "N/A" }}</td>
                        <td class="py-3 px-6 text-left">{{ $payment->Momo_number ?? "N/A" }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="py-6 px-6 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-lg font-medium">No payments found for the selected criteria.</span>
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
@endsection
