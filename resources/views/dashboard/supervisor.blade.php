@extends('layouts.app')
@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h2>

    {{-- Grid Layout --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white shadow-lg rounded-lg p-6 text-center border border-gray-300">
            <h3 class="text-gray-500 uppercase font-bold">Welcome Supervisor</h3>
        </div>
    </div>
</div>
@endsection