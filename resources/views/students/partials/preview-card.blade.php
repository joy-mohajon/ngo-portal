@props(['student'])
<a href="{{ route('students.show', $student) }}"
   class="block bg-white rounded-xl shadow-sm hover:shadow-lg transition transform hover:-translate-y-1 p-4 group cursor-pointer border border-gray-100 hover:border-indigo-300 relative overflow-hidden">
    <div class="flex items-center space-x-4">
        @if($student->photo)
            <img src="{{ asset('storage/'.$student->photo) }}" alt="{{ $student->name }}"
                 class="h-14 w-14 rounded-full object-cover border-2 border-white shadow-md">
        @else
            <div class="h-14 w-14 rounded-full bg-gray-50 flex items-center justify-center border-2 border-gray-200 shadow-sm">
                <svg class="h-8 w-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="12" cy="12" r="12" fill="#f3f4f6" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="#6366f1" />
                </svg>
            </div>
        @endif
        <div class="flex-1 min-w-0">
            <div class="text-lg font-semibold text-gray-900 truncate group-hover:text-indigo-700">{{ $student->name }}</div>
            <div class="text-xs text-indigo-600 font-medium truncate">{{ $student->education_level ?? 'N/A' }}</div>
            <div class="text-xs text-gray-500 truncate">{{ $student->education_institution ?? $student->address ?? 'N/A' }}</div>
        </div>
    </div>
    <div class="absolute inset-0 pointer-events-none rounded-xl group-hover:ring-2 group-hover:ring-indigo-100 transition"></div>
</a> 