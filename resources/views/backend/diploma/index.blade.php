@extends('layouts.app')

@section('content')
{{-- @hasrole('Admin|rector|frontdesk') --}}
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-700">Professional/Diploma</h1>

    <!-- Add New Diploma Button -->
     @hasrole('Admin|rector')
    <div class="flex flex-wrap items-center">
        <a href="{{ route('diploma.form') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded hover:bg-gray-300 transition duration-300">
            <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path>
            </svg>
            <span class="ml-2 text-xs font-semibold">Add Professional/Diploma</span>
        </a>
    </div>
    @endhasrole

    <!-- Search Form -->
    <form action="{{ route('diploma.searchindex') }}" method="GET" class="flex items-center mt-4 space-x-4">
        <input 
            type="text" 
            name="search" 
            placeholder="Search for Diploma and Certificate Courses" 
            value="{{ request('search') }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
        >
        <button 
            type="submit" 
            class="px-4 py-2 m-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 transition duration-300"
        >
            Search
        </button>
    </form>
    
    <!-- Diplomas Table -->
    <div class="mt-6 bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <!-- <th class="py-3 px-6 text-left">ID</th> -->
                    <th class="py-3 px-6 text-left">Professional/Diploma</th>
                    <th class="py-3 px-6 text-left">Code</th>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Duration</th>
                    <th class="py-3 px-6 text-center">Currency</th>
                    <th class="py-3 px-6 text-center">Fees</th>
                    @hasrole('Admin|rector')
                    <th class="py-3 px-6 text-center">Action</th>
                    @endhasrole
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($diplomas as $diploma)
                <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-300">
                    <!-- <td class="py-3 px-6 text-left whitespace-nowrap">{{ $diploma->id }}</td> -->
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $diploma->type_of_course }}</td>
                    <td class="py-3 px-6 text-left">{{ $diploma->code }}</td>
                    <td class="py-3 px-6 text-left">{{ $diploma->name ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left">{{ $diploma->duration }}</td>
                    <td class="py-3 px-6 text-center">{{ $diploma->currency }}</td>
                    <td class="py-3 px-6 text-center">{{ $diploma->fees }}</td>
                    @hasrole('Admin|rector')
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('edit.diploma', $diploma->id) }}" class="text-green-600 hover:underline">Edit</a>
                        <form action="{{ route('delete.diploma', $diploma->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ml-4 text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                        </form>
                    </td>
                    @endhasrole
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-3 px-6 text-center text-gray-500">No diplomas found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $diplomas->appends(request()->input())->links() }}
    </div>
</div>
{{-- @endhasrole --}}

<!-- SweetAlert Scripts -->
@if (session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            title: 'Oops!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
@endif
@endsection