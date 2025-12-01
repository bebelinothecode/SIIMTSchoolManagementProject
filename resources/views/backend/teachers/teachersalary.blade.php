@extends('layouts.app')

@section('title', 'Teacher Salary Report - ' . $report['month_year'])

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4">

    <!-- Header Section -->
    <div class="max-w-7xl mx-auto mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl blur-md opacity-20"></div>
                        <div class="relative bg-gradient-to-br from-blue-600 to-purple-700 w-16 h-16 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-file-invoice text-white text-2xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Teacher Salary Report</h1>
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-md">
                                <i class="fas fa-calendar-alt"></i>
                                {{ strtoupper($report['month_year']) }}
                            </div>
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-clock mr-1"></i>
                                Generated {{ now()->format('M j, Y g:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button onclick="window.print()" class="group bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-xl font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-print"></i>
                        <span>Print Report</span>
                    </button>
                    <button class="group bg-white border border-gray-300 hover:border-gray-400 text-gray-700 hover:text-gray-900 px-6 py-3 rounded-xl font-medium shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-download"></i>
                        <span>Export</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="max-w-7xl mx-auto mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Total Teachers -->
            <div class="group bg-white rounded-xl shadow-md p-5 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 w-12 h-12 rounded-lg flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-users text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-600 text-xs font-medium uppercase tracking-wider">Total Teachers</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ count($report['report']) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Total Sessions -->
            <div class="group bg-white rounded-xl shadow-md p-5 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 w-12 h-12 rounded-lg flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-calendar-check text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-600 text-xs font-medium uppercase tracking-wider">Total Sessions</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">
                            {{ $report['totals']['weekday_sessions'] + $report['totals']['weekend_sessions'] + $report['totals']['online_sessions'] }}
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Gross Salary -->
            <div class="group bg-white rounded-xl shadow-md p-5 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-amber-500 to-amber-600 w-12 h-12 rounded-lg flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-coins text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-600 text-xs font-medium uppercase tracking-wider">Gross Salary</p>
                        <h3 class="text-xl font-bold text-gray-900 mt-1">GHC {{ number_format($report['totals']['total_amount'], 2) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Net Payable -->
            <div class="group bg-white rounded-xl shadow-md p-5 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 w-12 h-12 rounded-lg flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-money-check-alt text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-600 text-xs font-medium uppercase tracking-wider">Net Payable</p>
                        <h3 class="text-xl font-bold text-gray-900 mt-1">GHC {{ number_format($report['totals']['amount_after_tax'], 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Session Rates Info -->
    <div class="max-w-7xl mx-auto mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-md p-4 text-white">
            <div class="flex flex-wrap items-center justify-center gap-6 text-sm font-medium">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-blue-300 rounded-full"></div>
                    <span>Weekday: GHC 120/session</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-green-300 rounded-full"></div>
                    <span>Weekend: GHC 250/session</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-purple-300 rounded-full"></div>
                    <span>Online: GHC 100/session</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-red-300 rounded-full"></div>
                    <span>Tax Rate: 3%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table -->
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">

            <!-- Table Header -->
            <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-table"></i>
                    Salary Breakdown & Details
                </h2>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-700 to-gray-800 text-white">
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Employee</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider">Weekday<br><span class="text-amber-300 font-semibold text-xs">GHC 120</span></th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider">Weekend<br><span class="text-amber-300 font-semibold text-xs">GHC 250</span></th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider">Online<br><span class="text-amber-300 font-semibold text-xs">GHC 100</span></th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider">Total</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider">Tax (3%)</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider">Net Amount</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach($report['report'] as $index => $teacher)
                        <tr class="group hover:bg-blue-50 transition-all duration-200 {{ $teacher['total_amount'] == 0 ? 'bg-gray-50 opacity-70' : 'bg-white' }}">
                            <td class="px-4 py-4 text-center">
                                <div class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg font-semibold text-gray-700 group-hover:bg-blue-100 group-hover:text-blue-700 transition-all duration-200">
                                    {{ $index + 1 }}
                                </div>
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-200">
                                            <i class="fas fa-user text-white text-sm"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-200">
                                            {{ $teacher['employee_name'] }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-4 text-center">
                                @if($teacher['weekday_sessions'] > 0)
                                    <span class="inline-flex items-center justify-center w-10 h-10 bg-blue-100 text-blue-700 rounded-lg font-semibold text-sm shadow-sm">
                                        {{ $teacher['weekday_sessions'] }}
                                    </span>
                                @else
                                    <span class="text-gray-300 text-lg font-light">—</span>
                                @endif
                            </td>

                            <td class="px-4 py-4 text-center">
                                @if($teacher['weekend_sessions'] > 0)
                                    <span class="inline-flex items-center justify-center w-10 h-10 bg-green-100 text-green-700 rounded-lg font-semibold text-sm shadow-sm">
                                        {{ $teacher['weekend_sessions'] }}
                                    </span>
                                @else
                                    <span class="text-gray-300 text-lg font-light">—</span>
                                @endif
                            </td>

                            <td class="px-4 py-4 text-center">
                                @if($teacher['online_sessions'] > 0)
                                    <span class="inline-flex items-center justify-center w-10 h-10 bg-purple-100 text-purple-700 rounded-lg font-semibold text-sm shadow-sm">
                                        {{ $teacher['online_sessions'] }}
                                    </span>
                                @else
                                    <span class="text-gray-300 text-lg font-light">—</span>
                                @endif
                            </td>

                            <td class="px-4 py-4 text-center">
                                <span class="text-sm font-bold text-gray-900">
                                    GHC {{ number_format($teacher['total_amount'], 2) }}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-center">
                                <span class="text-sm font-semibold text-red-600">
                                    GHC {{ number_format($teacher['withholding_tax'], 2) }}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-center">
                                <span class="text-sm font-bold text-blue-700">
                                    GHC {{ number_format($teacher['amount_after_tax'], 2) }}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-center">
                                @if($teacher['attendance_count'] === 0)
                                    <span class="px-2 py-1 bg-gray-500 text-white text-sm rounded-full">
                                        No payment
                                    </span>

                                {{-- If salary already paid --}}
                                @elseif($teacher['already_paid'])
                                    <span class="px-2 py-1 bg-green-600 text-white text-sm rounded-full">
                                        Already Paid
                                    </span>

                                {{-- Show pay button --}}
                                @else
                                   <form action="{{ route('teacher-salary.process-payment') }}" method="POST"  onsubmit="return confirm('Process payment for {{ $teacher['employee_name'] }} for {{ request('month', date('m')) }}/{{ request('year', date('Y')) }}?')">
                                        @csrf
                                        <input type="hidden" name="teacher_id" value="{{ $teacher['teacher_id'] }}">
                                        <input type="hidden" name="month" value="{{ request('month', date('m')) }}">
                                        <input type="hidden" name="year" value="{{ request('year', date('Y')) }}">
                                        <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-lg font-medium shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300">
                                            <i class="fas fa-money-bill-wave text-sm"></i> Pay
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    <!-- Footer Totals -->
                    <tfoot>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-t-2 border-blue-500">
                            <td colspan="2" class="px-4 py-4 text-right text-md font-bold text-gray-900">Grand Total:</td>
                            <td class="px-4 py-4 text-center"><span class="inline-flex items-center justify-center w-12 h-12 bg-blue-500 text-white rounded-lg font-bold text-sm shadow-md">{{ $report['totals']['weekday_sessions'] }}</span></td>
                            <td class="px-4 py-4 text-center"><span class="inline-flex items-center justify-center w-12 h-12 bg-green-500 text-white rounded-lg font-bold text-sm shadow-md">{{ $report['totals']['weekend_sessions'] }}</span></td>
                            <td class="px-4 py-4 text-center"><span class="inline-flex items-center justify-center w-12 h-12 bg-purple-500 text-white rounded-lg font-bold text-sm shadow-md">{{ $report['totals']['online_sessions'] }}</span></td>
                            <td class="px-4 py-4 text-center"><span class="text-md font-bold text-gray-900">GHC {{ number_format($report['totals']['total_amount'], 2) }}</span></td>
                            <td class="px-4 py-4 text-center"><span class="text-sm font-bold text-red-600">GHC {{ number_format($report['totals']['withholding_tax'], 2) }}</span></td>
                            <td class="px-4 py-4 text-center"><span class="text-md font-bold text-blue-700">GHC {{ number_format($report['totals']['amount_after_tax'], 2) }}</span></td>
                            <td></td>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
@media print {
    body { background: white !important; }
    .bg-gradient-to-br, .bg-gradient-to-r { background: white !important; }
    button { display: none !important; }
}
</style>
@endpush

@push('scripts')
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: "{{ session('success') }}",
    timer: 2500,
    showConfirmButton: false
});
</script>
@endif
@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: "{{ session('error') }}",
    timer: 3000,
    showConfirmButton: true
});
</script>
@endif
@endpush
