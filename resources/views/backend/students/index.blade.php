@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-700">Students List</h1>

    <div class="flex items-center justify-between">
        <div class="flex flex-wrap items-center">
            <a href="{{ route('student.create') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
                <span class="ml-2 text-xs font-semibold">Student</span>
            </a>
        </div>
    
        <form action=" " method="GET" class="flex items-center">
            <label for="sort" class="text-sm text-gray-600 mr-2">Sort by:</label>
            <select name="sort" id="sort" onchange="this.form.submit()" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 rounded">
                <option value="All">All</option>
                <option value="Academic" {{ request('sort') === 'Academic' ? 'selected' : '' }}>Academic</option>
                <option value="Professional" {{ request('sort') === 'Professional' ? 'selected' : '' }}>Professional</option>
            </select>
        </form>
    </div>

    

    <!-- Search Form -->
    <form action="{{ route('student.index')}}" method="GET" class="flex items-center mt-4 space-x-4">
        <input 
            type="text" 
            name="search" 
            placeholder="Search Student" 
            value="{{ request('search') }}"
            oninput="this.value = this.value.toUpperCase()"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
        >
        <button 
            type="submit" 
            class="px-4 py-2 m-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
        >
            Search
        </button>
    </form> 
    
    <!-- Students Table -->
    <div class="mt-6 bg-white rounded-lg shadow">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Balance</th>
                    <th class="py-3 px-6 text-left">Course/Diploma</th>
                    <th class="py-3 px-6 text-left">Index Number</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($students as $student)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $student->user->name }}</td>
                    <td class="py-3 px-6 text-left">{{ $student->user->email }}</td>
                    <td class="py-3 px-6 text-left">{{ $student->balance }}</td>
                    <td class="py-3 px-6 text-left">{{ $student->course->course_name ?? $student->diploma->name ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left">{{ $student->index_number }}</td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('student.show', $student->id) }}" class="text-blue-600 hover:underline">View</a>
                        @hasanyrole('Admin|rector')
                             <a href="{{ route('student.edit', $student->id) }}" class="ml-4 text-green-600 hover:underline">Edit</a>
                             <form action="{{ route('student.destroy', $student->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-4 text-red-600 hover:underline" onclick="return confirm('Are you sure you want ton delete {{$student->user->name}}?')">Delete</button>
                            </form>
                        @endhasanyrole
                        @hasanyrole("Admin|rector|frontdesk")
                        <a href="{{route('student.print', $student->id)}}" 
                            target="_blank"
                            class="ml-4 text-green-600 hover:underline">
                            Print Admission Letter
                        </a>
                        @endhasanyrole
                        @hasanyrole('Admin|rector|AsstAccount')
                             <a href="{{ route('pay.feesform', $student->id) }}" class="ml-4 text-green-600 hover:underline">Pay Fees</a>
                        @endhasanyrole
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-3 px-6 text-center text-gray-500">No students found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $students->links() }}
    </div>
</div>
@endsection
