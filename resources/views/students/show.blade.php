<x-app-layout>
    <div class="bg-white rounded-lg shadow overflow-hidden mx-auto">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Student Details</h2>
            <div class="flex space-x-2">
                <a href="{{ route('students.edit', $student) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md flex items-center">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <form action="{{ route('students.destroy', $student) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this student?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md flex items-center">
                        <i class="fas fa-trash mr-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="px-6 py-4">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Left Column - Photo and Basic Info -->
                <div class="w-full md:w-1/3 space-y-6">
                    <!-- Student Photo -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        @if($student->photo)
                        <img src="{{ asset('storage/'.$student->photo) }}" alt="Student Photo"
                            class="w-full h-64 object-cover rounded-lg shadow">
                        @else
                        <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user text-gray-400 text-6xl"></i>
                        </div>
                        @endif
                    </div>

                    <!-- Status and Documents -->
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <!-- Status Badge -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Status</h3>
                            @php
                            $statusClasses = [
                            'active' => 'bg-green-100 text-green-800',
                            'inactive' => 'bg-gray-100 text-gray-800',
                            'graduated' => 'bg-purple-100 text-purple-800',
                            'dropped' => 'bg-red-100 text-red-800',
                            ];
                            @endphp
                            <span
                                class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusClasses[$student->status] }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </div>

                        <!-- Documents -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Documents</h3>
                            <ul class="space-y-2">
                                @if($student->national_id_file)
                                <li>
                                    <a href="{{ asset('storage/'.$student->national_id_file) }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-800 flex items-center">
                                        <i class="fas fa-id-card mr-2"></i> National ID
                                    </a>
                                </li>
                                @endif
                                @if($student->birth_certificate_file)
                                <li>
                                    <a href="{{ asset('storage/'.$student->birth_certificate_file) }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-800 flex items-center">
                                        <i class="fas fa-certificate mr-2"></i> Birth Certificate
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>

                        <!-- Enrollment Date -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Enrollment Date</h3>
                            <p class="text-sm text-gray-900">
                                {{ $student->enrollment_date ? $student->enrollment_date->format('M d, Y') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Detailed Information -->
                <div class="w-full md:w-2/3 space-y-6">
                    <!-- Personal Information Card -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Full Name</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $student->name }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Date of Birth</h4>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $student->date_of_birth ? $student->date_of_birth->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Gender</h4>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $student->gender ? ucfirst($student->gender) : 'N/A' }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">National ID</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $student->national_id ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Birth Certificate No.</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $student->birth_certificate_number ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Batch</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $student->batch ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Card -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Contact Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Email</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $student->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $student->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <h4 class="text-sm font-medium text-gray-500">Address</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $student->address ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Guardian Information Card -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Guardian Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Guardian Name</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $student->guardian_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Guardian Phone</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $student->guardian_phone ?? 'N/A' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <h4 class="text-sm font-medium text-gray-500">Guardian Address</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $student->guardian_address ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Education Information Card -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Education Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Education Level</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $student->education_level ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Institution</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $student->education_institution ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Projects Card -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Project Assignments</h3>
                        @if($student->projects->count() > 0)
                        <div class="space-y-4">
                            @foreach($student->projects as $project)
                            <div class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                                <h4 class="text-md font-medium text-blue-600">
                                    <a href="{{ route('projects.show', $project) }}" class="hover:underline">{{ $project->title }}</a>
                                </h4>
                                <div class="text-xs text-gray-500 mt-1 mb-2">
                                    <span class="mr-2"><strong>Donner NGO:</strong> {{ $project->donner?->name ?? '-' }}</span>
                                    <span><strong>Runner NGO:</strong> {{ $project->runner?->name ?? '-' }}</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
                                    <div>
                                        <span class="text-xs font-medium text-gray-500">Enrollment:</span>
                                        <span class="text-xs text-gray-900 ml-1">
                                            {{ $project->pivot->enrollment_date ? \Carbon\Carbon::parse($project->pivot->enrollment_date)->format('d M Y') : 'N/A' }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-xs font-medium text-gray-500">Status:</span>
                                        @php
                                        $projectStatusClasses = [
                                        'active' => 'bg-green-100 text-green-800',
                                        'completed' => 'bg-blue-100 text-blue-800',
                                        'dropped' => 'bg-red-100 text-red-800',
                                        ];
                                        @endphp
                                        <span
                                            class="text-xs px-2 py-1 rounded-full {{ $projectStatusClasses[$project->pivot->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($project->pivot->status) }}
                                        </span>
                                    </div>
                                    @if($project->pivot->completion_date)
                                    <div>
                                        <span class="text-xs font-medium text-gray-500">Completion:</span>
                                        <span class="text-xs text-gray-900 ml-1">
                                            {{ $project->pivot->completion_date ? \Carbon\Carbon::parse($project->pivot->completion_date)->format('d M Y') : 'N/A' }}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                                @if($project->pivot->notes)
                                <div class="mt-2">
                                    <p class="text-xs text-gray-600">{{ $project->pivot->notes }}</p>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-sm text-gray-500">This student is not assigned to any projects yet.</p>
                        @endif
                    </div>

                    <!-- Notes Card -->
                    @if($student->notes)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Additional Notes</h3>
                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $student->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>