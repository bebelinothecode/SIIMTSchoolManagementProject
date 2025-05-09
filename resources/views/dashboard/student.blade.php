<div class="bg-gradient-to-tr from-blue-100 via-white to-blue-100 rounded-xl shadow-xl overflow-hidden mt-8">
    <div class="w-full max-w-5xl mx-auto px-8 py-10">
        <h2 class="text-2xl font-extrabold text-gray-800 mb-6 border-b border-blue-300 pb-2">
            🎓 Student Profile
        </h2>

        <!-- Student Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500 font-semibold">Name</p>
                <p class="text-lg font-bold text-gray-700">{{ $student->user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-semibold">Email</p>
                <p class="text-lg font-bold text-gray-700">{{ $student->user->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-semibold">Index Number</p>
                <p class="text-lg font-bold text-gray-700">{{ $student->index_number ?? 'Index number not found' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-semibold">Phone</p>
                <p class="text-lg font-bold text-gray-700">{{ $student->phone }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-semibold">Gender</p>
                <p class="text-lg font-bold text-gray-700">{{ $student->gender }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-semibold">Date of Birth</p>
                <p class="text-lg font-bold text-gray-700">{{ $student->dateofbirth }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-semibold">Current Address</p>
                <p class="text-lg font-bold text-gray-700">{{ $student->current_address }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-semibold">Student Type</p>
                <p class="text-lg font-bold text-gray-700">{{ $student->student_type }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-semibold">Admission Date</p>
                <p class="text-lg font-bold text-gray-700">{{ $student->created_at }}</p>
            </div>
        </div>

        <!-- Divider -->
        <!-- <div class="my-10 border-t border-gray-300"></div> -->

        <!-- Attendance Section -->
        <!-- <h3 class="text-xl font-bold text-blue-700 mb-4">📅 Attendance Record</h3>
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full text-left text-gray-700 border-collapse">
                <thead class="bg-blue-50 text-blue-700">
                    <tr>
                        <th class="px-4 py-2 font-semibold">Date</th>
                        <th class="px-4 py-2 font-semibold">Class</th>
                        <th class="px-4 py-2 font-semibold">Teacher</th>
                        <th class="px-4 py-2 font-semibold text-right">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student->attendances as $attendance)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $attendance->attendence_date }}</td>
                            <td class="px-4 py-2">{{ $attendance->class->class_name }}</td>
                            <td class="px-4 py-2">{{ $attendance->teacher->user->name }}</td>
                            <td class="px-4 py-2 text-right">
                                @if($attendance->attendence_status)
                                    <span class="inline-block px-2 py-1 text-xs font-bold text-white bg-green-500 rounded">P</span>
                                @else
                                    <span class="inline-block px-2 py-1 text-xs font-bold text-white bg-red-500 rounded">A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> -->

        <!-- Parent Info Placeholder -->
        <!-- <div class="mt-10 text-sm text-gray-500 italic">
            * Parent details are currently unavailable.
        </div> -->
    </div>
</div>
