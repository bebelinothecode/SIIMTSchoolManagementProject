@extends('layouts.app')

@section('content')
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('teacher.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                </svg>
                <span>Back to Teachers</span>
            </a>
        </div>

        <!-- Profile Card -->
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
                <div class="flex items-center space-x-6">
                    <!-- Profile Picture -->
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg">
                        <img src="{{ $teacher->user->profile_picture ?? 'https://via.placeholder.com/150' }}" alt="Profile Picture" class="w-full h-full object-cover">
                    </div>
                    <!-- User Info -->
                    <div>
                        <h1 class="m-2 text-3xl font-bold text-black">{{ $teacher->user->name ?? 'No Name' }}</h1>
                        <p class="text-sm text-black">{{ $teacher->user->email ?? 'No Email' }}</p>
                    </div>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Profile Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date of Birth -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Date of Birth</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $teacher->dateofbirth ?? 'No data available' }}</p>
                    </div>
                    <!-- Address -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Current Address</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $teacher->current_address ?? 'No data available' }}</p>
                    </div>
                    <!-- Gender -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Gender</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $teacher->gender ?? 'No data available' }}</p>
                    </div>
                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Phone</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $teacher->phone ?? 'No data available' }}</p>
                    </div>
                </div>
            </div>

            <!-- Subject Details -->
            <div class="p-6 border-t border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Subject Details</h2>
                @if($teacher->subjects)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Subject Name</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $teacher->subjects->subject_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Subject Code</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $teacher->subjects->subject_code }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Semester</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $teacher->subjects->semester }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Level</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $teacher->subjects->level }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Credit Hours</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $teacher->subjects->credit_hours }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-600">No subject assigned to this teacher.</p>
                @endif
            </div>
        </div>
    </div>
</body>
@endsection