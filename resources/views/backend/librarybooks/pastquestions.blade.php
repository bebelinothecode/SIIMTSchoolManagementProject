@extends('layouts.app')

@section('content')
    <div class="roles">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Past Questions</h2>
            </div>
            @role('Admin|Librarian')
            <div class="flex flex-wrap items-center">
                <a href="{{ route('upload.pastquestions') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded hover:bg-gray-300 transition">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path>
                    </svg>
                    <span class="ml-2 text-xs font-semibold">Upload Past Question</span>
                </a>
            </div>
            @endrole
        </div>

        <!-- Search Form -->
        <div class="bg-white rounded shadow p-6 mb-8">
            <h3 class="text-gray-700 font-bold mb-4">Search Past Questions</h3>
            <form action="{{ route('search.questions') }}" method="POST" class="w-full max-w-xl">
                @csrf
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Year of Exams
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="year_of_exams" id="year_of_exams" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number" required>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Course Name
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="course_name" id="course_name" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" required>
                    </div>
                </div>
                <div class="md:flex md:items-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3">
                        <button class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded transition" type="submit">
                            Search
                        </button>
                    </div>
                </div>
            </form> 
            <div class="px-6 pb-6">
            <a href="{{ route('past.questions') }} " class="text-sm text-blue-500 hover:underline">
                View All Past Questions
            </a>
        </div>       
        </div>

        <!-- Results Section -->
        @if(isset($pastQuestions) && count($pastQuestions) > 0)
                <div class="bg-white rounded shadow overflow-hidden">
                    <h3 class="text-gray-700 uppercase font-bold p-6">Search Results</h3>
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr class="text-gray-700 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Year of Exams</th>
                                <th class="py-3 px-6 text-left">Course Name</th>
                                <th class="py-3 px-6 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach($pastQuestions as $pastQuestion)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6">{{ $pastQuestion->year_of_exams }}</td>
                                    <td class="py-3 px-6">{{ $pastQuestion->course_name }}</td>
                                    <td class="py-3 px-6">
                                        <a href="{{ route('questions.view', $pastQuestion->id) }}"
                                           class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded text-sm transition"
                                           target="_blank"
                                           aria-label="View past question">
                                            Download
                                        </a>
                                    </td>
                                    @hasrole('Admin|rector|Librarian')
                                    <td class="py-3 px-2">
                                        <form action="{{ route('pastquestions.delete', $pastQuestion->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-block px-2 py-2 bg-red-600 text-white rounded hover:bg-green-700 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                    @endhasrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @elseif(isset($pastQuestions))
                <div class="bg-white rounded shadow p-6 text-center">
                    <p class="text-red-500">No past questions found for the selected criteria.</p>
                </div>
                @endif
                </div>
            @endsection


