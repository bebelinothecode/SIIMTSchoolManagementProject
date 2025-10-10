{{-- filepath: resources/views/backend/inventory/transactionlist.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-700 mb-4">Stock Transactions for: {{ $stock->stock_name }}</h1>
    <div class="mb-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center bg-gray-200 text-gray-700 px-3 py-1 rounded hover:bg-gray-300">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <div class="bg-white rounded shadow p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Stock Details</h2>
        <p><strong>Description:</strong> {{ $stock->description ?? 'N/A' }}</p>
        <p><strong>Current Quantity:</strong> {{ $stock->quantity }}</p>
        <p><strong>Location:</strong> {{ $stock->location ?? 'N/A' }}</p>
        <p><strong>Unit of Measure:</strong> {{ $stock->unit_of_measure ?? 'N/A' }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Stock Ins --}}
        <div>
            <h2 class="text-lg font-semibold text-green-700 mb-2">Stock In Transactions</h2>
            @if($stock->stockIns && $stock->stockIns->count())
                <div class="overflow-x-auto">
                    <table class="w-full table-auto bg-green-50 rounded">
                        <thead>
                            <tr class="bg-green-100 text-green-800">
                                <th class="py-2 px-3 text-left">Date In</th>
                                <th class="py-2 px-3 text-left">New Qty</th>
                                <th class="py-2 px-3 text-left">Old Qty</th>
                                <th class="py-2 px-3 text-left">Total After In</th>
                                <th class="py-2 px-3 text-left">Unit Price</th>
                                <th class="py-2 px-3 text-left">Supplier</th>
                                <th class="py-2 px-3 text-left">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stock->stockIns as $in)
                                <tr>
                                    <td class="py-2 px-3">{{ \Carbon\Carbon::parse($in->date_in)->format('M d, Y') }}</td>
                                    <td class="py-2 px-3">{{ $in->new_stock_in_quantity }}</td>
                                    <td class="py-2 px-3">{{ $in->old_stock_in_quantity }}</td>
                                    <td class="py-2 px-3">{{ $in->total_stock_after_in }}</td>
                                    <td class="py-2 px-3">{{ $in->unit_price ?? '-' }}</td>
                                    <td class="py-2 px-3">{{ $in->suppliers_info ?? '-' }}</td>
                                    <td class="py-2 px-3">{{ $in->remarks ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">No stock in transactions found.</p>
            @endif
        </div>

        {{-- Stock Outs --}}
        <div>
            <h2 class="text-lg font-semibold text-red-700 mb-2">Stock Out Transactions</h2>
            @if($stock->stockOuts && $stock->stockOuts->count())
                <div class="overflow-x-auto">
                    <table class="w-full table-auto bg-red-50 rounded">
                        <thead>
                            <tr class="bg-red-100 text-red-800">
                                <th class="py-2 px-3 text-left">Date Issued</th>
                                <th class="py-2 px-3 text-left">Issued Qty</th>
                                <th class="py-2 px-3 text-left">Initial Qty</th>
                                <th class="py-2 px-3 text-left">Remaining Qty</th>
                                <th class="py-2 px-3 text-left">Recipient</th>
                                <th class="py-2 px-3 text-left">Issued By</th>
                                <th class="py-2 px-3 text-left">Date Returned</th>
                                <th class="py-2 px-3 text-left">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stock->stockOuts as $out)
                                <tr>
                                    <td class="py-2 px-3">{{ \Carbon\Carbon::parse($out->date_issued)->format('M d, Y') }}</td>
                                    <td class="py-2 px-3">{{ $out->quantity_issued }}</td>
                                    <td class="py-2 px-3">{{ $out->initial_quantity }}</td>
                                    <td class="py-2 px-3">{{ $out->remaining_quantity }}</td>
                                    <td class="py-2 px-3">{{ $out->issued_to }}</td>
                                    <td class="py-2 px-3">{{ $out->issued_by }}</td>
                                    <td class="py-2 px-3">{{ $out->date_returned ? \Carbon\Carbon::parse($out->date_returned)->format('M d, Y') : '-' }}</td>
                                    <td class="py-2 px-3">{{ $out->notes ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">No stock out transactions found.</p>
            @endif
        </div>
    </div>
</div>
@endsection