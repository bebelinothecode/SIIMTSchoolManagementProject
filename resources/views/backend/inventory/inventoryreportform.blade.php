@extends('layouts.app')

@section('content')
    <div class="roles">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Inventory Reports Form</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{ url()->previous() }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059
                            c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569
                            0 33.941l86.059 86.059c15.119 15.119 40.971 4.411
                            40.971-16.971V296z">
                        </path>
                    </svg>
                    <span class="ml-2 text-xs font-semibold">Back</span>
                </a>
            </div>
        </div>

        <div class="table w-full mt-8 bg-white rounded">
            <form action="{{ route('inventory.report') }}" method="POST" class="w-full max-w-xl px-6 py-12" enctype="multipart/form-data" target="_blank">
                @csrf

                <!-- Item -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="item_id">
                            Item
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select name="item_id" id="item_id" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value=""></option>
                            @foreach($stocks as $stock)
                                <option value="{{ $stock->id }}" {{ old('item_id') == $stock->id ? 'selected' : '' }}>{{ $stock->stock_name }}</option>
                            @endforeach
                        </select>
                        @error('item_id')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Current Date -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="current_date">
                            Current Date
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="current_date" id="current_date"
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4
                            text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                            type="date">
                        @error('current_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Start Date -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="start_date">
                            Start Date
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="start_date" id="start_date"
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4
                            text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                            type="date">
                        @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- End Date -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="end_date">
                            End Date
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="end_date" id="end_date"
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4
                            text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                            type="date">
                        @error('end_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit -->
             <div class="md:flex md:items-center">
                <div class="md:w-1/3"></div>

                <div class="md:w-2/3 flex items-center space-x-3">
                    <button
                        class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none
                        text-white font-bold py-2 px-4 rounded"
                        type="submit">
                        Generate Report
                    </button>

                    <button
                        class="shadow bg-green-500 hover:bg-green-400 focus:shadow-outline focus:outline-none
                        text-white font-bold py-2 px-4 rounded"
                        type="submit"
                        formaction="{{ route('inventory.report.detailed') }}"
                        formmethod="POST"
                        formtarget="_blank">
                        Generate Detailed Report
                    </button>
                </div>
            </div>

            </form>

            <!-- SweetAlert Notifications -->
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
        </div>
    </div>

    <!-- Select2 Styles & Scripts -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

    <!-- Initialize Select2 -->
    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#item_id').select2({
            placeholder:  "-- Select Item --",
            allowClear: true,
            width: '100%'
        });
    });
</script>
        
    @endpush
   

@endsection
