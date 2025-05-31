<x-app-layout>
    <div class="bg-white rounded-lg shadow overflow-visible">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Students</h2>
            @hasrole('ngo')
            <a href="{{ route('students.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fas fa-plus mr-2"></i> Add Student
            </a>
            @endhasrole
        </div>

        <!-- Search and Filter Section -->
        <div class="px-6 py-4 bg-gray-50">
            <form action="{{ route('students.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Name, Email, Phone, ID, Birth Certificate No."
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                            <option value="graduated" {{ request('status') == 'graduated' ? 'selected' : '' }}>Graduated
                            </option>
                            <option value="dropped" {{ request('status') == 'dropped' ? 'selected' : '' }}>Dropped
                            </option>
                        </select>
                    </div>
                    <div>
                        <label for="project_id" class="block text-sm font-medium text-gray-700">Project</label>
                        <select name="project_id" id="project_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Projects</option>
                            @foreach($projects as $project)
                            <option value="{{ $project->id }}"
                                {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="batch" class="block text-sm font-medium text-gray-700">Batch</label>
                        <select name="batch" id="batch"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Batches</option>
                            @foreach($batches as $batch)
                            <option value="{{ $batch }}" {{ request('batch') == $batch ? 'selected' : '' }}>
                                {{ $batch }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                        <select name="gender" id="gender"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Genders</option>
                            <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="bg-indigo-600 text-center hover:bg-indigo-700 text-white px-4 py-2 rounded-md mr-2 whitespace-nowrap">
                            <i class="fas fa-search mr-1"></i> Search
                        </button>
                        <a href="{{ route('students.index') }}"
                            class="bg-gray-500 whitespace-nowrap text-center hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                            <i class="fas fa-redo mr-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 w-full">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
            @endif

            <!-- Search results summary if search was performed -->
            @if(request()->has('search') || request()->has('status') || request()->has('project_id') ||
            request()->has('batch') || request()->has('gender'))
            <div class="mb-4 text-sm text-gray-600">
                <p>
                    @if(request()->has('search')) Search: <span class="font-semibold">{{ request('search') }}</span>
                    @endif
                    @if(request()->has('status') && request('status') != '') Status: <span
                        class="font-semibold">{{ ucfirst(request('status')) }}</span> @endif
                    @if(request()->has('project_id') && request('project_id') != '')
                    Project: <span class="font-semibold">
                        {{ App\Models\Project::find(request('project_id'))?->title ?? 'Unknown' }}
                    </span>
                    @endif
                    @if(request()->has('batch') && request('batch') != '')
                    Batch: <span class="font-semibold">{{ request('batch') }}</span>
                    @endif
                    @if(request()->has('gender') && request('gender') != '')
                    Gender: <span class="font-semibold">{{ ucfirst(request('gender')) }}</span>
                    @endif
                    ({{ $students->total() }} results)
                </p>
            </div>
            @endif

            <div class="w-full border border-gray-200 rounded-lg">
                <table class="w-full divide-y divide-gray-200 table-fixed">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                style="width: 80px">
                                Photo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Contact</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                Projects</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                style="width: 100px">
                                Batch</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                style="width: 100px">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                style="width: 100px">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($students as $student)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($student->photo)
                                <img src="{{ asset('storage/'.$student->photo) }}" alt="Student Photo"
                                    class="h-10 w-10 rounded-full object-cover">
                                @else
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                <div class="text-sm text-gray-500 ">
                                    @if($student->national_id)
                                    ID: {{ $student->national_id }}
                                    @endif
                                    @if($student->birth_certificate_number)
                                    @if($student->national_id) | <br>@endif
                                    Birth Cert: {{ $student->birth_certificate_number }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $student->email }}</div>
                                <div class="text-sm text-gray-500">{{ $student->phone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap justify-center gap-1">
                                    @foreach($student->projects as $project)
                                    <span
                                        class="px-2 py-1 inline-block bg-blue-100 text-blue-800 text-xs rounded-full mb-1 text-center break-words">
                                        {{ $project->title }}
                                    </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($student->batch)
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full">
                                    {{ $student->batch }}
                                </span>
                                @else
                                <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                $statusClasses = [
                                'active' => 'bg-green-100 text-green-800',
                                'inactive' => 'bg-gray-100 text-gray-800',
                                'graduated' => 'bg-purple-100 text-purple-800',
                                'dropped' => 'bg-red-100 text-red-800',
                                ];
                                @endphp
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$student->status] }}">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="{{ route('students.show', $student) }}"
                                    class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-eye"></i></a>

                                @php
                                $canManageStudent = isset($userNgo) && $student->projects->where('runner_id',
                                $userNgo->id)->count() > 0;
                                @endphp

                                @if($canManageStudent)
                                <a href="{{ route('students.edit', $student) }}"
                                    class="text-yellow-600 hover:text-yellow-900 mr-3"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this student?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No students found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</x-app-layout>