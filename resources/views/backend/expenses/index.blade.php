@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-700">Expenses List</h1>

    @hasrole('Admin|rector|AsstAccount')
    <!-- Add Expense Button -->
    <div class="flex flex-wrap items-center mt-4">
        <a href="{{ route('get.expensesForm') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
            <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path>
            </svg>
            <span class="ml-2 text-xs font-semibold">Expense</span>
        </a>
    </div>
    @endhasrole

    <!-- Search Form -->
    <form action="{{ route('expenses.table') }}" method="GET" class="flex items-center mt-4 space-x-4">
        <input 
            type="text" 
            name="search" 
            placeholder="Search Expense" 
            value="{{ request('search') }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
            aria-label="Search Expenses"
        >
        <button 
            type="submit" 
            class="px-4 py-2 m-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
            aria-label="Submit Search"
        >
            Search
        </button>
    </form>

    <!-- Expenses Table -->
    <div class="mt-6 bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    {{-- <th class="py-3 px-6 text-left">Source of Expense</th> --}}
                    <th class="py-3 px-6 text-left">Description</th>
                    <th class="py-3 px-6 text-left">Category</th>
                    <th class="py-3 px-6 text-left">Currency</th>
                    <th class="py-3 px-6 text-left">Amount</th>
                    <th class="py-3 px-6 text-left">Mode of Payment</th>
                    <th class="py-3 px-6 text-left">Cash Amount Details</th>
                    <th class="py-3 px-6 text-left">Bank Details</th>
                    <th class="py-3 px-6 text-left">Cheque Details</th>
                    <th class="py-3 px-6 text-left">Mobile Money Details</th>  
                    @hasanyrole('Admin|rector')
                    <th class="py-3 px-6 text-left">Actions</th>
                    @endhasanyrole             
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($expenses as $expense)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    {{-- <td class="py-3 px-6 text-left whitespace-nowrap">{{ $expense->source_of_expense }}</td> --}}
                    <td class="py-3 px-6 text-left">{{ $expense->description_of_expense }}</td>
                    <td class="py-3 px-6 text-left">{{ $expense->expenseCategory->expense_category ?? $expense->category ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left">{{ $expense->currency }}</td>
                    <td class="py-3 px-6 text-left">{{ $expense->amount }}</td>
                    <td class="py-3 px-6 text-left">{{ $expense->mode_of_payment }}</td>
                    <td class="py-3 px-6 text-left">{{ $expense->cash_details ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left">{{ $expense->bank_details ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left">{{ $expense->cheque_details ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left">{{ $expense->mobile_money_details ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-center">
                            @hasrole('Admin|rector')
                            <a href="{{ route('expense.edit', $expense->id) }}" class="text-blue-600 hover:underline">Edit</a> 
                            <form action="{{ route('expense.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this expense?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-4 text-red-600 hover:underline">Delete</button>
                            </form>
                            @endhasrole
                            {{-- @endhasanyrole --}}
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
                                        title: 'Opps!',
                                        text: '{{ session('error') }}',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                </script>
                            @endif 
                        </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->hasAnyRole(['Admin', 'rector']) ? 11 : 10 }}" class="py-3 px-6 text-center text-gray-500">
                        No expenses found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $expenses->links() }}
    </div>
</div>
@endsection
