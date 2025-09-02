@extends('layouts.app')

@section('content')
    <div class="roles">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Student Details</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{ route('student.index') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" class="svg-inline--fa fa-long-arrow-alt-left fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"></path></svg>
                    <span class="ml-2 text-xs font-semibold">Back</span>
                </a>
            </div>
        </div>

        <div class="mt-8 bg-white rounded">
            <div class="w-full max-w-2xl px-6 py-12">

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3">
                        <img class="w-20 h-20 sm:w-32 sm:h-32 rounded" src="{{ asset('images/profile/' .$student->user->profile_picture) }}" alt="avatar">
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Name : 
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <span class="block text-gray-600 font-bold">{{ $student->user->name }}</span>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Student ID : 
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <span class="block text-gray-600 font-bold">{{ $student->index_number }}</span>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Email :
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <span class="text-gray-600 font-bold">{{ $student->user->email }}</span>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Phone :
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <span class="text-gray-600 font-bold">{{ $student->phone }}</span>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Gender :
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <span class="text-gray-600 font-bold">{{ $student->gender }}</span>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Date of Birth :
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <span class="text-gray-600 font-bold">{{ $student->dateofbirth }}</span>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Current Address :
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <span class="text-gray-600 font-bold">{{ $student->current_address }}</span>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Student's Course:
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <span class="text-gray-600 font-bold">{{ $student->course->course_name ?? $student->diploma->name ?? '' }}</span>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Course Fee's:
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <span class="text-gray-600 font-bold">{{$student->course->currency ?? $student->diploma->currency ?? "Not Found"}}-{{ $student->course->fees ?? $student->diploma->fees ?? 'Not Found' }}</span>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Attendance Time :
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <span class="text-gray-600 font-bold">{{ $student->attendance_time }}</span>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Student Parent :
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <span class="text-gray-600 font-bold">{{ $student->student_parent ?? "Parent Name not found" }}</span>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Student Type :
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <span class="text-gray-600 font-bold">{{ $student->student_type ?? "Student Type not found" }}</span>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Student Category :
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <span class="text-gray-600 font-bold">{{ $student->student_category ?? "Student Category not found" }}</span>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Level :
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <span class="text-gray-600 font-bold">{{ $student->level ?? "Level not found" }}</span>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Semester :
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <span class="text-gray-600 font-bold">{{ $student->session ?? "Semester not found" }}</span>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Parent Phone :
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <span class="text-gray-600 font-bold">{{ $student->parent_phonenumber ?? "No phone number" }}</span>
                    </div>
                </div>
            </div>        
        </div>
        <!-- Student Transactions -->
<div class="mt-8 bg-white rounded shadow">
    <div class="w-full px-6 py-6">
        <h3 class="text-lg font-bold text-gray-700 mb-4">Student Transactions</h3>

        @if(isset($transactions) && count($transactions) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Receipt No.</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Payment Method</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Amount</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Balance</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Currency</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Fees Type</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Remarks</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($transactions as $transaction)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $transaction->receipt_number }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $transaction->method_of_payment }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ number_format($transaction->amount, 2) }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ number_format($transaction->balance, 2) }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $transaction->currency }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $transaction->fees_type ?? 'N/A' }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $transaction->remarks ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                    <!-- Totals Row (per currency) -->
                    <tfoot class="bg-gray-100">
                        @foreach($transactions->groupBy('currency') as $currency => $group)
                            <tr>
                                <td colspan="2" class="px-4 py-2 text-right font-bold text-gray-700">
                                    Totals ({{ $currency }}):
                                </td>
                                <td class="px-4 py-2 font-bold text-gray-700">
                                    {{ number_format($group->sum('amount'), 2) }}
                                </td>
                                {{-- <td class="px-4 py-2 font-bold text-gray-700">
                                    {{ number_format($group->sum('balance'), 2) }}
                                </td> --}}
                                <td colspan="4"></td>
                            </tr>
                        @endforeach
                    </tfoot>
                </table>
            </div>
        @else
            <p class="text-gray-600">No transactions found for this student.</p>
        @endif
    </div>
</div>

        
    </div>
@endsection