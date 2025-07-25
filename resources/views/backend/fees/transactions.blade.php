@extends('layouts.app')

@section('content')

@hasanyrole('Admin|rector|AsstAccount')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-700">Transactions History</h1>

    <!-- Date Range Filter Form -->
    <form action="{{route('get.transactions')}}" method="GET" class="flex items-center mt-4 space-x-4">
        <!-- Start Date Picker -->

        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    id="search"
                    placeholder="Search by name, email or index number" 
                    value="{{ request('search') }}"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                >
                <script>
                    document.getElementById('search').addEventListener('input', function(e) {
                        this.value = this.value.toUpperCase();
                    })
                </script>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                    Search
                </button>
            </div>
        </div>
        
    </form>

    <!-- Transactions Table -->
    <div class="mt-6 bg-white rounded-lg shadow">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Student Name</th>
                    <th class="py-3 px-6 text-left">Method of Payment</th>
                    <th class="py-3 px-6 text-left">Amount</th>
                    <th class="py-3 px-6 text-left">Balance</th>
                    <th class="py-3 px-6 text-left">Currency</th>
                    <th class="py-3 px-6 text-left">Cheque Number</th>
                    <th class="py-3 px-6 text-left">Momo Number</th>
                    <th class="py-3 px-6 text-left">Date</th>
                    <th class="py-3 px-6 text-left">Actions</th>

                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($transactions as $transaction)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">{{ $transaction->student_name }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->method_of_payment }}</td>
                    <td class="py-3 px-6 text-left">{{ number_format($transaction->amount, 2) }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->balance }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->currency }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->cheque_number ?? "Not Found" }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->Momo_number ?? "Not Found" }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->created_at->format('Y-m-d') }}</td>
                    <td class="py-3 px-6 text-center">
                        @role('Admin|rector')
                            <a href="{{route('edit.transactionform',$transaction->id)}}" class="ml-4 text-green-600 hover:underline">Edit</a>
                            <a href="{{route('print.transactionreceipt',$transaction->id)}}" target="_blank" class="ml-4 text-blue-600 hover:underline">Print</a>
                            <form action="{{route('delete.transaction',$transaction->id)}}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ml-4 text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                            </form>
                        @elserole('AsstAccount')
                            <a href="{{route('print.transactionreceipt',$transaction->id)}}" target="_blank" class="ml-4 text-blue-600 hover:underline">Print</a>
                        @endrole
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-3 px-6 text-center text-gray-500">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $transactions->appends(request()->query())->links() }}
    </div>
</div>
@endhasanyrole

<!-- @hasrole('AsstAccount')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-700">Transactions List</h1>

    <form action="{{route('get.transactions')}}" method="GET" class="flex items-center mt-4 space-x-4">
        <div class="relative">
            <input 
                type="text" 
                name="start_date" 
                id="start_date" 
                placeholder="Start Date" 
                value="{{ request('start_date') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                autocomplete="off"
            >
            @error('start_date')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="relative">
            <input 
                type="text" 
                name="end_date" 
                id="end_date" 
                placeholder="End Date" 
                value="{{ request('end_date') }}"
                class="w-full px-4 py-2 m-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                autocomplete="off"
            >
            @error('end_date')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button 
            type="submit" 
            class="px-4 py-2 m-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
        >
            Filter
        </button>

        <a 
            href="{{route('get.transactions')}}" 
            class="px-4 py-2 m-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300"
        >
            Clear
        </a>
    </form>

    <div class="mt-6 bg-white rounded-lg shadow">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-1 px-3 text-left">Transaction ID</th>
                    <th class="py-3 px-6 text-left">Student Name</th>
                    <th class="py-3 px-6 text-left">Method of Payment</th>
                    <th class="py-3 px-6 text-left">Amount</th>
                    <th class="py-3 px-6 text-left">Balance</th>
                    <th class="py-3 px-6 text-left">Currency</th>
                    <th class="py-3 px-6 text-left">Cheque Number</th>
                    <th class="py-3 px-6 text-left">Momo Number</th>
                    <th class="py-3 px-6 text-left">Date</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($transactions as $transaction)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-1 px-3 text-left">{{ $transaction->id }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->student_name }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->method_of_payment }}</td>
                    <td class="py-3 px-6 text-left">{{ number_format($transaction->amount, 2) }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->balance }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->currency }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->cheque_number ?? "Not Found" }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->Momo_number ?? "Not Found" }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->created_at->format('Y-m-d') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-3 px-6 text-center text-gray-500">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $transactions->appends(request()->query())->links() }}
    </div>
</div>
@endhasrole -->
@endsection

@push('scripts')
<script>
    $(function() {
        // Initialize datepickers
        $('#start_date').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0"
        });

        $('#end_date').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0"
        });
    });
</script>
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
            title: 'Oops!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
@endif
@endpush
