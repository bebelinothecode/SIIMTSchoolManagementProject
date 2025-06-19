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

        
        


        
    </div>
</div>
