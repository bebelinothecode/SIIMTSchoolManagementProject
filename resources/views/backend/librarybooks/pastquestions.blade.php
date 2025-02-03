@extends('layouts.app')

@section('content')
    <div class="roles">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Past Questions</h2>
            </div>
            @role('Admin')
            <div class="flex flex-wrap items-center">
                <a href="{{route('upload.pastquestions')}}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
                    <span class="ml-2 text-xs font-semibold">Upload Past Question</span>
                </a>
            </div>
            @endrole
        </div>
        <div class="table w-full mt-8 bg-white rounded">
            <form action="{{route('search.questions')}} " method="POST" class="w-full max-w-xl px-6 py-12" enctype="multipart/form-data">
                @csrf
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Year of Exams
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <input name="year_of_exams" id="year_of_exams" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number"  required>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                            Course Name
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="course_name" id="course_name" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text"  required>
                    </div>
                </div>
                <div class="md:flex md:items-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3">
                        <button class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                            Search
                        </button>
                    </div>
                </div>
            </form>        
        </div>
        @if(isset($results) && count($results) > 0)
        <div class="mt-8">
            <h3 class="text-gray-700 uppercase font-bold mb-4">Past Questions</h3>
            <table class="table-auto w-full bg-white rounded">
                <thead>
                    <tr class="text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Year of Exams</th>
                        <th class="py-3 px-6 text-left">Course Name</th>
                        <th class="py-3 px-6 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($results as $result)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">{{ $result->year_of_exams }}</td>
                            <td class="py-3 px-6 text-left">{{ $result->course_name }}</td>
                            <td class="px-2 py-2 whitespace-no-wrap border-b border-gray-500">
                                <a href="{{ route('questions.view', $result->id) }}"
                                    class="inline-block px-2 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition"
                                    target="_blank">
                                     View Online
                                 </a>
                            </td>
                            {{-- <td class="py-3 px-6 text-left">{{ $result->exams_paper }}</td> --}}
                            {{-- <td class="py-3 px-6 text-left">{{ $defaulter->balance }}</td> --}}
                        </tr>
                    @endforeach
                </tbody>                                                                          
            </table>
        </div>
    @elseif(isset($esults))
        <p class="mt-4 text-red-500">No past questions found for the selected criteria.</p>
    @endif
    </div>
@endsection

