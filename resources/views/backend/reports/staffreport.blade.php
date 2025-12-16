@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Staff Report</h1>

        <!-- Report Filters Summary -->
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
            <h2 class="text-lg font-semibold mb-2">Report Filters</h2>
            <p><strong>Report Type:</strong> {{ ucfirst($reportType) }}</p>
            @if($staffId)
                <p><strong>Staff:</strong> {{ \App\Staff::find($staffId)->user->name ?? 'N/A' }}</p>
            @else
                <p><strong>Staff:</strong> All Staff</p>
            @endif
            @if($currentDate)
                <p><strong>Date:</strong> Current Date ({{ today()->format('Y-m-d') }})</p>
            @elseif($startDate && $endDate)
                <p><strong>Date Range:</strong> {{ $startDate }} to {{ $endDate }}</p>
            @elseif($startDate)
                <p><strong>Start Date:</strong> {{ $startDate }}</p>
            @elseif($endDate)
                <p><strong>End Date:</strong> {{ $endDate }}</p>
            @else
                <p><strong>Date:</strong> All Dates</p>
            @endif
        </div>

        <!-- Leave Reports -->
        @if(($reportType === 'leave' || $reportType === 'both') && $leaveData->isNotEmpty())
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Leave Reports</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border-b text-left">Staff Name</th>
                                <th class="py-2 px-4 border-b text-left">Start Date</th>
                                <th class="py-2 px-4 border-b text-left">End Date</th>
                                <th class="py-2 px-4 border-b text-left">Reason</th>
                                <th class="py-2 px-4 border-b text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaveData as $leave)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b">{{ $leave->staff->user->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $leave->start_date ? \Carbon\Carbon::parse($leave->start_date)->format('Y-m-d') : 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $leave->end_date ? \Carbon\Carbon::parse($leave->end_date)->format('Y-m-d') : 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $leave->reason ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $leave->status ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="mt-4 text-gray-600">Total Leave Records: {{ $leaveData->count() }}</p>
            </div>
        @elseif($reportType === 'leave' || $reportType === 'both')
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Leave Reports</h2>
                <p class="text-gray-600">No leave records found for the selected criteria.</p>
            </div>
        @endif

        <!-- Salary Reports -->
        @if(($reportType === 'salary' || $reportType === 'both') && $salaryData->isNotEmpty())
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Salary Reports</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border-b text-left">Staff Name</th>
                                <th class="py-2 px-4 border-b text-left">Amount</th>
                                <th class="py-2 px-4 border-b text-left">Payment Date</th>
                                <th class="py-2 px-4 border-b text-left">Month/Year</th>
                                <th class="py-2 px-4 border-b text-left">Status</th>
                                <th class="py-2 px-4 border-b text-left">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salaryData as $salary)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b">{{ $salary->staff->user->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $salary->amount ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $salary->payment_date ? \Carbon\Carbon::parse($salary->payment_date)->format('Y-m-d') : 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b">{{ ($salary->month ?? 'N/A') . '/' . ($salary->year ?? 'N/A') }}</td>
                                    <td class="py-2 px-4 border-b">{{ $salary->status ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $salary->notes ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="mt-4 text-gray-600">Total Salary Records: {{ $salaryData->count() }}</p>
            </div>
        @elseif($reportType === 'salary' || $reportType === 'both')
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Salary Reports</h2>
                <p class="text-gray-600">No salary records found for the selected criteria.</p>
            </div>
        @endif

        <!-- Back Button -->
        <div class="flex justify-start mt-6">
            <a href="{{ route('staff.reportsform') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Back to Form
            </a>
        </div>
    </div>
</div>
@endsection