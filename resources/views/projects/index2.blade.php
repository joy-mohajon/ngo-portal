<x-app-layout>
    <div class="bg-white rounded-lg shadow p-6">
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Projects List</h1>
            <div class="flex space-x-3">
                <!-- <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
                    <i class="fas fa-file-export mr-2"></i>
                    Export
                </button> -->
                <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Add Project
                </button>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
            <form method="GET" action="{{ route('projects.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search Projects..."
                                class="w-full pl-10 pr-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status"
                            class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Registration Date</label>
                        <select name="date"
                            class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Time</option>
                            <option value="7" {{ request('date') == '7' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="30" {{ request('date') == '30' ? 'selected' : '' }}>Last 30 Days</option>
                            <option value="365" {{ request('date') == '365' ? 'selected' : '' }}>Last Year</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <select name="location"
                            class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Locations</option>
                            <option value="local" {{ request('location') == 'local' ? 'selected' : '' }}>Local</option>
                            <option value="national" {{ request('location') == 'national' ? 'selected' : '' }}>National
                            </option>
                            <option value="international"
                                {{ request('location') == 'international' ? 'selected' : '' }}>International</option>
                        </select>
                    </div>
                </div>
                <!-- <div class="mt-4 text-right">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">Filter</button>
                </div> -->
            </form>
        </div>

        <!-- Project Table -->
        <div class="overflow-x-auto max-h-[calc(100vh-400px)] overflow-y-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start
                            date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Focus
                            Area</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($projects as $project)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full"
                                        src="{{ $project->image_url ?? 'https://via.placeholder.com/40' }}" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $project->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $project->holder->email ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $project->start_date ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $project->focus_area ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $project->location ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                            $status = strtolower($project->status);
                            $statusColors = [
                            'active' => 'bg-green-100 text-green-800',
                            'inactive' => 'bg-red-100 text-red-800',
                            'suspended' => 'bg-yellow-100 text-yellow-800',
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            ];
                            $colorClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colorClass }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium" onclick="event.stopPropagation()">
                            <div class="flex space-x-2">
                                <a href="{{ route('projects.trainings.index', $project->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900" title="View Trainings">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </a>
                                @hasrole(['admin', 'ngo'])
                                <button onclick="openUploadModal('{{ $project->id }}', '{{ $project->title }}')"
                                    class="text-blue-500 hover:text-blue-700" title="Upload Reports">
                                    <i class="fas fa-file-upload"></i>
                                </button>
                                @endhasrole
                                @hasrole(['admin', 'authority'])
                                <a href="{{ route('projects.download-reports', $project->id) }}"
                                    class="text-green-600 hover:text-green-800" title="Download All Reports">
                                    <i class="fas fa-download"></i>
                                </a>
                                @endhasrole
                                <a href="{{ route('projects.show', $project->id) }}"
                                    class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @hasrole(['admin', 'ngo'])
                                <a href="{{ route('projects.edit', $project->id) }}"
                                    class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                @endhasrole
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No projects found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-6">
            <div class="text-sm text-gray-500">
                Showing <span class="font-medium">{{ $projects->firstItem() }}</span> to
                <span class="font-medium">{{ $projects->lastItem() }}</span> of
                <span class="font-medium">{{ $projects->total() }}</span> projects
            </div>
            <div class="mt-2">
                {{ $projects->appends(request()->query())->links() }}
            </div>
        </div>

    </div>

    <!-- Upload Reports Modal -->
    <div id="uploadReportModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeUploadModal()"></div>

            <!-- Modal panel -->
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-file-upload text-blue-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Upload Reports for <span id="projectTitle"></span>
                            </h3>
                            <div class="mt-4">
                                <form id="uploadReportForm" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="projectId" name="project_id" value="">

                                    <div class="mb-4">
                                        <label for="title" class="block text-sm font-medium text-gray-700">Report
                                            Title</label>
                                        <input type="text" name="title" id="title"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="mb-4">
                                        <label for="month" class="block text-sm font-medium text-gray-700">Report
                                            Month</label>
                                        <input type="month" name="month" id="month"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="mb-4">
                                        <label for="description"
                                            class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea name="description" id="description" rows="3"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label for="files" class="block text-sm font-medium text-gray-700">Report
                                            Files</label>
                                        <div
                                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                            <div class="space-y-1 text-center">
                                                <i class="fas fa-file-upload mx-auto h-12 w-12 text-gray-400"></i>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="files"
                                                        class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                        <span>Upload files</span>
                                                        <input id="files" name="files[]" type="file" class="sr-only"
                                                            multiple>
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500">
                                                    PDF, DOC, DOCX, XLS, XLSX up to 10MB each
                                                </p>
                                                <div id="fileList" class="mt-2 text-left"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit" id="uploadButton"
                                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Upload
                                        </button>
                                        <button type="button" onclick="closeUploadModal()"
                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // File upload functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize file input change event
        const fileInput = document.getElementById('files');
        const fileList = document.getElementById('fileList');
        const uploadForm = document.getElementById('uploadReportForm');

        fileInput.addEventListener('change', function() {
            fileList.innerHTML = '';
            for (let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                const fileItem = document.createElement('div');
                fileItem.className = 'text-sm py-1';
                fileItem.innerHTML =
                    `<i class="far fa-file mr-1"></i> ${file.name} (${formatFileSize(file.size)})`;
                fileList.appendChild(fileItem);
            }
        });

        // Set up form submit handler
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validation
            const title = document.getElementById('title').value;
            const month = document.getElementById('month').value;

            if (!title) {
                alert('Please enter a report title');
                return false;
            }

            if (!month) {
                alert('Please select a report month');
                return false;
            }

            if (fileInput.files.length === 0) {
                alert('Please select at least one file to upload');
                return false;
            }

            // Set the correct action URL
            const projectId = document.getElementById('projectId').value;
            this.action = `/projects/${projectId}/upload-reports`;

            // Submit the form
            this.submit();
        });
    });

    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' bytes';
        else if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        else return (bytes / 1048576).toFixed(1) + ' MB';
    }

    function openUploadModal(projectId, projectTitle) {
        // Set project info
        document.getElementById('projectId').value = projectId;
        document.getElementById('projectTitle').textContent = projectTitle;

        // Reset form
        document.getElementById('uploadReportForm').reset();
        document.getElementById('fileList').innerHTML = '';

        // Show modal
        document.getElementById('uploadReportModal').classList.remove('hidden');
    }

    function closeUploadModal() {
        document.getElementById('uploadReportModal').classList.add('hidden');
    }
    </script>
</x-app-layout>