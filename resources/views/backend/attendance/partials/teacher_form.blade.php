<div class="bg-white rounded-lg shadow p-6">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">
            Attendance for {{ $teacher->user->name }}
        </h3>

        @if($teacher->num_of_sessions > 0)
            <button 
                id="mark_attendance_btn"
                data-id="{{ $teacher->teacher_id }}"
                class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 focus:outline-none"
            >
                ✔ Mark Today's Attendance
            </button>
        @else
            <button 
                class="px-4 py-2 bg-gray-400 text-white text-sm rounded-md cursor-not-allowed"
                disabled
            >
                ❌ No Sessions Left
            </button>
        @endif
    </div>

    <!-- SESSION COUNT -->
    <div class="mb-4">
        <span class="text-sm font-medium text-gray-600">Remaining Monthly Sessions:</span>

        @if($teacher->num_of_sessions > 0)
            <span class="ml-2 px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">
                {{ $teacher->num_of_sessions }}
            </span>
        @else
            <span class="ml-2 px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">
                0
            </span>
        @endif
    </div>

    <!-- RED ALERT WHEN NO SESSIONS LEFT -->
    @if($teacher->num_of_sessions <= 0)
        <div class="mb-4 p-3 bg-red-100 text-red-800 border border-red-300 rounded">
            ⚠ This teacher has <strong>no sessions left</strong> for this month.  
            Attendance cannot be marked.
        </div>
    @endif

    <!-- ATTENDANCE HISTORY -->
    <h4 class="text-md font-semibold text-gray-700 mt-6 mb-2">Attendance History</h4>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Date</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($records as $rec)
                    <tr>
                        <td class="px-4 py-2 text-sm">
                            {{ $rec->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <span class="px-2 py-1 rounded bg-green-100 text-green-700">
                                {{ ucfirst($rec->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
