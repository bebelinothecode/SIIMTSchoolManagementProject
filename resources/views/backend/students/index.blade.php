@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 min-h-screen bg-gray-50">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Students Management</h1>
                <p class="text-sm text-gray-500 mt-1">Manage student records, payments, and information</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                @hasanyrole('Admin|rector|frontdesk|AsstAccount')
                <a href="{{ route('student.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-sm text-white tracking-wide hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Student
                </a>
                @endhasanyrole

                <form action="{{ route('student.index') }}" method="GET" class="w-full sm:w-auto">
                    <select name="sort" onchange="this.form.submit()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="All">All Students</option>
                        <option value="Academic" {{ request('sort') === 'Academic' ? 'selected' : '' }}>Academic</option>
                        <option value="Professional" {{ request('sort') === 'Professional' ? 'selected' : '' }}>Professional</option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 mb-6">
        <form action="{{ route('student.index') }}" method="GET">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        id="search"
                        placeholder="Search by name, email or index number" 
                        value="{{ request('search') }}"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        Search
                    </button>
                    @if(request()->has('search') || request()->has('sort'))
                        <a href="{{ route('student.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Clear Filters
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('search').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        })
    </script>

    <div class="bg-white shadow-sm rounded-lg min-h-[600px]"> <!-- Added min-h-[600px] -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Index Number</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Branch</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($students as $student)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500">
                                    {{ substr($student->user->name ?? "N/A", 0, 1)  }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $student->user->name ?? "N/A" }}</div>
                                    <div class="text-sm text-gray-500">{{ $student->user->email ?? "N/A" }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $student->balance < 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ number_format((int)$student->balance, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $student->course->course_name ?? $student->diploma->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell">{{ $student->index_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <!-- <span class="inline-block w-3 h-3 rounded-full animate-pulse 
                                {{ $student->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}" 
                                title="{{ ucfirst($student->status ?? 'Unknown') }}">
                            </span> -->
                            {{ $student->branch }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="relative inline-block text-left dropdown-container">
                                <div>
                                    <button type="button" 
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dropdown-toggle"
                                        data-student-id="{{ $student->id }}"
                                    >
                                        <span class="hidden sm:inline">Options</span>
                                        <svg class="h-5 w-5 sm:ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
    
                                <div class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 dropdown-menu" data-menu-for="{{ $student->id }}">
                                    <div class="py-1" role="none">
                                        <a href="{{ route('student.show', $student->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                            <svg class="mr-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Details
                                        </a>
                                        @hasanyrole('Admin|rector')
                                        <a href="{{ route('student.edit', $student->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                            <svg class="mr-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <a href="{{ route('change.studentstatusform', $student->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                            <svg class="mr-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Change Status
                                        </a>
                                        @endhasanyrole
                                        @hasanyrole("Admin|rector|frontdesk")
                                        <a href="{{ route('student.print', $student->id) }}" target="_blank" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                            <svg class="mr-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                            Print Admission
                                        </a>
                                        @endhasanyrole
                                        @hasanyrole('Admin|rector|AsstAccount')
                                        <a href="{{ route('pay.feesform', $student->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                            <svg class="mr-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Pay Fees
                                        </a>
                                        @endhasanyrole
                                        @hasanyrole('Admin|rector')
                                        <hr class="my-1 border-gray-200">
                                        <form method="POST" action="{{ route('student.destroy', $student->id) }}" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100" role="menuitem">
                                                <svg class="mr-3 h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                        @endhasanyrole
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p class="mt-2 text-gray-500 text-base font-medium">No students found</p>
                            <p class="mt-1 text-gray-400 text-sm">
                                @if(request()->has('search')) 
                                    Try a different search term or 
                                    <a href="{{ route('student.index') }}" class="text-blue-600 hover:text-blue-500">clear all filters</a>
                                @else
                                    Add your first student to get started
                                @endif
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Mobile View of Student List (Only visible on small screens) -->
        <div class="sm:hidden">
            @forelse ($students as $student)
            <div class="border-b border-gray-200 hover:bg-gray-50 transition-colors duration-150">
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500">
                                {{ substr($student->user->name ?? "N/A", 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">{{ $student->user->name ?? "N/A" }}</div>
                                <div class="text-xs text-gray-500">{{ $student->index_number }}</div>
                            </div>
                        </div>
                        <div class="relative dropdown-container">
                            <button type="button" 
                                class="inline-flex items-center p-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 dropdown-toggle"
                                data-student-id="{{ $student->id }}-mobile"
                            >
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                            </button>
                            
                            <div class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 dropdown-menu" data-menu-for="{{ $student->id }}-mobile">
                                <!-- Same menu options as desktop view -->
                                <div class="py-1" role="none">
                                    <a href="{{ route('student.show', $student->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">View Details</a>
                                    @hasanyrole('Admin|rector')
                                    <a href="{{ route('student.edit', $student->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Edit</a>
                                    @endhasanyrole
                                    <!-- Other menu items -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 grid grid-cols-2 gap-2">
                        <div>
                            <div class="text-xs font-medium text-gray-500">Program</div>
                            <div class="text-sm text-gray-900 truncate">{{ $student->course->course_name ?? $student->diploma->name ?? 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-gray-500">Balance</div>
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $student->balance < 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ number_format((int)$student->balance, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="py-12 px-4 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="mt-2 text-sm text-gray-500">No students found</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($students->hasPages())
    <div class="mt-6">
        {{ $students->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<script>
    function initDropdowns() {
        // Close all dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown-container')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });
    
        // Handle dropdown toggle clicks
        document.querySelectorAll('.dropdown-toggle').forEach(button => {
            // Avoid duplicate event listeners
            button.removeEventListener('click', toggleDropdown);
            button.addEventListener('click', toggleDropdown);
        });
    
        // Close dropdown when clicking on menu items
        document.querySelectorAll('.dropdown-menu a, .dropdown-menu button').forEach(item => {
            item.removeEventListener('click', closeMenu);
            item.addEventListener('click', closeMenu);
        });
    }
    
    function toggleDropdown(event) {
        event.stopPropagation();
        const studentId = this.getAttribute('data-student-id');
        const dropdownMenu = document.querySelector(`.dropdown-menu[data-menu-for="${studentId}"]`);
    
        // Close all other dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (menu !== dropdownMenu) {
                menu.classList.add('hidden');
            }
        });
    
        // Toggle current dropdown
        if (dropdownMenu) {
            dropdownMenu.classList.toggle('hidden');
        }
    }
    
    function closeMenu() {
        this.closest('.dropdown-menu').classList.add('hidden');
    }
    
    // Initialize on DOM load
    document.addEventListener('DOMContentLoaded', function() {
     initDropdowns();
    });
</script>
@endsection