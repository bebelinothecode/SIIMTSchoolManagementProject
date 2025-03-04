{{-- <div class="w-full block mt-8">
    <div class="flex flex-wrap sm:flex-no-wrap justify-between">
        <div class="w-full bg-gray-200 text-center border border-gray-300 px-8 py-6 rounded">
            <h3 class="text-gray-700 uppercase font-bold">
                <span class="text-4xl">{{ sprintf("%02d", count($parents)) }}</span>
                <span class="leading-tight">Parents</span>
            </h3>
        </div>
        <div class="w-full bg-gray-200 text-center border border-gray-300 px-8 py-6 mx-0 sm:mx-6 my-4 sm:my-0 rounded">
            <h3 class="text-gray-700 uppercase font-bold">
                <span class="text-4xl">{{ sprintf("%02d", count($teachers)) }}</span>
                <span class="leading-tight">Teachers</span>
            </h3>
        </div>
        <div class="w-full bg-gray-200 text-center border border-gray-300 px-8 py-6 rounded">
            <h3 class="text-gray-700 uppercase font-bold">
                <span class="text-4xl">{{ sprintf("%02d", count($students)) }}</span>
                <span class="leading-tight">Students</span>
            </h3>
        </div>
    </div>
    <div class="flex flex-wrap sm:flex-no-wrap justify-between">
        <div class="w-full bg-gray-200 text-center border border-gray-300 px-8 py-6 my-3 rounded">
            <h3 class="text-gray-700 uppercase font-bold">
                <span class="text-4xl">{{ $books }}</span>
                <span class="leading-tight">Books</span>
            </h3>
        </div>
    </div>
</div> --}}

{{-- @extends('layouts.app') --}}

{{-- @extends('layouts.app') --}}

{{-- @extends('layouts.app') --}}

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h2>

    {{-- Grid Layout --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        {{-- Parents Card --}}
        <div class="bg-white shadow-lg rounded-lg p-6 text-center border border-gray-300">
            <h3 class="text-gray-500 uppercase font-bold">Parents</h3>
            <span class="text-5xl font-bold text-blue-600">{{ sprintf("%02d", count($parents)) }}</span>
        </div>

        {{-- Teachers Card --}}
        <div class="bg-white shadow-lg rounded-lg p-6 text-center border border-gray-300">
            <h3 class="text-gray-500 uppercase font-bold">Teachers</h3>
            <span class="text-5xl font-bold text-green-600">{{ sprintf("%02d", count($teachers)) }}</span>
        </div>

        {{-- Students Card --}}
        <div class="bg-white shadow-lg rounded-lg p-6 text-center border border-gray-300">
            <h3 class="text-gray-500 uppercase font-bold">Students</h3>
            <span class="text-5xl font-bold text-purple-600">{{ sprintf("%02d", count($students)) }}</span>
        </div>

        {{-- Books Card --}} 
        <div class="bg-white shadow-lg rounded-lg p-6 text-center border border-gray-300">
            <h3 class="text-gray-500 uppercase font-bold">Total Fees Collected: </h3>
            <span class="text-5xl font-bold text-red-600">GHS{{ number_format($totalFeesCollected, 2) }}</span>
        </div>

        {{-- Expenses Made --}}
        <div class="bg-white shadow-lg rounded-lg p-6 text-center border border-gray-300">
            <h3 class="text-gray-500 uppercase font-bold">Total Fees Collected: </h3>
            <span class="text-5xl font-bold text-red-600">GHS{{ number_format($totalExpensesMade, 2) }}</span>
        </div>

        {{-- Extra Sections (Can be used for stats or reports) --}}
        <div class="bg-white shadow-lg rounded-lg p-6 text-center border border-gray-300 col-span-1 sm:col-span-2">
            <h3 class="text-gray-500 uppercase font-bold">Recent Activity</h3>
            <ul class="divide-y divide-gray-300 mt-4">
                <li class="py-2">📌 New books were uploaded this week.</li>
                <li class="py-2">📌 {{ count($students) }} students enrolled this semester.</li>
            </ul>
        </div>
    </div>
</div>
@endsection


