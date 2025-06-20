@extends('layouts.app')

@section('content')
    <div class="roles">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Expenses Reports</h2>
            </div>
        </div>
        <div class="table w-full mt-8 bg-white rounded">
            <form action="{{ route('generate.expensesreport') }}" method="GET" class="w-full max-w-xl px-6 py-12" onsubmit="return validateForm()" target="_blank">
                @csrf
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="current_date">
                            Current Date
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="current_date" id="current_date" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="date" value="{{ old('current_date') }}">
                        @error('current_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="start_date">
                            Start Date
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="start_date" id="start_date" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="date" value="{{ old('start_date') }}">
                        @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="end_date">
                            End Date
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="end_date" id="end_date" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="date" value="{{ old('end_date') }}">
                        @error('end_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Mode of Payment
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <select name="mode_of_payment" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="mode_of_payment">
                            <option value="">--Select Category--</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Mobile Money">Mobile Money</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Expense Category
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <select name="expense_category" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="student_category">
                            <option value="">--Select Category--</option>
                            @foreach ($categorys as $category)
                                <option value="{{ $category->id }}">{{ $category->expense_category }}</option>
                            @endforeach
                            <!-- <option value="Academic">Academic</option>
                            <option value="Professional">Professional</option> -->
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="md:flex md:items-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3 space-x-4">
                        <button type="submit" class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" target="_blank">
                            Generate Report
                        </button>
                        <button type="reset" class="shadow bg-gray-500 hover:bg-gray-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                            Reset
                        </button>
                    </div>
                </div>
            </form>
            @if(session('error'))
                <script>
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: '{{ session('error') }}',
                    });
                </script>
            @endif
        </div>
    </div>
@endsection