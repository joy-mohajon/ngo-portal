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
            <h1 class="text-2xl font-bold">Project Details</h1>
            <div class="flex space-x-3">
                <a href="{{ route('projects.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
                @hasrole(['admin', 'ngo'])
                <a href="{{ route('projects.edit', $project->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Project
                </a>
                @endhasrole
            </div>
        </div>

        <!-- Project Details -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Main Information -->
            <div class="md:col-span-2 bg-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold">{{ $project->title }}</h2>
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
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $colorClass }}">
                        {{ ucfirst($status) }}
                    </span>
                </div>
                
                <div class="prose max-w-none mb-6">
                    <p class="text-gray-700">{{ $project->description }}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Focus Area</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $project->focus_area }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Location</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $project->location }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Start Date</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $project->start_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">End Date</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $project->end_date ? $project->end_date->format('M d, Y') : 'Ongoing' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Budget</h3>
                        <p class="mt-1 text-sm text-gray-900">${{ number_format($project->budget, 2) }}</p>
                    </div>
                </div>
                
                <!-- Reports Section -->
                <div class="mt-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Project Reports</h3>
                        <div class="flex space-x-2">
                            @hasrole(['admin', 'ngo'])
                            <button onclick="openUploadModal({{ $project->id }}, '{{ $project->title }}')" class="text-blue-500 hover:text-blue-700 border border-blue-500 px-3 py-1 rounded text-sm">
                                <i class="fas fa-file-upload mr-1"></i> Upload Reports
                            </button>
                            @endhasrole
                            @hasrole(['admin', 'authority'])
                            <a href="{{ route('projects.download-reports', $project->id) }}" class="text-green-500 hover:text-green-700 border border-green-500 px-3 py-1 rounded text-sm">
                                <i class="fas fa-download mr-1"></i> Download All Reports
                            </a>
                            @endhasrole
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto bg-white shadow rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploaded By</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($project->reports as $report)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $report->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $report->month }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $report->submitter->name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $report->file_name }}</div>
                                        <div class="text-xs text-gray-500">{{ number_format($report->file_size / 1024, 2) }} KB</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ Storage::url($report->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900" title="View Report">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ Storage::url($report->file_path) }}" download class="text-green-600 hover:text-green-900" title="Download Report">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            @hasrole(['admin', 'ngo'])
                                            <form action="{{ route('reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Delete Report">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            @endhasrole
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No reports available for this project.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Side Information -->
            <div class="space-y-6">
                <!-- Key People -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Key People</h3>
                    
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-500">Project Holder</h4>
                        <div class="mt-2 flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ $project->holder->name ?? 'Unknown' }}&background=random" alt="">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $project->holder->name ?? 'Not Assigned' }}</p>
                                <p class="text-sm text-gray-500">{{ $project->holder->email ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Project Runner</h4>
                        <div class="mt-2 flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ $project->runner->name ?? 'Unknown' }}&background=random" alt="">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $project->runner->name ?? 'Not Assigned' }}</p>
                                <p class="text-sm text-gray-500">{{ $project->runner->email ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Trainings -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Related Trainings</h3>
                        <a href="{{ route('projects.trainings', $project->id) }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                    </div>
                    
                    <div class="space-y-3">
                        @forelse($project->trainings->take(3) as $training)
                        <div class="border-l-4 border-blue-500 pl-4 py-2">
                            <p class="text-sm font-medium text-gray-900">{{ $training->title }}</p>
                            <p class="text-xs text-gray-500">{{ $training->start_date->format('M d, Y') }}</p>
                            <div class="mt-1">
                                @php
                                $trainingStatus = strtolower($training->status);
                                $trainingStatusColors = [
                                    'upcoming' => 'bg-blue-100 text-blue-800',
                                    'ongoing' => 'bg-green-100 text-green-800',
                                    'completed' => 'bg-gray-100 text-gray-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $trainingColorClass = $trainingStatusColors[$trainingStatus] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $trainingColorClass }}">
                                    {{ ucfirst($trainingStatus) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">No trainings associated with this project.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Upload Reports Modal -->
    <div id="uploadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full" style="z-index: 100;">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-2/5 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center pb-3">
                    <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Upload Reports</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeUploadModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="reportUploadForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Report Title</label>
                        <input type="text" name="title" id="title" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                    </div>
                    
                    <div class="mb-4">
                        <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
                        <select name="month" id="month" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                            <option value="">Select Month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label for="files" class="block text-sm font-medium text-gray-700">Upload Files</label>
                        <input type="file" name="files[]" id="files" multiple required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">You can upload multiple files (PDF, DOC, XLS, etc.). Max 10MB per file.</p>
                    </div>
                    
                    <div class="flex justify-end gap-3">
                        <button type="button" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400" onclick="closeUploadModal()">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function openUploadModal(projectId, projectTitle) {
            document.getElementById('modalTitle').textContent = 'Upload Reports for ' + projectTitle;
            document.getElementById('reportUploadForm').action = '/projects/' + projectId + '/upload-reports';
            document.getElementById('uploadModal').classList.remove('hidden');
        }
        
        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
            document.getElementById('reportUploadForm').reset();
        }
    </script>
</x-app-layout> 