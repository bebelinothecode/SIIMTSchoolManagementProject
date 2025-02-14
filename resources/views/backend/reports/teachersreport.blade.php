@extends('layouts.app')

@section('title', 'Teachers Generated Report')

@section('content')
<style>
    @media print {
        /* Hide everything except the table */
        body * {
            visibility: hidden;
        }
        
        /* Show only the table and its contents */
        .print-section,
        .print-section * {
            visibility: visible;
        }
        
        /* Position the table at the top of the printed page */
        .print-section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        
        /* Hide the print button when printing */
        .no-print {
            display: none !important;
        }
        
        /* Ensure table looks good on paper */
        .print-section table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }
        
        .print-section tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        
        .print-section th,
        .print-section td {
            padding: 8px;
            border: 1px solid #ddd;
        }
    }
</style>

<div class="container mx-auto mt-6">
    <!-- Back Button -->
    <div class="mb-4 no-print">
        <a href="{{ url()->previous() }}" 
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back
        </a>
    </div>

    <h1 class="text-2xl font-bold text-gray-700">Teachers Generated Report</h1>

    <!-- Report Parameters -->
    <div class="mt-4 p-6 bg-white rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700">Report Parameters</h2>
        <div class="mt-2 text-sm text-gray-600">
            <p><strong>Level:</strong> {{ $level ?? 'N/A' }}</p>
            <p><strong>Semester:</strong> {{ $semester ?? 'N/A' }}</p>
            <p><strong>Gender:</strong> {{ $gender ?? 'N/A' }}</p>
            <p><strong>Subject:</strong> </p>
            {{-- <p><strong>Student Category:</strong> {{ $student_category ?? 'N/A' }}</p> --}}
        </div>
    </div>

    <!-- Students Table -->
    <div class="print-section mt-6 bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Phone</th>
                    <th class="py-3 px-6 text-left">Address</th>
                    <th class="py-3 px-6 text-left">Subjects Assigned</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($teachers as $teacher)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $teacher->user->name }}</td>
                        <td class="py-3 px-6 text-left">{{ $teacher->user->email }}</td>
                        <td class="py-3 px-6 text-left">{{ $teacher->phone }}</td>
                        <td class="py-3 px-6 text-left">{{ $teacher->index_number }}</td>
                        <td class="py-3 px-6 text-left">{{ $teacher->subjects->subject_code }}-{{$teacher->subjects->subject_name}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 px-6 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-lg font-medium">No teachers found for the selected criteria.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Print Button -->
    <div class="mt-8 no-print">
        <button 
            onclick="window.print()" 
            class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
        >
            Print Report
        </button>
    </div>
</div>
@endsection