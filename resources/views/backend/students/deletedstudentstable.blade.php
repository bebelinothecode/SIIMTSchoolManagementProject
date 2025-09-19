@extends('layouts.app')

@section('content')

{{-- @hasrole('Admin|rector|frontdesk') --}}
    <div class="container mx-auto mt-6">
        <h1 class="text-2xl font-bold text-gray-700">Deleted Students</h1>

        <!-- <div class="flex flex-wrap items-center">
            <a href="{{ route('classes.create') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
                <span class="ml-2 text-xs font-semibold">Subject</span>
            </a>
        </div> -->

        <!-- Search Form -->
        <!-- <form action="{{ route('classes.index')}}" method="GET" class="flex items-center mt-4 space-x-4">
            <input 
                type="text" 
                name="search" 
                placeholder="Search Subject by Example: semester=1 or subject_name=Twi and subject_code=CPEN112" 
                value="{{ request('search') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
            >
            <button 
                type="submit" 
                class="px-4 py-2 m-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
            >
                Search
            </button>
        </form> -->
        
        <!-- Students Table -->
        <div class="mt-6 bg-white rounded-lg shadow">
            <table class="w-full table-auto">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">Student Name</th>
                        <th class="py-3 px-6 text-left">Index Number</th>
                        <th class="py-3 px-6 text-left">Course</th>
                        <th class="py-3 px-6 text-left">Level</th>
                        <th class="py-3 px-6 text-center">Fees</th>
                        <th class="py-3 px-6 text-center">Balance</th>
                        {{-- <th class="py-3 px-6 text-center">Course</3th> --}}
                        @hasanyrole('Admin|rector')
                                <th class="py-3 px-6 text-center">Action</th>
                        @endhasanyrole
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse ($students as $student)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left">{{ $student->user->name ?? "N/A" }}</td>
                        <td class="py-3 px-6 text-left">{{ $student->index_number ?? 'N/A' }}</td>
                        @if ($student->student_category === 'Academic')
                          <td class="py-3 px-6 text-left">{{ $student->course->course_name }}</td>
                        @endif

                        @if ($student->student_category === 'Professional')
                            <td class="py-3 px-6 text-left">{{ $student->diploma->name }}</td>
                        @endif

                        @if ($student->student_category === 'Academic')
                            <td class="py-3 px-6 text-left">{{ $student->level ?? "N/A" }}</td>
                        @endif

                        @if ($student->student_category === 'Academic')
                            <td class="py-3 px-6 text-left">{{ number_format($student->fees,2) ?? "N/A" }}</td>
                        @endif

                        @if ($student->student_category === 'Professional')
                            <td class="py-3 px-6 text-left">{{ number_format($student->fees_prof,2) ?? "N/A" }}</td>
                        @endif

                        <td class="py-3 px-6 text-left">{{ number_format($student->balance,2) ?? "N/A" }}</td>

                        @hasanyrole('Admin|rector')
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('restore.deletedstudent',$student->id) }}" class="ml-4 text-green-600 hover:underline">Restore</a>
                        </td>
                        @endhasanyrole  
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-3 px-6 text-center text-gray-500">No students found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(session('error'))
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: '{{ session('error') }}',
                });
            </script>
        @endif

        @if(session('success'))
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: '{{ session('success') }}',
                });
            </script>
        @endif

        <!-- Pagination -->
        <div class="mt-8">
            
        </div>
    </div>
{{-- @endhasrole --}}
@endsection
