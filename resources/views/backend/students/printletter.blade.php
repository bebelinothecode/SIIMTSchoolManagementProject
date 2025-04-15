<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Letter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom CSS for printing */
        @media print {
            /* Remove URLs and page numbers */
            @page {
                margin: 0; /* Remove default margins */
                size: A4 portrait; /* Standardize paper size */
            }

            body {
                margin: 2cm; /* Slightly increased margins for better readability */
                font-size: 12pt; /* Ensure consistent font size when printing */
                line-height: 1.5; /* Improve readability */
            }

            /* Hide unnecessary elements */
            .no-print {
                display: none !important;
            }

            /* Ensure the content fits well on the page */
            .print-content {
                width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none; /* Remove shadow when printing */
            }

            /* Prevent page breaks inside important sections */
            .avoid-break {
                page-break-inside: avoid;
            }
            
            /* Ensure tables print properly */
            table {
                border-collapse: collapse;
                width: 100%;
            }
            
            /* Force background colors and images to print */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            /* Ensure black text for better printing */
            p, li, td, th {
                color: black !important;
            }
            
            /* Remove shadow effects for printing */
            .shadow-md {
                box-shadow: none !important;
            }
            
            /* Add border to the whole document for cleaner print */
            .print-content {
                border: 1px solid #ddd;
                padding: 20px;
            }
        }
        
        /* Make table borders darker for better print visibility */
        table, th, td {
            border: 1.5px solid black !important;
        }
        
        /* Add visible section breaks */
        .section-break {
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-8 print-content">
        <!-- Institution Logo -->
        <div class="text-center mb-8 avoid-break">
            <img src="{{ asset('logo/SIIMT-logo.png') }}" alt="SIIMT University College Logo" class="mx-auto h-24">
        </div>

        <!-- Header -->
        <div class="text-center mb-8 avoid-break">
            <h1 class="text-2xl font-bold text-blue-700">SIIMT University College, Ghana</h1>
            <p class="text-gray-800">Hilla Limann Hwy, Accra</p>
            <p class="text-gray-800">Phone: 057 080 1631 | Email: info@siimtuni.edu.gh</p>
        </div>

        <!-- Date -->
        <div class="mb-6">
            <p class="text-gray-800">Date: <span class="font-semibold">{{ date('F d, Y') }}</span></p>
        </div>

        <!-- Greeting -->
        <div class="mb-6">
            <p class="text-gray-800">Dear <span class="font-semibold">{{ $student->user->name }}</span>,</p>
        </div>

        <!-- Admission Title -->
        <div class="mb-6 avoid-break">
            <p class="text-gray-800 font-bold underline">
                ADMISSION TO @if($student->student_category === 'Academic') UNDER-GRADUATE PROGRAMME @else DIPLOMA/PROFESSIONAL PROGRAMME @endif AT SIIMT UNIVERSITY COLLEGE FOR THE <span class="font-semibold">{{ $academicyear->startyear }}-{{ $academicyear->endyear }}</span> ACADEMIC YEAR.
            </p>
        </div>

        <!-- Admission Details -->
        <div class="mb-6 avoid-break">
            <p class="text-gray-800">
                1. This is to inform you that the Academic Board of SIIMT University College has admitted you to pursue a @if($student->student_category === 'Academic') degree programme in {{ $student->course->course_name ?? "N/A" }} level {{ $student->level ?? "N/A" }}, Semester - {{ $student->session ?? "N/A" }} @else Diploma/Professional course in {{ $student->diploma->name ?? "N/A" }} @endif. This will lead to the award of a @if($student->student_category === 'Academic') Bachelor of Science in {{ $student->course->course_name ?? "N/A" }} @else  {{ $student->diploma->name ?? "N/A" }} @endif certificate by the University of Cape-Coast.
            </p>
        </div>

        <!-- Student Details -->
        <div class="mb-6 avoid-break">
            <p class="text-gray-800">Your admission details are as follows:</p>
            <ul class="list-disc pl-5 mt-2">
                <li><strong>Student ID:</strong> {{ $student->index_number }}</li>
                <li><strong>Start Date:</strong> {{ $student->created_at->format('F d, Y') }}</li>
                <li><strong>Student Category:</strong> {{ $student->student_category }}</li>
                <li><strong>Attendance Time:</strong> {{ $student->attendance_time }}</li>
            </ul>
        </div>

        <!-- Scholarship Details -->
        @if($student->Scholarship === 'Yes')
            <div class="mb-6 avoid-break">
                <p class="text-gray-800">
                    2. We are pleased to inform you that the academic board has offered you a scholarship on tuition fees. Please note, however, that the continuation of this scholarship will be based on your academic progress, requiring a GPA of 3.1 or higher every semester.
                    Below is the breakdown of your fees per semester:
                </p>
                <!-- Fees Table -->
                <div class="flex flex-col mt-4">
                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full py-2">
                            <div class="overflow-hidden">
                                <table class="min-w-full border border-black text-center text-sm font-medium text-black">
                                    <thead class="border-b border-black font-medium bg-gray-100">
                                        <tr>
                                            <th scope="col" class="border-e border-black px-4 py-3">Actual Fees per Semester (GHC)</th>
                                            <th scope="col" class="border-e border-black px-4 py-3">Tuition Fees (GHC)</th>
                                            <th scope="col" class="border-e border-black px-4 py-3">Other Charges (GHC)</th>
                                            <th scope="col" class="border-e border-black px-4 py-3">Scholarship (GHC)</th>
                                            <th scope="col" class="border-e border-black px-4 py-3">Amount to be Paid (GHC)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-b border-black">
                                            <td class="whitespace-nowrap border-e border-black px-4 py-3 font-medium">
                                                {{ number_format($student->course->fees ?? $student->diploma->fees, 2) }}
                                            </td>
                                            <td class="whitespace-nowrap border-e border-black px-4 py-3">
                                                @php
                                                    $actualFees = $student->course->fees ?? $student->diploma->fees;
                                                    $charges = 750;
                                                    $amountToPaid = $actualFees - $charges;
                                                @endphp
                                                {{ number_format($amountToPaid, 2) }}
                                            </td>
                                            <td class="whitespace-nowrap border-e border-black px-4 py-3">750.00</td>
                                            <td class="whitespace-nowrap border-e border-black px-4 py-3">
                                                {{ number_format((float)$student->Scholarship_amount, 2) }}
                                            </td>
                                            <td class="whitespace-nowrap border-e border-black px-4 py-3">
                                                @php
                                                    $actualFees = $student->course->fees ?? $student->diploma->fees;
                                                    $scholarshipAmount = $student->Scholarship_amount;
                                                    $amountToPaid = $actualFees - $scholarshipAmount;
                                                @endphp
                                                {{ number_format($amountToPaid, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-gray-800 mt-4">Your school fees per semester is {{ number_format($amountToPaid, 2) }}.</p>
            </div>
        @else
            <div class="mb-6 avoid-break">
                <p class="text-gray-800">
                    {{-- 2. School fees per semester is <span>@if($student->student_category === 'Academic') {{ $student->course->currency ?? "N/A" }}-{{ number_format($student->course->fees, 2) }} @else {{ $student->diploma->currency ?? "N/A" }}-{{ number_format($student->diploma->fees, 2) }} @endif</span>. --}}
                    2. School fees per semester is <span>@if($student->student_category === 'Academic'){{ $student->course->currency ?? "N/A" }}-{{ isset($student->course->fees) ? number_format($student->course->fees, 2) : "N/A" }}
                    @else
                        {{ $student->diploma->currency ?? "N/A" }}-{{ isset($student->diploma->fees) ? number_format($student->diploma->fees, 2) : "N/A" }}
                    @endif
                </p>
            </div>
        @endif

        <!-- Payment Instructions -->
        <div class="mb-6 avoid-break">
            <p class="text-gray-800">
                3. Please note that the tuition fees quoted above include tuition, sundry charges, identity card, and Students Representative Council (SRC) dues. The school fees should be paid into:
            </p>
        </div>

        <!-- Account Details -->
        <div class="mb-6 avoid-break">
            <p class="text-gray-800">4. The account details are as follows:</p>
            <ul class="list-disc pl-5 mt-2">
                <li><strong>ACCOUNT NAME:</strong> SIIMT UNIVERSITY COLLEGE</li>
                <li><strong>BANK NAME:</strong> ECOBANK LTD</li>
                <li><strong>BRANCH:</strong> LABONE</li>
                <li><strong>GH¢ ACCOUNT:</strong> 1441002146601</li>
            </ul>
        </div>

        <div class="section-break"></div>

        <!-- Additional Instructions -->
        <div class="mb-6 avoid-break">
            <p class="text-gray-800">
                5. School resumes for freshmen and women on Monday, 17 February 2025. Course registration starts from Monday, 17 February 2025, to Monday, 24 February 2025, at the Registry. The items to be produced for registration are:
            </p>
        </div>

        <div class="mb-6 avoid-break">
            <p class="text-gray-800">
                6. The original receipt for payment of school fees which will be inspected before registration takes place, and the original letter of admission. 
            </p>
        </div>
        
        <div class="mb-6 avoid-break">
            <p class="text-gray-800">
               7. The University requires that you are declared medically fit by a qualified Medical Officer. This will be arranged by SIIMT University College on the day of Orientation.     
            </p>
        </div>

        <div class="mb-6 avoid-break">
            <p class="text-gray-800">
               8. An orientation programme has been arranged for all freshmen and women to acquaint them with important aspects of University life before the commencement of academic work.  
                All fresh students are expected to participate fully in the Orientation Programme on Friday 28 February 2025 and in all other campus activities.            
            </p>
        </div>

        <div class="mb-6 avoid-break">
            <p class="text-gray-800">
                9. Lectures begin on Monday 24 February 2025.
            </p>
        </div>

        <div class="mb-6 avoid-break">
            <p class="text-gray-800">
                10. School fees will be adjustable based on the economic trend of the country.
            </p>
        </div>

        <div class="mb-6 avoid-break">
            <p class="text-gray-800">
                11. If you accept the terms and conditions in this offer of admission, please arrange to pay, at least, 70% of your fees at any branch of the Ecobank Bank, as indicated in 3 above, and submit the bank's slip to the Finance Office of SIIMT University College for official receipt on or before Monday 24 February 2025.           
             </p>
        </div>

        <div class="mb-6 avoid-break">
            <p class="text-gray-800">
                All correspondences in relation to your admission should be sent to:
            </p>
            <ul class="list-disc pl-5 mt-2">
                <li><strong>THE REGISTRAR,</strong></li>
                <li><strong>SIIMT University College, </strong></li>
                <li><strong> P O BOX CT 139 </strong></li>
                <li><strong>CANTONMENT ACCRA or call 0302 269 885.</strong></li>
            </ul>
        </div>

        <div class="mb-6 avoid-break">
            <p class="text-gray-800">
                We congratulate you on your selection and admission SIIMT University College             
            </p>
        </div>
        
        <div class="mt-8 avoid-break">
            <p class="text-gray-800">Yours Sincerely,</p>
            <p class="text-gray-800 font-semibold mt-4">Yvonne Owiredu (Mrs)</p>
            <p class="text-gray-800">For: REGISTRAR</p>
        </div>
    </div>

    <!-- Print button (will not show when printed) -->
    <div class="text-center mt-6 no-print">
        <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700">
            Print Admission Letter
        </button>
    </div>
</body>
</html>