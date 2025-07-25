@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Promote Students</h1>

    <!-- Promotion Form -->
    <form action="{{route('students.promote')}} " method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        <!-- Current Level -->
        <div class="mb-4">
            <label for="current_level" class="block text-gray-700 text-sm font-bold mb-2">Current Level</label>
            <select name="current_level" id="current_level" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">Select Current Level</option>
                @foreach ($levels as $level)
                    <option value="{{ $level->name }}">{{ $level->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Current Semester -->
        <div class="mb-4">
            <label for="current_semester" class="block text-gray-700 text-sm font-bold mb-2">Current Semester</label>
            <select name="current_semester" id="current_semester" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">Select Current Semester</option>
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->name }}">{{ $semester->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Target Level -->
        <div class="mb-4">
            <label for="target_level" class="block text-gray-700 text-sm font-bold mb-2">Target Level</label>
            <select id="target_level_display" disabled class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Select Target Level</option>
                @foreach ($levels as $level)
                    <option value="{{ $level->name }}">{{ $level->name }}</option>
                @endforeach
            </select>
            <input type="hidden" name="target_level" id="target_level">
        </div>

        <!-- Target Semester -->
        <div class="mb-6">
            <label for="target_semester" class="block text-gray-700 text-sm font-bold mb-2">Target Semester</label>
            <select id="target_semester_display" disabled class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Select Target Semester</option>
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->name }}">{{ $semester->name }}</option>
                @endforeach
            </select>
            <input type="hidden" name="target_semester" id="target_semester">
        </div>


        <!-- Submit Button -->
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Promote Students
            </button>
        </div>
    </form>

    <!-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        const currentLevel = document.getElementById('current_level');
        const currentSemester = document.getElementById('current_semester');
        const targetLevel = document.getElementById('target_level');
        const targetSemester = document.getElementById('target_semester');

        function autoSetTargetFields() {
            const level = currentLevel.value;
            const semester = currentSemester.value;

            if (!level || !semester) {
                targetLevel.value = '';
                targetSemester.value = '';
                return;
            }

            const numericLevel = parseInt(level);
            const numericSemester = parseInt(semester);

            if (isNaN(numericLevel) || isNaN(numericSemester)) {
                targetLevel.value = '';
                targetSemester.value = '';
                return;
            }

            let nextLevel = numericLevel;
            let nextSemester = numericSemester;

            if (numericSemester === 1) {
                nextSemester = 2;
            } else if (numericSemester === 2) {
                nextSemester = 1;
                nextLevel = numericLevel + 100;
            }

            targetLevel.value = nextLevel.toString();
            targetSemester.value = nextSemester.toString();
        }

        currentLevel.addEventListener('change', autoSetTargetFields);
        currentSemester.addEventListener('change', autoSetTargetFields);
    });
</script> -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const currentLevel = document.getElementById('current_level');
            const currentSemester = document.getElementById('current_semester');
            const targetLevelHidden = document.getElementById('target_level');
            const targetSemesterHidden = document.getElementById('target_semester');
            const targetLevelDisplay = document.getElementById('target_level_display');
            const targetSemesterDisplay = document.getElementById('target_semester_display');

            function autoSetTargetFields() {
                const level = currentLevel.value;
                const semester = currentSemester.value;

                if (!level || !semester) {
                    targetLevelHidden.value = '';
                    targetSemesterHidden.value = '';
                    targetLevelDisplay.value = '';
                    targetSemesterDisplay.value = '';
                    return;
                }

                const numericLevel = parseInt(level);
                const numericSemester = parseInt(semester);

                if (isNaN(numericLevel) || isNaN(numericSemester)) {
                    targetLevelHidden.value = '';
                    targetSemesterHidden.value = '';
                    targetLevelDisplay.value = '';
                    targetSemesterDisplay.value = '';
                    return;
                }

                let nextLevel = numericLevel;
                let nextSemester = numericSemester;

                if (numericSemester === 1) {
                    nextSemester = 2;
                } else if (numericSemester === 2) {
                    nextSemester = 1;
                    nextLevel = numericLevel + 100;
                }

                targetLevelHidden.value = nextLevel.toString();
                targetSemesterHidden.value = nextSemester.toString();
                targetLevelDisplay.value = nextLevel.toString();
                targetSemesterDisplay.value = nextSemester.toString();
            }

            currentLevel.addEventListener('change', autoSetTargetFields);
            currentSemester.addEventListener('change', autoSetTargetFields);
        });

    </script>



    @if (session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    @if (session('failure'))
    <script>
        Swal.fire({
            title: 'Failure!',
            text: '{{ session('failure') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
    @endif
    @if (session('duplicate'))
    <script>
        Swal.fire({
            title: 'Failure!',
            text: '{{ session('duplicate') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
    @endif
    @if (session('error'))
    <script>
        Swal.fire({
            title: 'Error3!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
    @endif
</div>
@endsection