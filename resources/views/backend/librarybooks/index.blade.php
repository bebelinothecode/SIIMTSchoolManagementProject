@extends('layouts.app')

@section('content')
    <div class="roles-permissions">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Library & Books</h2>
            </div>
            @role('Admin')
            <div class="flex flex-wrap items-center">
                <a href="/createbook" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
                    <span class="ml-2 text-xs font-semibold">Book</span>
                </a>
            </div>
            @endrole
        </div>
    <div class="create">
        <div class="w-full mt-8 bg-white rounded">
            <form action="{{ route('search.books.admin') }}" method="POST" class="md:flex md:items-center md:justify-start px-6 py-6 pb-0 ">
                @csrf
                <div class="md:flex md:items-center mb-6 text-gray-700 uppercase font-bold">
                    <div>
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Enter ISBN/Author/Title
                        </label>
                    </div>
                    <div class="block text-gray-600 font-bold">
                        <div class="relative">
                            <div class="md:w-full">
                                <input 
                                    name="search_term" 
                                    class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-[400px] py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" 
                                    type="text" 
                                    placeholder="ISBN/Author/Title" 
                                    required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:flex md:items-center text-gray-700 uppercase font-bold p-3 mb-6">
                    <button class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">Search</button>
                </div>
            </form>
        </div>
        
        @if(isset($books) && count($books) > 0)
        <div class="mt-8">
            <h3 class="text-gray-700 uppercase font-bold mb-4">Books List</h3>
            <table class="table-auto w-full bg-white rounded">
                <thead>
                    <tr class="text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Title</th>
                        <th class="py-3 px-6 text-left">Author</th>
                        <th class="py-3 px-6 text-left">ISBN Number</th>
                        <th class="py-3 px-6 text-left">Publisher</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($books as $book)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">{{ $book->title }}</td>
                            <td class="py-3 px-6 text-left">{{ $book->author ?? 'No author found' }}</td>
                            <td class="py-3 px-6 text-left">{{ $book->isbn_number ?? "No ISBN Number found" }}</td>
                            <td class="py-3 px-6 text-left">{{ $book->publisher ?? "No Publisher found" }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                <a href="{{ route('books.download', $book->id) }}" 
                                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded">
                                    Download
                                </a>
                            </td>
                            <td class="px-2 py-2 whitespace-no-wrap border-b border-gray-500">
                                <a href="{{ route('books.view', $book->id) }}"
                                    class="inline-block px-2 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition"
                                    target="_blank">
                                     View Online
                                 </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif(isset($books))
        <p class="mt-4 text-red-500">No books found for the selected criteria.</p>
    @endif
</div>

</div>

</div>
@endsection
