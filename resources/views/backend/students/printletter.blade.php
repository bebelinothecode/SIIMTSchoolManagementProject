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
            <p class="text-gray-700">
                Congratulations! We are delighted to inform you that you have been offered admission to
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
                {{-- <li><strong>Admission Fee:</strong> {{ $admissionFee }}</li> --}}
            </ul>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">
                Please visit our administrative office or use the provided online portal to complete the necessary enrollment process. Ensure that all required documents are submitted.
            </p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">
                We look forward to welcoming you to our school community. Should you have any questions, please do not hesitate to contact us.
            </p>
        </div>

        <div class="mt-8">
            <p class="text-gray-700">Sincerely,</p>
            <p class="text-gray-700 font-semibold mt-4">[Principal's Name]</p>
            <p class="text-gray-500">Principal</p>
        </div>
    </div>
</body>
</html>
