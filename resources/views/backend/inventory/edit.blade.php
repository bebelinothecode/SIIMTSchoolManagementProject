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
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Stock</h1>

    <form method="POST" action="{{ route('update.stock', $stock->id) }} " class="space-y-4 bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-600">Name</label>
            <input type="text" name="name" value="{{ $stock->stock_name }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-gray-600">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2">{{ $stock->description }}</textarea>
        </div>

        <div>
            <label class="block text-gray-600">Quantity</label>
            <input type="number" name="quantity" value="{{ $stock->quantity }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-gray-600">Unit Price (₵)</label>
            <input type="text" step="0.01" name="unit_price" value="{{ $stock->unit_of_measure }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-gray-600">Location</label>
            <input type="text" name="location" value="{{ $stock->location }}" class="w-full border rounded px-3 py-2">
        </div>

        {{-- <div>
            <label class="block text-gray-600">Reorder Level</label>
            <input type="number" name="reorder_level" value="{{ $stock->reorder_level }}" class="w-full border rounded px-3 py-2">
        </div> --}}

        <div class="flex justify-end space-x-2">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update</button>
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
@endsection
