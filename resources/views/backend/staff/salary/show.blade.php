@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <!-- Container -->
    <div class="max-w-4xl mx-auto">
        <!-- Header Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-200">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-green-50 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Salary Record Details</h1>
                            <p class="text-sm text-gray-500 mt-1">View detailed information about this salary payment</p>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('staff.salary.edit', $salary->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 border border-transparent rounded-xl font-medium text-sm text-white tracking-wide hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Record
                    </a>
                    <a href="{{ route('staff.salary.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 rounded-xl font-medium text-sm text-gray-700 tracking-wide hover:bg-gray-50 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Salaries
                    </a>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
            <div class="p-1 bg-gradient-to-r from-green-500 to-emerald-600"></div>

            <div class="p-8">
                <!-- Staff Information -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-6">Staff Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-500">
                                    {{ substr($salary->staff->user->name ?? "N/A", 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $salary->staff->user->name ?? "N/A" }}</h3>
                                    <p class="text-sm text-gray-500">{{ $salary->staff->position ?? "N/A" }}</p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="text-sm font-medium text-gray-900">{{ $salary->staff->user->email ?? "N/A" }}</p>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="text-sm font-medium text-gray-900">{{ $salary->staff->phone_number ?? "N/A" }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <p class="text-sm text-gray-500">Employment Type</p>
                                <p class="text-sm font-medium text-gray-900">{{ $salary->staff->employment_type ?? "N/A" }}</p>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-500">Status</p>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    @if(strtolower($salary->staff->status ?? '') === 'active') bg-green-100 text-green-800
                                    @elseif(strtolower($salary->staff->status ?? '') === 'inactive') bg-yellow-100 text-yellow-800
                                    @elseif(strtolower($salary->staff->status ?? '') === 'terminated') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($salary->staff->status ?? 'Unknown') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Salary Information -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-6">Salary Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-medium text-gray-900">Amount</h3>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($salary->amount, 2) }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-medium text-gray-900">Month/Year</h3>
                            </div>
                            <p class="text-lg font-semibold text-gray-900">{{ $salary->month }} {{ $salary->year }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-purple-100 rounded-lg">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-medium text-gray-900">Status</h3>
                            </div>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                @if(strtolower($salary->status) === 'paid') bg-green-100 text-green-800
                                @elseif(strtolower($salary->status) === 'pending') bg-yellow-100 text-yellow-800
                                @elseif(strtolower($salary->status) === 'overdue') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($salary->status) }}
                            </span>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-indigo-100 rounded-lg">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-medium text-gray-900">Payment Date</h3>
                            </div>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $salary->payment_date ? $salary->payment_date->format('M d, Y') : 'Not Set' }}
                            </p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-orange-100 rounded-lg">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-medium text-gray-900">Created</h3>
                            </div>
                            <p class="text-sm font-medium text-gray-900">{{ $salary->created_at->format('M d, Y H:i') }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-teal-100 rounded-lg">
                                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-medium text-gray-900">Last Updated</h3>
                            </div>
                            <p class="text-sm font-medium text-gray-900">{{ $salary->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                @if($salary->notes)
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-6">Notes</h2>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-gray-700">{{ $salary->notes }}</p>
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="pt-8 border-t border-gray-200 flex justify-end gap-4">
                    <form method="POST" action="{{ route('staff.salary.destroy', $salary->id) }}" onsubmit="return confirm('Are you sure you want to delete this salary record? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 border border-transparent rounded-lg font-medium text-sm text-white tracking-wide hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Record
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection