@extends('layouts.app')

@section('content')

@hasanyrole('Admin|rector|AsstAccount')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-700">Transactions History</h1>

    <!-- Search Form -->
    <form action="{{route('get.transactions')}}" method="GET" class="flex items-center mt-4 space-x-4">
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

    <!-- Combined Transactions Table -->
    <div class="mt-6 bg-white rounded-lg shadow">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Student Name</th>
                    <th class="py-3 px-6 text-left">Transaction Type</th>
                    <th class="py-3 px-6 text-left">Method of Payment</th>
                    <th class="py-3 px-6 text-left">Amount</th>
                    <th class="py-3 px-6 text-left">Balance</th>
                    <th class="py-3 px-6 text-left">Currency</th>
                    <!-- <th class="py-3 px-6 text-left">Cheque Number</th>
                    <th class="py-3 px-6 text-left">Momo Number</th> -->
                    <th class="py-3 px-6 text-left">Date</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($paginator->items() as $transaction)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">{{ $transaction['name'] }}</td>
                    <td class="py-3 px-6 text-left">
                        @if($transaction['type'] == 'regular')
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Regular Payment</span>
                        @elseif($transaction['type'] == 'mature')
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Mature Payment</span>
                        @else
                            <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded">Enquiry Payment</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-left">
                        @if($transaction['type'] == 'regular')
                            {{ $transaction['original_record']->method_of_payment }}
                        @elseif($transaction['type'] == 'mature')
                            {{ $transaction['original_record']->method_of_payment ?? 'Cash' }}
                        @else
                            {{ $transaction['original_record']->method_of_payment ?? 'Form Purchase' }}
                        @endif
                    </td>
                    <td class="py-3 px-6 text-left">
                        @if($transaction['type'] == 'regular')
                            <span class="text-green-600 font-semibold">
                                {{ number_format($transaction['original_record']->amount, 2) }}
                            </span>
                        @elseif($transaction['type'] == 'mature')
                            <span class="text-green-600 font-semibold">
                                {{ number_format($transaction['original_record']->amount_paid, 2) }}
                            </span>
                        @else
                            <span class="text-green-600 font-semibold">
                                {{ number_format($transaction['original_record']->amount, 2) }}
                            </span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-left">
                       @if($transaction['type'] == 'regular' && isset($transaction['original_record']->student))
                          <span class="text-red-600 font-semibold">
                             {{ number_format($transaction['original_record']->student->balance, 2) }}
                          </span>
                       @else
                          <span class="text-gray-400">N/A</span>
                       @endif
                    </td>
                    {{--    <td class="py-3 px-6 text-left">
                        @if($transaction['type'] == 'regular')
                            <span class="text-red-600 font-semibold">
                            {{ number_format($transaction['original_record']->student->balance, 2) }}
                            </span>
                        @else
                            <span class="text-gray-400">N/A</span>
                        @endif
                    </td> --}}
                    <td class="py-3 px-6 text-left">
                        {{ $transaction['original_record']->currency ?? 'Ghana Cedi' }}
                    </td>
                    <!-- <td class="py-3 px-6 text-left">
                        {{ $transaction['original_record']->cheque_number ?? "Not Found" }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $transaction['original_record']->Momo_number ?? $transaction['original_record']->momo_number ?? "Not Found" }}
                    </td> -->
                    <td class="py-3 px-6 text-left">
                        {{ \Carbon\Carbon::parse($transaction['created_at'])->format('Y-m-d') }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        @if($transaction['type'] == 'regular')
                            @role('Admin|rector')
                                <a href="{{route('edit.transactionform', $transaction['original_record']->id)}}" class="ml-4 text-green-600 hover:underline">Edit</a>
                                <a href="{{route('print.transactionreceipt', $transaction['original_record']->id)}}" target="_blank" class="ml-4 text-blue-600 hover:underline">Print</a>
                                <form action="{{route('delete.transaction', $transaction['original_record']->id)}}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-4 text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                                </form>
                            @elserole('AsstAccount')
                                <a href="{{route('print.transactionreceipt', $transaction['original_record']->id)}}" target="_blank" class="ml-4 text-blue-600 hover:underline">Print</a>
                            @endrole
                        @elseif($transaction['type'] == 'mature')
                            @role('Admin|rector')
                                <a href="{{route('mature.receipt', $transaction['original_record']->id)}}" target="_blank" class="ml-4 text-blue-600 hover:underline">Print</a>
                            @elserole('AsstAccount')
                                <a href="{{route('mature.receipt', $transaction['original_record']->id)}}" target="_blank" class="ml-4 text-blue-600 hover:underline">Print</a>
                            @endrole
                        @else
                            {{-- Enquiry payments - you can add specific actions here if needed --}}
                            @role('Admin|rector')
                                <span class="text-gray-400">No actions</span>
                            @endrole
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="py-3 px-6 text-center text-gray-500">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $paginator->appends(request()->query())->links() }}
    </div>
</div>
@endhasanyrole

@endsection

@push('scripts')
<script>
    $(function() {
        // Initialize datepickers (if you decide to add date filtering later)
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
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif
@if (session('error'))
    <script>
        Swal.fire({
            title: 'Oops!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
@endif
@endpush
