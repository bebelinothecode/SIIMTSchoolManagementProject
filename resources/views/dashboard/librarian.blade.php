@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h2>

    {{-- Grid Layout --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        {{-- Students Card --}}
        <div class="bg-white shadow-lg rounded-lg p-6 text-center border border-gray-300">
            <h3 class="text-gray-500 uppercase font-bold">Number of Books Uploaded</h3>
            <span class="text-5xl font-bold text-purple-600">{{ 100 }}</span>
        </div>

        {{-- Extra Sections (Can be used for stats or reports) --}}
        <div class="bg-white shadow-lg rounded-lg p-6 text-center border border-gray-300 col-span-1 sm:col-span-2">
            <h3 class="text-gray-500 uppercase font-bold">Recent Activity</h3>
            <ul class="divide-y divide-gray-300 mt-4">
                <li class="py-2">📌 New books were uploaded this week.</li>
                <li class="py-2">📌 {{ count($students) }} students enrolled this semester.</li>
            </ul>
        </div>
    </div>
</div>
@endsection