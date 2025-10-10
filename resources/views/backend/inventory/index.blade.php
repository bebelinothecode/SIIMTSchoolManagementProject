@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-700">Inventory</h1>

    <div class="flex justify-between items-center mt-6">
        <a href="{{ route('addstock.form') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
            <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
            <span class="ml-2 text-xs font-semibold">Add Stock Item</span>
        </a>

         <a href="{{ route('generate.stockpurchaseslip') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
            <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
            <span class="ml-2 text-xs font-semibold">Generate Stock Purchase Slip</span>
        </a>
    </div>

    <form action="{{ route('view.inventory') }}" method="GET" class="flex items-center mt-4 space-x-4">
        <input 
            type="text" 
            name="search" 
            placeholder="Search..." 
            value="{{ request('search') }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
        >
        <button 
            type="submit" 
            class="px-4 py-2 m-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
        >
            Search
        </button>
    </form>

    <!-- Low Stock Alert -->
    @php
        $lowStockItems = $stocks->filter(function($stock) {
            return $stock->quantity < 10;
        });
    @endphp
    @if($lowStockItems->count() > 0)
        <div class="mt-6 mb-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Low Stock Alert!</strong>
                <span class="block">The following items have less than 10 in stock:</span>
                <ul class="list-disc pl-6">
                    @foreach($lowStockItems as $item)
                        <li>{{ $item->stock_name }} ({{ $item->quantity }} left)</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Inventory Table -->
    <div class="mt-6 bg-white rounded-lg shadow">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Quantity</th>
                    <th class="py-3 px-6 text-left">Description</th>
                    <th class="py-3 px-6 text-left">Location</th>
                    <th class="py-3 px-6 text-left">Unit of measure</th>
                    <th class="py-3 px-6 text-left">Created At</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($stocks as $stock)
                <tr class="hover:bg-gray-50 transition-colors @if($stock->quantity < 10) bg-red-50 @endif">
                    <td class="border border-gray-200 px-4 py-2">{{ $stock->stock_name }}</td>
                    <td class="border border-gray-200 px-4 py-2">
                        {{ $stock->quantity }}
                        @if($stock->quantity < 10)
                            <span class="ml-2 text-xs text-red-600 font-semibold">(Low!)</span>
                        @endif
                    </td>
                    <td class="border border-gray-200 px-4 py-2">{{ $stock->description }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $stock->location }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $stock->unit_of_measure }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ \Carbon\Carbon::parse($stock->created_at)->format('M d, Y H:i A')  ?? "N/A"}}</td>
                    <td class="border border-gray-200 px-4 py-2">
                        <a href="{{ route('edit.stockitemform', $stock->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                        <a href="{{ route('stockin.form', $stock->id) }}" class="text-blue-600 hover:underline mr-2">Stock In</a>
                        <a href="{{ route('stockout.form', $stock->id) }}" class="text-blue-600 hover:underline mr-2">Stock Out</a>
                        <form action="{{ route('delete.stockitem', $stock->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this stock item?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                        <a href="{{ route('stock.transactionlist',$stock->id) }}" class="text-green-600 hover:underline mr-2">Transactions</a>
                    </td>
                </tr>
                @endforeach

                @if ($stocks->isEmpty())
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">No stock found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif 
    
    @if (session('error'))
        <script>
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif   

    <!-- Pagination -->
    <div class="mt-4">
        {{ $stocks->appends(request()->query())->links() }}
    </div> 
</div>
@endsection