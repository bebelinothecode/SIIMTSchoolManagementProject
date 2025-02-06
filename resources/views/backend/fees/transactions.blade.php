@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-700">Transactions List</h1>

    <!-- Date Range Filter Form -->
    <form action="{{route('get.transactions')}}" method="GET" class="flex items-center mt-4 space-x-4">
        <!-- Start Date Picker -->
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

        <!-- End Date Picker -->
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

        <!-- Submit Button -->
        <button 
            type="submit" 
            class="px-4 py-2 m-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
        >
            Filter
        </button>

        <!-- Clear Filter Button -->
        <a 
            href="{{route('get.transactions')}}" 
            class="px-4 py-2 m-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300"
        >
            Clear
        </a>
    </form>

    <!-- Transactions Table -->
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

    <!-- Pagination -->
    <div class="mt-8">
        {{ $transactions->appends(request()->query())->links() }}
    </div>
</div>
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
@endpush