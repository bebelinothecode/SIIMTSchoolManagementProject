<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Letter</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-blue-700">SIIMT University College, Ghana</h1>
            <p class="text-gray-500">Hilla Limann Hwy, Accra</p>
            <p class="text-gray-500">Phone: 057 080 1631 | Email: info@siimtuni.edu.gh</p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">Date: <span class="font-semibold">{{ date('F d, Y') }}</span></p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">Dear <span class="font-semibold">{{ $student->user->name }}</span>,</p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700 font-bold underline">
                ADMISSION TO @if($student->student_category === 'Academic')UNDER-GRADUATE   PROGRAMME @else DIPLOMA/PROFESSIONAL PROGRAMME @endif AT SIIMT UNIVERSITY COLLEGE FOR THE <span class="font-semibold">{{$academicyear->startyear}}-{{$academicyear->endyear}}</span> ACADEMIC YEAR.
            </p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">
                1.  This is to inform you that the Academic Board of SIIMT University College has admitted you to pursue a @if($student->student_category === 'Academic') degree programme in {{$student->course->course_name}} level  {{$student->level}}, Semester - {{$student->session ?? "N/A"}},  @else Diploma/Professional course in {{$student->diploma->name}} @endif .  This will lead to the award of a Bachelor of Science in @if($student->student_category === 'Academic') {{$student->course->course_name}} @else Diploma/Professional course in {{$student->diploma->name}} @endif certificate by the University of Cape-Coast.                 
                <span class="font-semibold">SIIMT University College</span> for the <span class="font-semibold">{{ $student->academicyear }}</span> academic year.
            </p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">
                Your admission details are as follows:
            </p>
            <ul class="list-disc pl-5 mt-2">
                {{-- <li><strong>Program:</strong> {{ $program }}</li> --}}
                <li><strong>Student ID:</strong> {{ $student->index_number }}</li>
                <li><strong>Start Date:</strong> {{ $student->created_at }}</li>
                <li><strong>Student Category:</strong> {{ $student->student_category }}</li>
                <li><strong>Attendance Time:</strong> {{ $student->attendance_time }}</li>
                {{-- <li><strong>Admission Fee:</strong> {{ $admissionFee }}</li> --}}
            </ul>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">
                Please your student number and programme of study should be quoted on all official documents.
            </p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">
                2.  School fees per semester is <span>@if($student->student_category === 'Academic'){{$student->course->currency}}-{{$student->course->fees}} @else {{$student->diploma->currency}}-{{$student->diploma->fees}} @endif</span>
            </p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">
                3. Please note that the tuition fees quoted above includes tuition, sundry charges, identity card and   
                Students Representative Council (SRC) Dues. The School fees of Four Thousand Two Hundred Ghana Cedis (GH¢4,200.00) should be paid   
                into:             
            </p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">
               4.  The account details are as follows:
            </p>
            <ul class="list-disc pl-5 mt-2">
                {{-- <li><strong>Program:</strong> {{ $program }}</li> --}}
                <li><strong>ACCOUNT NAME:</strong> SIIMT UNIVERSITY COLLEGE</li>
                <li><strong>BANK NAME:</strong>ECOBANK LTD</li>
                <li><strong>BRANCH:</strong> LABONE</li>
                <li><strong>GH¢ ACCOUNT:</strong> 1441002146601</li>
            </ul>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">
                5. School resumes for freshmen and women on Monday 17 February 2025.  Course registration starts from Monday 17 February 2025 to Monday 24 February 2025 at the Registry. The items to be produced for registration are:
            </p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">
                6. The original receipt for payment of school fees which will be inspected before registration takes place, and the original letter of admission. 
            </p>
        </div>
        
        <div class="mb-6">
            <p class="text-gray-700">
               7. The University requires that you are declared medically fit by a qualified Medical Officer.  This will be arranged by SIIMT University College on the day of Orientation.     
            </p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">
               8. An orientation programme has been arranged for all freshmen and women to acquaint them with important aspects of University life before the commencement of academic work.  
                All fresh students are expected to participate fully in the Orientation Programme on Friday 28 February 2025 and in all other campus activities.            
            </p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">
                9. Lectures begin on Monday 24 February 2025.
            </p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">
                10. School fees will be adjustable based on the economic trend of the country.
            </p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">
                11. If you accept the terms and conditions in this offer of admission, please arrange to pay, at least, 70% of your fees at any branch of the Ecobank Bank, as indicated in 3 above, and submit the bank’s slip to the Finance Office of SIIMT University College for official receipt on or before Monday 24 February 2025.           
             </p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">
                All correspondences in relation to your admission should be sent to:
            </p>
            <ul class="list-disc pl-5 mt-2">
                <li><strong>THE REGISTRAR,</strong></li>
                <li><strong>SIIMT University College, </strong></li>
                <li><strong> P O BOX CT 139 </strong></li>
                <li><strong>CANTONMENT ACCRA or call 0302 269 885.</strong></li>
            </ul>
            </p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">
                We congratulate you on your selection and admission SIIMT University College             
            </p>
        </div>
        
        <div class="mt-8">
            <p class="text-gray-700">Yours Sincerely,</p>
            <p class="text-gray-700 font-semibold mt-4">Yvonne Owiredu (Mrs)</p>
            <p class="text-gray-500">For
                REGISTRAR
        </p>
        </div>
    </div>
</body>
</html>
