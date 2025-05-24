<x-app-layout>
    <div class="p-6">
        <!-- Flash Messages -->
        @if(session('success'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $project->title }}</h1>
                <div class="flex items-center mt-2">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ 
                        $project->status == 'Active' ? 'bg-emerald-100 text-emerald-800' : 
                        ($project->status == 'Inactive' ? 'bg-red-100 text-red-800' : 
                        'bg-amber-100 text-amber-800') 
                    }}">
                        {{ $project->status }}
                    </span>
                    <span class="ml-3 text-gray-600 text-sm flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $project->location }}
                    </span>
                </div>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="{{ route('projects.index') }}" class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to List
                </a>
                @hasrole(['admin', 'ngo'])
                <a href="{{ route('projects.edit', $project->id) }}" class="flex items-center px-4 py-2 bg-indigo-600 rounded-lg shadow-sm text-sm font-medium text-white hover:bg-indigo-700">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Project
                </a>
                @endhasrole
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Project Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Project Overview Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Project Overview
                        </h3>
                    </div>
                    <div class="px-6 py-5">
                        <div class="prose max-w-none text-gray-700 mb-6">
                            {{ $project->description }}
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Focus Area</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $project->focus_area }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Budget</h4>
                                <p class="mt-1 text-sm text-gray-900">${{ number_format($project->budget, 2) }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Start Date</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $project->start_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">End Date</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $project->end_date ? $project->end_date->format('M d, Y') : 'Ongoing' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reports Section -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Project Reports
                        </h3>
                        <div class="flex space-x-2">
                            @hasrole(['admin', 'ngo'])
                            <button onclick="openUploadModal({{ $project->id }}, '{{ $project->title }}')" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                Upload
                            </button>
                            @endhasrole
                            @hasrole(['admin', 'authority'])
                            <a href="{{ route('projects.download-reports', $project->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download All
                            </a>
                            @endhasrole
                        </div>
                    </div>
                    <div class="px-6 py-4">
                        @if($project->reports->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploaded By</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($project->reports as $report)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $report->title }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $report->month }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $report->submitter->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $report->file_name }}</div>
                                            <div class="text-xs text-gray-400">{{ number_format($report->file_size / 1024, 2) }} KB</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-3">
                                                <a href="{{ Storage::url($report->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900" title="View">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>
                                                <a href="{{ Storage::url($report->file_path) }}" download class="text-emerald-600 hover:text-emerald-900" title="Download">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                </a>
                                                @hasrole(['admin', 'ngo'])
                                                <form action="{{ route('reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this report?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                                @endhasrole
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No reports available</h3>
                            <p class="mt-1 text-sm text-gray-500">Upload reports to track project progress.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-6">
                <!-- Key Organizations -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Key Organizations
                        </h3>
                    </div>
                    <div class="px-6 py-5 space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Project Holder</h4>
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <span class="text-indigo-600 font-medium">{{ substr($project->holder->name ?? 'N/A', 0, 2) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $project->holder->name ?? 'Not Assigned' }}</p>
                                    <p class="text-sm text-indigo-600">{{ $project->holder->email ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Project Runner</h4>
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center">
                                    <span class="text-emerald-600 font-medium">{{ substr($project->runner->name ?? 'N/A', 0, 2) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $project->runner->name ?? 'Not Assigned' }}</p>
                                    <p class="text-sm text-emerald-600">{{ $project->runner->email ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonials -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                            Testimonials
                        </h3>
                        @hasrole(['admin', 'ngo'])
                        <button onclick="openRequestModal()" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Request
                        </button>
                        @endhasrole
                    </div>
                    <div class="px-6 py-4">
                        <div class="space-y-4">
                            <!-- Sample Testimonial Items -->
                            <div class="border-l-4 border-indigo-400 pl-4 py-2 bg-indigo-50 rounded-r">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Community Impact Assessment</p>
                                        <p class="text-xs text-gray-500">Requested on Jan 15, 2023</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">Approved</span>
                                </div>
                                <div class="mt-2 flex justify-between items-center">
                                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-900 flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        View
                                    </a>
                                    <span class="text-xs text-gray-500">2.4 MB</span>
                                </div>
                            </div>

                            <div class="border-l-4 border-amber-400 pl-4 py-2 bg-amber-50 rounded-r">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Project Completion Report</p>
                                        <p class="text-xs text-gray-500">Requested on Dec 10, 2022</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">Pending</span>
                                </div>
                                <div class="mt-2 text-sm text-gray-500">
                                    Waiting for approval from authority
                                </div>
                            </div>

                            <div class="border-l-4 border-red-400 pl-4 py-2 bg-red-50 rounded-r">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Initial Impact Report</p>
                                        <p class="text-xs text-gray-500">Requested on Nov 5, 2022</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                </div>
                                <div class="mt-2 text-sm text-gray-500">
                                    Additional documentation required
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                View all testimonials →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Reports Modal -->
    <div id="uploadReportModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeUploadModal()"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
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
                                        <label for="title" class="block text-sm font-medium text-gray-700">Report Title</label>
                                        <input type="text" name="title" id="title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="mb-4">
                                        <label for="month" class="block text-sm font-medium text-gray-700">Report Month</label>
                                        <input type="month" name="month" id="month" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="mb-4">
                                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea name="description" id="description" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label for="files" class="block text-sm font-medium text-gray-700">Report Files</label>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="files" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                        <span>Upload files</span>
                                                        <input id="files" name="files[]" type="file" class="sr-only" multiple>
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
                                        <button type="submit" id="uploadButton" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Upload
                                        </button>
                                        <button type="button" onclick="closeUploadModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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

    <!-- Request Testimonial Modal -->
    <div id="requestTestimonialModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeRequestModal()"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Request Testimonial
                            </h3>
                            <div class="mt-4">
                                <form id="requestTestimonialForm">
                                    <div class="mb-4">
                                        <label for="testimonialTitle" class="block text-sm font-medium text-gray-700">Title</label>
                                        <input type="text" id="testimonialTitle" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="mb-4">
                                        <label for="testimonialDescription" class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea id="testimonialDescription" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label for="testimonialFiles" class="block text-sm font-medium text-gray-700">Supporting Documents</label>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="testimonialFiles" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                        <span>Upload files</span>
                                                        <input id="testimonialFiles" type="file" class="sr-only" multiple>
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500">
                                                    PDF, DOC, DOCX up to 10MB each
                                                </p>
                                                <div id="testimonialFileList" class="mt-2 text-left"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="button" onclick="submitTestimonialRequest()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Submit Request
                                        </button>
                                        <button type="button" onclick="closeRequestModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
        // Initialize file input change event for reports
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
                    `<svg class="inline h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg> ${file.name} (${formatFileSize(file.size)})`;
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

        // Initialize file input change event for testimonials
        const testimonialFileInput = document.getElementById('testimonialFiles');
        const testimonialFileList = document.getElementById('testimonialFileList');

        testimonialFileInput.addEventListener('change', function() {
            testimonialFileList.innerHTML = '';
            for (let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                const fileItem = document.createElement('div');
                fileItem.className = 'text-sm py-1';
                fileItem.innerHTML =
                    `<svg class="inline h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg> ${file.name} (${formatFileSize(file.size)})`;
                testimonialFileList.appendChild(fileItem);
            }
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

    function openRequestModal() {
        // Reset form
        document.getElementById('requestTestimonialForm').reset();
        document.getElementById('testimonialFileList').innerHTML = '';

        // Show modal
        document.getElementById('requestTestimonialModal').classList.remove('hidden');
    }

    function closeRequestModal() {
        document.getElementById('requestTestimonialModal').classList.add('hidden');
    }

    function submitTestimonialRequest() {
        const title = document.getElementById('testimonialTitle').value;
        const description = document.getElementById('testimonialDescription').value;
        
        if (!title) {
            alert('Please enter a title for the testimonial request');
            return;
        }

        // In a real app, you would make an API call here
        alert('Testimonial request submitted successfully!');
        closeRequestModal();
    }
    </script>
</x-app-layout>