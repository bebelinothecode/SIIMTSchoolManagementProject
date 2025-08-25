@extends('layouts.app')

@section('content')
    <div class="roles">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Profit and Loss Account</h2>
            </div>
        </div>
        <div class="table w-full mt-8 bg-white rounded">
            <form action="{{ route('generate.profitandloss') }}" method="POST" class="w-full max-w-xl px-6 py-12" target="_blank" >
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
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="end_date">
                            Branch
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select name="branch" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="branch" required>
                            <option value="">--Select Branch--</option>
                            <option value="Kanda">Kanda</option>
                            <option value="Kasoa">Kasoa</option>
                            <option value="Spintex">Spintex</option>
                        </select>                        
                        @error('branch')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="md:flex md:items-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3 space-x-4">
                        <button type="submit" class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                            Generate Report
                        </button>
                        <button type="reset" class="shadow bg-gray-500 hover:bg-gray-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                            Reset
                        </button>
                    </div>
                </div>
            </form>
            <!-- @if(session('error'))
                <script>
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: '{{ session('error') }}',
                    });
                </script>
            @endif -->
        </div>
    </div>
@endsection