@extends('layouts.app')

@section('content')
    <div class="create">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Fees History</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{ route('home') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" class="svg-inline--fa fa-long-arrow-alt-left fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"></path></svg>
                    <span class="ml-2 text-xs font-semibold">Back</span>
                </a>
            </div>
        </div>
        <div class="w-full mt-8 bg-white rounded">
            <form action="{{ route('get.history') }}" method="POST" class="md:flex md:items-center md:justify-between px-6 py-6 pb-0">
                @csrf
                <div class="md:flex md:items-center mb-6 text-gray-700 uppercase font-bold">
                    <div>
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Start Academic Year
                        </label>
                    </div>
                    <div class="block text-gray-600 font-bold">
                        <div class="relative">
                            <div class="md:w-2/3">
                                <input name="start_academic_year" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" placeholder="Enter the start academic year" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6 text-gray-700 uppercase font-bold">
                    <div>
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            End Academic Year
                        </label>
                    </div>
                    <div class="block text-gray-600 font-bold">
                        <div class="relative">
                            <div class="md:w-2/3">
                                <input name="end_academic_year" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" placeholder="Enter the end academic year" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Semester
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <div class="relative">
                            <select name="semester" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                                <option value="">--Select Semester--</option>
                                @foreach ($sessions as $session)
                                    <option value="{{ $session->name }}">{{ $session->name }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6 text-gray-700 uppercase font-bold p-4">
                    <button class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">Generate</button>
                </div>
            </form>
        </div>
        @if(isset($records) && count($records) > 0)
        <div class="mt-8">
            <h3 class="text-gray-700 uppercase font-bold mb-4">Payment History</h3>
            <table class="table-auto w-full bg-white rounded">
                <thead>
                    <tr class="text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Start Academic Year</th>
                        <th class="py-3 px-6 text-left">End Academic Year</th>
                        <th class="py-3 px-6 text-left">Semester</th>
                        <th class="py-3 px-6 text-left">Method of Payment</th>
                        <th class="py-3 px-6 text-left">Amount</th>
                        <th class="py-3 px-6 text-left">Balance</th>
                        <th class="py-3 px-6 text-left">Cheque Number</th>
                        <th class="py-3 px-6 text-left">Momo Number</th>
                        <th class="py-3 px-6 text-left">Date/Time</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($records as $record)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">{{ $record->start_academic_year }}</td>
                            <td class="py-3 px-6 text-left">{{ $record->end_academic_year }}</td>
                            <td class="py-3 px-6 text-left">{{ $record->semester }}</td>
                            <td class="py-3 px-6 text-left">{{ $record->method_of_payment }}</td>
                            <td class="py-3 px-6 text-left">{{ $record->amount }}</td>
                            <td class="py-3 px-6 text-left">{{ $record->balance }}</td>
                            <td class="py-3 px-6 text-left">{{ $record->cheque_number}}</td>
                            <td class="py-3 px-6 text-left">{{ $record->Momo_number }}</td>
                            <td class="py-3 px-6 text-left">{{ $record->created_at }}</td>1
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif(isset($records) && count($records) == 0)
        <p class="mt-4 text-red-500">No payment history.</p>
    @endif
</div>

    </div>
@endsection