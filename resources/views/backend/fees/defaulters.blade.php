@extends('layouts.app')

@section('content')
    <div class="create">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Defaulters</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{ route('home') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"></path>
                    </svg>
                    <span class="ml-2 text-xs font-semibold">Back</span>
                </a>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <!-- Your form -->
            <form action="" method="GET" class="flex items-center">
                <label for="sort" class="text-sm text-gray-600 mr-2">Sort by:</label>
                <select name="sort" id="sort" onchange="this.form.submit()" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 rounded">
                    <option value="All">All</option>
                    <option value="Academic" {{ request('sort') === 'Academic' ? 'selected' : '' }}>Academic</option>
                    <option value="Professional" {{ request('sort') === 'Professional' ? 'selected' : '' }}>Professional</option>
                </select>
            </form>
        
            <!-- Your amount labels -->
            <div class="text-right">
                <div><label class="text-sm text-gray-600">Total Academic: GHS{{number_format($defaultersAcademicTotal,2)}}</label></div>
                <div><label class="text-sm text-gray-600">Total Professional: GHS{{number_format($defaultersAcademicProfessional,2)}}</label></div>
                <div><label class="text-sm text-gray-600">Total All: GHS{{number_format($totalAmount,2)}}</label></div>
            </div>
        </div>

        <!-- Search Form -->
    <form action="{{ route('fees.defaulters')}}" method="GET" class="flex items-center mt-4 space-x-4">
        <input 
            type="text" 
            name="search" 
            placeholder="Search Defaulters" 
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

        <div class="mt-6 bg-white rounded-lg shadow">
            <table class="w-full table-auto">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">Name</th>
                        {{-- <th class="py-3 px-6 text-left">Email</th> --}}
                        <th class="py-3 px-6 text-left">Phone Number</th>
                        <th class="py-3 px-6 text-left">Index Number</th>
                        <th class="py-3 px-6 text-left">Level</th>
                        <th class="py-3 px-6 text-left">Current Semester</th>
                        <th class="py-3 px-6 text-left">Course</th>
                        <th class="py-3 px-6 text-center">Student Category</th>
                        <th class="py-3 px-6 text-center">Currency</th>
                        <th class="py-3 px-6 text-center">Balance</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse ($defaulters as $defaulter)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $defaulter->user->name }}</td>
                            {{-- <td class="py-3 px-6 text-left">{{ $defaulter->user->email }}</td> --}}
                            <td class="py-3 px-6 text-left">{{ $defaulter->phone }}</td>
                            <td class="py-3 px-6 text-left">{{ $defaulter->index_number }}</td>
                            <td class="py-3 px-6 text-left">{{ $defaulter->level }}</td>
                            <td class="py-3 px-6 text-left">{{ $defaulter->session }}</td>
                            <td class="py-3 px-6 text-left">{{ $defaulter->course->course_name ?? $defaulter->diploma->name ?? null }}</td>
                            <td class="py-3 px-6 text-left">{{ $defaulter->student_category }}</td>
                            <td class="py-3 px-6 text-left">{{ $defaulter->currency ?? $defaulter->currency_prof  }}</td>
                            <td class="py-3 px-6 text-left">{{ number_format($defaulter->balance, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-3 px-6 text-center text-gray-500">No defaulters found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            {{ $defaulters->links() }}
        </div>
    </div>
@endsection