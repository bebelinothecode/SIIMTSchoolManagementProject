@extends('layouts.app')

@section('title', 'Balance Generated Report')

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
           aria-label="Go back to the previous page"
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

    <h1 class="text-2xl font-bold text-gray-700">Balance Generated Report</h1>

    <!-- Report Parameters -->
    <div class="mt-4 p-6 bg-white rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700">Report Parameters</h2>
        <div class="mt-2 text-sm text-gray-600">
            <p><strong>Selected Category:</strong> {{ $selectedCategory ?? 'N/A' }}</p>
            <p><strong>Report Date:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>

    <!-- Balance Table -->
    <div class="print-section mt-6 bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Currency</th>
                    <th class="py-3 px-6 text-left">Total Professional Collections</th>
                    <th class="py-3 px-6 text-left">Total Professional Expenses</th>
                    <th class="py-3 px-6 text-left">Balance</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                {{-- @forelse($balances as $balance) --}}
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">GHS</td>
                        <td class="py-3 px-6 text-left">{{ number_format($totalCollectionsProfessional, 2) }}</td>
                        <td class="py-3 px-6 text-left">{{ number_format($expensesProfessionalTotal, 2) }}</td>
                        <td class="py-3 px-6 text-left">{{ number_format($totalProfessionalBalance, 2) }}</td>
                    </tr>
                {{-- @empty --}}
                    {{-- <tr>
                        <td colspan="4" class="py-6 px-6 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-lg font-medium">No data available</span>
                            </div>
                        </td>
                    </tr> --}}
                {{-- @endforelse --}}
            </tbody>
        </table>
    </div>

    <!-- Print Button -->
    <div class="mt-8 no-print">
        <button 
            onclick="window.print()" 
            class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
            aria-label="Print this report"
        >
            Print Report
        </button>
    </div>
</div>
@endsection