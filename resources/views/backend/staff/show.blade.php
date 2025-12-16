@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 min-h-screen bg-gray-50">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Staff Details</h1>
                <p class="text-sm text-gray-500 mt-1">View detailed information about {{ $staff->user->name }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('staff.edit', $staff->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-sm text-white tracking-wide hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Staff
                </a>
                <a href="{{ route('staff.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-medium text-sm text-white tracking-wide hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Staff Information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="text-center">
                    <div class="h-24 w-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-gray-500">{{ substr($staff->user->name, 0, 1) }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $staff->user->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $staff->position }}</p>
                    <div class="mt-4">
                        @php $status = strtolower($staff->status ?? 'unknown'); @endphp
                        @if($status === 'active')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Active
                            </span>
                        @elseif($status === 'inactive')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Inactive
                            </span>
                        @elseif($status === 'terminated')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293zM11 13a1 1 0 100-2 1 1 0 012 0z" clip-rule="evenodd" />
                                </svg>
                                Terminated
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                {{ ucfirst($staff->status ?? 'Unknown') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-6">Personal Information</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->user->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Address</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->user->email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->phone_number }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Position</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->position }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Employment Type</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->employment_type }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gender</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($staff->gender) }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->date_of_birth ? $staff->date_of_birth->format('M d, Y') : 'N/A' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Start Employment Date</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->start_employment_date ? $staff->start_employment_date->format('M d, Y') : 'N/A' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">End Employment Date</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->end_employment_date ? $staff->end_employment_date->format('M d, Y') : 'N/A' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->status }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $staff->address }}</p>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Member since</p>
                            <p class="text-sm font-medium text-gray-900">{{ $staff->created_at ? $staff->created_at->format('M d, Y') : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Last updated</p>
                            <p class="text-sm font-medium text-gray-900">{{ $staff->updated_at ? $staff->updated_at->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection