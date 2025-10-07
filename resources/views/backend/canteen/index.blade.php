@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-700">Canteen</h1>

    <div class="flex justify-between items-center mt-6">
        <a href="{{ route('canteen.createform') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
            <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
            <span class="ml-2 text-xs font-semibold">Add Canteen Transaction</span>
        </a>

        <!-- Sorting Dropdown -->
        <form action=" " method="GET" class="flex items-center">
            <label for="sort" class="text-sm text-gray-600 mr-2">Sort by:</label>
            <select name="sort" id="sort" onchange="this.form.submit()" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 rounded">
                <option value="">All</option>
                <option value="Expense" {{ request('sort') === 'Expense' ? 'selected' : '' }}>Expense</option>
                <option value="Income" {{ request('sort') === 'Income' ? 'selected' : '' }}>Income</option>
            </select>
        </form>
    </div>

    <form action="" method="GET" class="flex items-center mt-4 space-x-4">
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

    
    <!-- Enquiry Table -->
    <div class="mt-6 bg-white rounded-lg shadow">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Item Name</th>
                    <th class="py-3 px-6 text-left">Description</th>
                    <!-- <th class="py-2 px-4 text-left">Amount</th>                     -->
                    <th class="py-3 px-6 text-left">Category</th>
                    <th class="py-3 px-6 text-left">Mode of Transaction</th>
                    <th class="py-3 px-6 text-left">Branch</th>
                    <!-- <th class="py-3 px-6 text-left">Currency</th> -->
                    <th class="py-3 px-6 text-left">Amount</th>
                    <th class="py-3 px-6 text-left">Created On</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($canteenItems as $canteenItem)
                 <tr class="hover:bg-gray-50 transition-colors">
                    <td class="border border-gray-200 px-4 py-2">{{ $canteenItem->item_name }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $canteenItem->description }}</td>
                    <!-- <td class="border border-gray-200 px-2 py-2">{{ $canteenItem->amount }}</td> -->
                    <td class="border border-gray-200 px-4 py-2">{{ $canteenItem->category }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $canteenItem->mode_of_transaction }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $canteenItem->branch }}</td>
                    <!-- <td class="border border-gray-200 px-4 py-2">{{ $canteenItem->currency }}</td> -->
                    <td class="border border-gray-200 px-4 py-2">GHS-{{number_format($canteenItem->amount,2) }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ \Carbon\Carbon::parse($canteenItem->created_at)->format('M d, Y H:i A') }}</td>
                    @hasrole('Admin')
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('edit.canteenItemForm',$canteenItem->id) }}" class="ml-2 text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('delete.canteenitem',$canteenItem->id) }} " method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ml-4 text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                    @endhasrole
                </tr>
                @endforeach

                @if ($canteenItems->isEmpty())
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">No canteen records found.</td>
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
        {{ $canteenItems->appends(request()->query())->links() }}
    </div> 
</div>
@endsection