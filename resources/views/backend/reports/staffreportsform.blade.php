@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Staff Reports</h1>

        <form action="{{ route('staff.reports.generate') }}" method="GET" class="space-y-6">
            @csrf

            <!-- Report Type -->
            <div>
                <label for="report_type" class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                <select name="report_type" id="report_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Select Report Type</option>
                    <option value="leave">Leave Reports</option>
                    <option value="salary">Salary Reports</option>
                    <option value="both">Both Leave and Salary</option>
                </select>
            </div>

            <!-- Staff Selection -->
            <div>
                <label for="staff_id" class="block text-sm font-medium text-gray-700 mb-2">Select Staff (Optional - leave empty for all staff)</label>
                <select name="staff_id" id="staff_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Staff</option>
                    @foreach($staff as $member)
                        <option value="{{ $member->id }}">{{ $member->user->name ?? 'N/A' }} - {{ $member->position ?? 'N/A' }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date Range -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Current Date Option -->
            <div class="flex items-center">
                <input type="checkbox" name="current_date" id="current_date" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="current_date" class="ml-2 block text-sm text-gray-900">
                    Use Current Date (overrides date range)
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Generate Report
                </button>
            </div>
        </form>
    </div>
</div>
@endsection