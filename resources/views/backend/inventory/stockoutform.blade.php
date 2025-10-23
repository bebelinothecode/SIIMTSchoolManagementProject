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

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Stock Out</h1>

    <form method="POST" action="{{ route('save.stockout', $stock->id) }}" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf

        <div>
            <label class="block text-gray-600">Stock Name</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ $stock->stock_name }}" required readonly>
        </div>

        <div>
            <label class="block text-gray-600">Quantity Issued</label>
            <input type="number" id="quantity_issued" name="quantity_issued" min="0" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-gray-600">Initial Quantity</label>
            <input type="number" id="initial_quantity" name="initial_quantity" value="{{ $stock->quantity }}" class="w-full border rounded px-3 py-2" readonly>
        </div>

        <div>
            <label class="block text-gray-600">Remainder</label>
            <input type="number" id="remainder" name="remainder" class="w-full border rounded px-3 py-2" readonly>
        </div>

        <div>                                                                  
            <label class="block text-gray-600">Recipient</label>
            <input type="text" name="recipient" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-gray-600">Remarks</label>
            <textarea name="remarks" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <div>                                                                  
            <label class="block text-gray-600">Date Issued</label>
            <input type="date" name="date_issued" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>                                                                  
            <label class="block text-gray-600">Date Returned</label>
            <input type="date" name="date_returned" class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex justify-end space-x-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
        </div>

        {{-- SweetAlert messages --}}
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

{{-- 🔢 Auto-calculate remainder --}}
<script>
    const initialQtyInput = document.getElementById('initial_quantity');
    const issuedQtyInput = document.getElementById('quantity_issued');
    const remainderInput = document.getElementById('remainder');

    function updateRemainder() {
        const initial = parseFloat(initialQtyInput.value) || 0;
        const issued = parseFloat(issuedQtyInput.value) || 0;
        const remainder = initial - issued;
        remainderInput.value = remainder >= 0 ? remainder : 0; // prevent negative remainder
    }

    issuedQtyInput.addEventListener('input', updateRemainder);
    initialQtyInput.addEventListener('input', updateRemainder);

    // Initialize remainder when page loads
    updateRemainder();
</script>
@endsection
