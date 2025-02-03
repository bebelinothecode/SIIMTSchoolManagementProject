@extends('layouts.app')

@section('content')
    <div class="roles-permissions">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">School Fees</h2>
            </div>
        </div>
        <div class="mt-8 bg-white rounded border-b-4 border-gray-300">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                            School Fees
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                            Currency
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                            Session
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                            Start Academic Year
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                            End Academic Year
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                            Student Type
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fees as $fee)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                {{ $fee->school_fees }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                {{ $fee->currency }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                {{ $fee->session }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                {{ $fee->start_academic_year }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                {{ $fee->end_academic_year }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                {{ $fee->student_type }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 px-6">
                {{ $fees->links() }}
            </div>
        </div>
    </div>
@endsection
