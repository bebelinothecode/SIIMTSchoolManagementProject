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
                        <div class="p-2 bg-blue-50 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Leave Details</h1>
                            <p class="text-sm text-gray-500 mt-1">View leave record information</p>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('leaves.edit', $leave->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 border border-transparent rounded-xl font-medium text-sm text-white tracking-wide hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Leave
                    </a>
                    <a href="{{ route('leaves.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 rounded-xl font-medium text-sm text-gray-700 tracking-wide hover:bg-gray-50 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Leave Management
                    </a>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
            <div class="p-1 bg-gradient-to-r from-blue-500 to-indigo-600"></div>

            <div class="p-8">
                <!-- Staff Information -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-6">Staff Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Staff Name</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leave->staff->user->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Position</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leave->staff->position ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leave->staff->user->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Phone</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leave->staff->phone_number ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Leave Information -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-6">Leave Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Start Date</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leave->start_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">End Date</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leave->end_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Duration</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leave->start_date->diffInDays($leave->end_date) + 1 }} days</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Status</label>
                                <p class="mt-1">
                                    @php $status = strtolower($leave->status ?? 'unknown'); @endphp
                                    @if($status === 'approved')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                    @elseif($status === 'pending')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($status === 'rejected')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($leave->status ?? 'Unknown') }}</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Created At</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leave->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Last Updated</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leave->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reason -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-6">Reason</h2>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $leave->reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection