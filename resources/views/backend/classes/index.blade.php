{{-- This page is for the subjects within each course --}}
@extends('layouts.app')

@section('content')

@hasrole('Admin|rector|frontdesk')
    <div class="container mx-auto mt-6">
        <h1 class="text-2xl font-bold text-gray-700">Subjects</h1>

        <div class="flex flex-wrap items-center">
            <a href="{{ route('classes.create') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
                <span class="ml-2 text-xs font-semibold">Subject</span>
            </a>
        </div>

        <!-- Search Form -->
        <form action="{{ route('classes.index')}}" method="GET" class="flex items-center mt-4 space-x-4">
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
        </form>
        
        <!-- Students Table -->
        <div class="mt-6 bg-white rounded-lg shadow">
            <table class="w-full table-auto">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">Subject Code</th>
                        <th class="py-3 px-6 text-left">Subject Name</th>
                        <th class="py-3 px-6 text-left">Level</th>
                        <th class="py-3 px-6 text-left">Credit Hours</th>
                        <th class="py-3 px-6 text-center">Semester</th>
                        {{-- <th class="py-3 px-6 text-center">Course</3th> --}}
                        @hasanyrole('Admin|rector')
                                <th class="py-3 px-6 text-center">Action</th>
                        @endhasanyrole
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse ($classes as $class)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $class->subject_code }}</td>
                        <td class="py-3 px-6 text-left">{{ $class->subject_name }}</td>
                        <td class="py-3 px-6 text-left">{{ $class->level ?? 'N/A' }}</td>
                        <td class="py-3 px-6 text-left">{{ $class->credit_hours }}</td>
                        <td class="py-3 px-6 text-left">{{ $class->semester }}</td>
                        @hasanyrole('Admin|rector')
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('classes.edit',$class->id) }}" class="ml-4 text-green-600 hover:underline">Edit</a>
                            <form action="{{ route('classes.destroy',$class->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-4 text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                        @endhasanyrole
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-3 px-6 text-center text-gray-500">No subjects found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $classes->links() }}
        </div>
    </div>
@endhasrole
@endsection
