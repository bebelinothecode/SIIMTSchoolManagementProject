@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-lg">
    <div class="mb-4">
        <a href="{{ url()->previous() }}" class="inline-flex items-center bg-gray-200 text-gray-700 px-3 py-1 rounded hover:bg-gray-300">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Stock In</h1>

    <form method="POST" action="{{ route('save.stockin',$stock->id) }} " class="space-y-4 bg-white p-6 rounded shadow">
        @csrf
        <div>
            <label class="block text-gray-600">Stock Name</label>
            @hasrole('Admin|rector')
            <input type="text" name="name" class="w-full border rounded px-3 py-2" value = {{ $stock->stock_name }} required>
            @else
            <input type="text" name="name" class="w-full border rounded px-3 py-2" value = {{ $stock->stock_name }} required readonly>
            @endhasrole
        </div>

        <div>
            <label class="block text-gray-600">New Stock Quantity</label>
            <input type="number" id="new_quantity" name="new_quantity" min="0" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block text-gray-600">Old Stock Quantity</label>
            @hasrole('Admin|rector')
            <input type="number" id="old_quantity" name="old_quantity" value="{{ $stock->quantity }}" class="w-full border rounded px-3 py-2" required>
            @else
            <input type="number" name="old_quantity" value="{{ $stock->quantity }}" class="w-full border rounded px-3 py-2" required readonly>
            @endhasrole

        </div>
        <div>
            <label class="block text-gray-600">Total</label>
            <input type="number" name="total" id="total" class="w-full border rounded px-3 py-2" readonly>
        </div>
        <div>
            <label class="block text-gray-600">Unit Price</label>
            <input type="number" name="unit_price" class="w-full border rounded px-3 py-2">
        </div>
        <div>                                                                  
            <label class="block text-gray-600">Date</label>
            <input type="date" name="date_in"  class="w-full border rounded px-3 py-2" required>
        </div>
        <div>                                                                  
            <label class="block text-gray-600">Suppliers Info</label>
            <input type="text" name="suppliers_info"  class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-600">Remarks</label>
            <textarea name="remarks" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <div class="flex justify-end space-x-2">
            {{-- <a href=" " class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</a> --}}
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
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
    </form>
</div>

{{-- 🔢 Auto-calculate Total --}}
<script>
    const oldQtyInput = document.getElementById('old_quantity');
    const newQtyInput = document.getElementById('new_quantity');
    const totalInput = document.getElementById('total');

    function updateTotal() {
        const oldQty = parseFloat(oldQtyInput.value) || 0;
        const newQty = parseFloat(newQtyInput.value) || 0;
        totalInput.value = oldQty + newQty;
    }

    oldQtyInput.addEventListener('input', updateTotal);
    newQtyInput.addEventListener('input', updateTotal);

    // Initialize total on page load
    updateTotal();
</script>
@endsection
