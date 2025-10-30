<!-- @extends('layouts.app') -->

@section('content')
<div class="container mx-auto p-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-extrabold text-gray-800">📊 Dashboard Overview</h2>
        <p class="text-gray-500">Welcome back, {{ Auth::user()->name ?? 'Admin' }}</p>
    </div>

    {{-- Grid Layout --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        {{-- Parents --}}
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-2xl shadow-md p-6 text-center hover:shadow-lg transition">
            <h3 class="text-blue-600 uppercase font-bold mb-2">Active Academic Students</h3>
            <span class="text-5xl font-extrabold text-blue-700">{{  $activeAcademicStudentsCount }}</span>
        </div>

        {{-- Teachers --}}
        <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-2xl shadow-md p-6 text-center hover:shadow-lg transition">
            <h3 class="text-green-600 uppercase font-bold mb-2">Active Professional Students</h3>
            <span class="text-5xl font-extrabold text-green-700">{{ $activeProfessionalStudentsCount }}</span>
        </div>

        {{-- Students --}}
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-2xl shadow-md p-6 text-center hover:shadow-lg transition">
            <h3 class="text-purple-600 uppercase font-bold mb-2">Completed Professional Students</h3>
            <span class="text-5xl font-extrabold text-purple-700">{{ $completedProfessionalStudentsCount }}</span>
        </div>

        {{-- Academic Students --}}
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 border border-indigo-200 rounded-2xl shadow-md p-6 text-center hover:shadow-lg transition">
            <h3 class="text-indigo-600 uppercase font-bold mb-2">Inactive/Defered Professional Students</h3>
            <span class="text-5xl font-extrabold text-indigo-700">{{ $inactiveProfessionalStudentsCount }}</span>
        </div>

        {{-- Professional Students --}}
        <!-- <div class="bg-gradient-to-br from-pink-50 to-pink-100 border border-pink-200 rounded-2xl shadow-md p-6 text-center hover:shadow-lg transition">
            <h3 class="text-pink-600 uppercase font-bold mb-2">Professional Students</h3>
            <span class="text-5xl font-extrabold text-pink-700">{{ $studentsProfessional }}</span>
        </div> -->

        @hasrole('Admin|rector|AsstAccount')
        {{-- Fees Collected --}}
        <div class="bg-gradient-to-br from-amber-50 to-yellow-100 border border-yellow-200 rounded-2xl shadow-md p-6 text-center hover:shadow-lg transition">
            <h3 class="text-yellow-600 uppercase font-bold mb-2">Total Fees Collected</h3>
            <span class="text-3xl font-extrabold text-yellow-700">GHS {{ number_format($totalFeesCollected, 2) }}</span>
        </div>

        {{-- Expenses Made --}}
        <div class="bg-gradient-to-br from-rose-50 to-red-100 border border-red-200 rounded-2xl shadow-md p-6 text-center hover:shadow-lg transition">
            <h3 class="text-red-600 uppercase font-bold mb-2">Total Expenses Made</h3>
            <span class="text-3xl font-extrabold text-red-700">GHS {{ number_format($totalExpensesMade, 2) }}</span>
        </div>
        @endhasrole
    </div>

    {{-- Recent Activity Section --}}
    <div class="mt-10 bg-white border border-gray-200 rounded-2xl shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-700 uppercase">Recent Activity</h3>
            <span class="text-sm text-gray-500">Last updated: {{ now()->format('M d, Y') }}</span>
        </div>
        <ul class="divide-y divide-gray-200">
            <li class="py-3 flex items-center justify-between">
                <span>📘 New books were uploaded this week.</span>
                <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">Update</span>
            </li>
            <li class="py-3 flex items-center justify-between">
                <span>🎓 {{ count($students) }} students enrolled this semester.</span>
                <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full">Enrollment</span>
            </li>
        </ul>
    </div>
</div>
@endsection
