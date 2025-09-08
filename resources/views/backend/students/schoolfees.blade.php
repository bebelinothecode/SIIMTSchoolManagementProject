@extends('layouts.app')

@section('content')
    <div class="roles-permissions">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">School Fees</h2>

                <form action="{{ route('see.fees') }}" method="GET" class="w-full sm:w-auto">
                    <select name="sort" onchange="this.form.submit()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        {{-- <option value="All">All Students</option> --}}
                        <option value="Academic" {{ request('sort') === 'Academic' ? 'selected' : '' }}>Academic</option>
                        <option value="Professional" {{ request('sort') === 'Professional' ? 'selected' : '' }}>Professional</option>
                    </select>
                </form>

            </div>
        </div>
        <div class="mt-8 bg-white rounded border-b-4 border-gray-300">
            <table class="min-w-full">
                <thead>
                    <tr>
                        @if ($sort === 'Professional')
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                            Professional Course
                        </th>
                            
                        @endif
                         @if ($sort === 'Academic')
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                            Academic Course
                        </th>
                            
                        @endif
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                            School Fees
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                            Currency
                        </th>
                        {{-- <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                            Session
                        </th> --}}
                        {{-- <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                            Student Type
                        </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @if ($sort === 'Academic')
                        @foreach($acaFees as $fee)
                            <tr>
                                 <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                    {{ $fee->course_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                    {{ $fee->fees }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                    {{ $fee->currency }}
                                </td>
                                {{-- <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                    {{ $fee->session }}
                                </td> --}}
                                {{-- <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                    Academic
                                </td> --}}
                            </tr>
                        @endforeach
                    @endif

                    @if ($sort === 'Professional')
                        @foreach($profFees as $fee)
                            <tr>
                                 <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                    {{ $fee->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                    {{ $fee->fees }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                    {{ $fee->currency }}
                                </td>
                                {{-- <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                    {{ $fee->session }}
                                </td> --}}
                                {{-- <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                    Professional
                                </td> --}}
                            </tr>
                        @endforeach
                        
                    @endif
                    {{-- @foreach($fees as $fee)
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
                    @endforeach --}}
                </tbody>
            </table>
            <div class="mt-4 px-6">
                {{-- {{ $fees->links() }} --}}
            </div>
        </div>
    </div>
@endsection
