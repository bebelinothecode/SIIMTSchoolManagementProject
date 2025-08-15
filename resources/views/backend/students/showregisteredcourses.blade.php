@extends('layouts.app')

@section('content')
    <div class="roles">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Registered Courses</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{ url()->previous() }}" 
                   class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" xmlns="http://www.w3.org/2000/svg" 
                         viewBox="0 0 448 512">
                        <path fill="currentColor" 
                              d="M134.059 296H436c6.627 0 12-5.373 12-12v-56
                                 c0-6.627-5.373-12-12-12H134.059v-46.059
                                 c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029
                                 c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059
                                 c15.119 15.119 40.971 4.411 40.971-16.971V296z">
                        </path>
                    </svg>
                    <span class="ml-2 text-xs font-semibold">Back</span>
                </a>

                {{-- Print Button --}}
                <button onclick="printPage()" 
                        class="bg-blue-500 text-white text-sm uppercase py-2 px-4 flex items-center rounded ml-2">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" 
                         stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 9V2h12v7M6 18h12v4H6v-4zM6 14h.01M18 14h.01"></path>
                    </svg>
                    Print
                </button>
            </div>
        </div>

        {{-- Printable Content --}}
        <div id="printArea" class="p-8 bg-white">
            {{-- Header --}}
            <div class="text-center mb-6">
                <div class="logo-container flex justify-center mb-3">
                    <img src="{{asset('logo\SIIMT-logo.png')}}" alt="Institution Logo" class="logo w-20 h-auto">
                </div>
                <h1 class="text-2xl font-bold uppercase">SIIMT University College, Ghana</h1>
                <p class="text-sm">Hilla Limann Hwy, Accra</p>
                <p class="text-sm">Tel: {{ $studentData->phone }} | Email: {{$userData->email}}</p>
                <hr class="mt-4 border-t-2 border-black">
            </div>

            {{-- Student Info --}}
            <div class="mb-4 text-sm">
                <p><strong>Student Name:</strong> {{ $userData->name ?? 'N/A' }}</p>
                <p><strong>Index Number:</strong> {{ $studentData->index_number ?? 'N/A' }}</p>
                <p><strong>Programme:</strong> {{ $student->course_name ?? 'N/A' }}</p>
                <p><strong>Academic Year:</strong> {{ date('Y') }}</p>
            </div>

            {{-- Courses Table --}}
            @if($students->isEmpty())
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
                    <p>No registered courses found for this student.</p>
                </div>
            @else
                <table class="min-w-full border border-gray-700 text-sm">
                    <thead>
                        <tr class="bg-gray-200 border-b border-gray-700">
                            <th class="px-4 py-2 border border-gray-700 text-left">Course Name</th>
                            <th class="px-4 py-2 border border-gray-700 text-left">Subject Name</th>
                            <th class="px-4 py-2 border border-gray-700 text-left">Credit Hours</th>
                            <th class="px-4 py-2 border border-gray-700 text-left">Level</th>
                            <th class="px-4 py-2 border border-gray-700 text-left">Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $course)
                            <tr>
                                <td class="px-4 py-2 border border-gray-700">{{ $course->course_name }}</td>
                                <td class="px-4 py-2 border border-gray-700">{{ $course->subject_name }}</td>
                                <td class="px-4 py-2 border border-gray-700">{{ $course->credit_hours }}</td>
                                <td class="px-4 py-2 border border-gray-700">{{ $course->level }}</td>
                                <td class="px-4 py-2 border border-gray-700">{{ $course->semester }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            {{-- Footer --}}
            <div class="mt-6 text-sm flex justify-between">
                <p><strong>Date Printed:</strong> {{ date('d M Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Print Styling --}}
    <style>
    @media print {
        @page {
            margin: 0; /* remove default print margins */
        }

        header, footer {
            display: none !important; /* hides default print headers/footers */
        }

        body {
            font-family: Arial, sans-serif;
            color: black;
            margin: 0;
            padding: 0;
            background: white;
        }

        * {
        box-shadow: none !important;
        border: none;
        }

        button, a {
            display: none !important;
        }

        #printArea {
            width: 210mm; /* A4 width */
            min-height: 297mm; /* A4 height */
            margin: auto;
            padding: 20mm;
            box-sizing: border-box;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
        }

        th, td {
            padding: 6px;
            text-align: left;
            border: 1px solid black;
        }

        /* Scale down to fit one page if content is large */
        html, body {
            zoom: 95%;
        }
    }
    </style>

    {{-- Print Script --}}
    <script>
    function printPage() {
        let printContents = document.getElementById('printArea').innerHTML;
        let originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        window.location.reload();
    }
    </script>
@endsection



