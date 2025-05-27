<x-app-layout>
    <div class="p-4">
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
                <a href="{{ route('projects.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
                @hasrole(['admin', 'ngo'])
                <a href="{{ route('projects.edit', $project->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Project
                </a>
                @endhasrole
            </div>
        </div>

        <!-- Project Details -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Main Information -->
            <div class="md:col-span-2 bg-white p-6 pb-0 shadow rounded-lg">
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
                        <p class="mt-1 text-sm font-medium text-gray-900">{{ $project->focus_area }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Location</h3>
                        <p class="mt-1 text-sm font-medium text-gray-900">{{ $project->location }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Start Date</h3>
                        <p class="mt-1 text-sm font-medium text-gray-900">{{ $project->start_date->format('M d, Y') }}
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">End Date</h3>
                        <p class="mt-1 text-sm font-medium text-gray-900">
                            {{ $project->end_date ? $project->end_date->format('M d, Y') : 'Ongoing' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Budget</h3>
                        <p class="mt-1 text-sm font-medium text-gray-900">${{ number_format($project->budget, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Side Information -->
            <div class="space-y-6">
                <!-- Key People -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Key NGOs</h3>

                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-500">Project Holder</h4>
                        <div class="mt-2 flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full"
                                    src="https://ui-avatars.com/api/?name={{ $project->holder->name ?? 'Unknown' }}&background=random"
                                    alt="">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $project->holder->name ?? 'Not Assigned' }}</p>
                                <p class="text-sm text-blue-500">{{ $project->holder->email ?? '' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Project Runner</h4>
                        <div class="mt-2 flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full"
                                    src="https://ui-avatars.com/api/?name={{ $project->runner->name ?? 'Unknown' }}&background=random"
                                    alt="">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $project->runner->name ?? 'Not Assigned' }}</p>
                                <p class="text-sm text-blue-500">{{ $project->runner->email ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Trainings -->
                <!-- <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Related Trainings</h3>
                        <a href="{{ route('projects.trainings.index', $project->id) }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
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
                </div> -->
            </div>
        </div>

        <!-- Reports Section -->
        <div class="mt-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Project Reports</h3>
                <div class="flex space-x-2">
                    @hasrole(['admin', 'ngo'])
                    <button onclick="openUploadModal({{ $project->id }}, '{{ $project->title }}')"
                        class="text-blue-500 hover:text-blue-700 border border-blue-500 px-3 py-1 rounded text-sm">
                        <i class="fas fa-file-upload mr-1"></i> Upload Reports
                    </button>
                    @endhasrole
                    @hasrole(['admin', 'authority'])
                    <a href="{{ route('projects.download-reports', $project->id) }}"
                        class="text-green-500 hover:text-green-700 border border-green-500 px-3 py-1 rounded text-sm">
                        <i class="fas fa-download mr-1"></i> Download All Reports
                    </a>
                    @endhasrole
                </div>
            </div>

            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Month</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Uploaded By</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
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
                                <div class="text-xs text-gray-500">{{ number_format($report->file_size / 1024, 2) }} KB
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ Storage::url($report->file_path) }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-900" title="View Report">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ Storage::url($report->file_path) }}" download
                                        class="text-green-600 hover:text-green-900" title="Download Report">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    @hasrole(['admin', 'ngo'])
                                    <form action="{{ route('reports.destroy', $report->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                            title="Delete Report">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @endhasrole
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No reports available for this
                                project.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Testimonial Section -->
        <div x-data="testimonialApp()" class="mt-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Project Testimonials</h3>
                <div class="flex space-x-2">
                    @hasrole(['admin', 'ngo'])
                    <button @click="openRequestModal()"
                        class="text-purple-600 hover:text-purple-800 border border-purple-600 px-3 py-1 rounded text-sm transition-colors duration-200">
                        <i class="fas fa-file-signature mr-1"></i> Request for Testimonial
                    </button>
                    @endhasrole
                </div>
            </div>

            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Requested By</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                            @hasrole(['admin', 'authority'])
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Application</th>
                            @endhasrole
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Testimonial</th>
                            @hasrole(['admin', 'authority'])
                            <th
                                class="px-6 py-3 text-left text-xs text-center font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                            @endhasrole
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200  text-sm">
                        <template x-for="(testimonial, index) in testimonials" :key="index">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900" x-text="testimonial.title"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span x-bind:class="{
                                        'bg-yellow-100 text-yellow-800': testimonial.status === 'pending',
                                        'bg-green-100 text-green-800': testimonial.status === 'approved',
                                        'bg-red-100 text-red-800': testimonial.status === 'rejected'
                                    }" class="px-2 py-1 text-xs font-semibold rounded-full"
                                        x-text="testimonial.status.charAt(0).toUpperCase() + testimonial.status.slice(1)">
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900" x-text="testimonial.requestedBy"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900" x-text="testimonial.date"></div>
                                </td>
                                @hasrole(['admin', 'authority'])
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <template x-if="testimonial.status === 'approved'">
                                        <div class="flex items-center">
                                            <button @click="downloadTestimonial(index)"
                                                class="text-blue-600 text-sm hover:text-blue-900" title="Download">
                                                <i class="fas fa-download"></i> Download
                                            </button>
                                        </div>
                                    </template>
                                    <template x-if="testimonial.status !== 'approved'">
                                        <div class="text-sm text-gray-500">Not available</div>
                                    </template>
                                </td>
                                @endhasrole
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <template x-if="testimonial.status === 'approved'">
                                        <div class="flex items-center">
                                            <a href="#" class="text-blue-600  text-sm hover:text-blue-900 mr-2"
                                                title="View Testimonial">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <span class="text-sm text-gray-500" x-text="testimonial.fileSize"></span>
                                        </div>
                                    </template>
                                    <template x-if="testimonial.status !== 'approved'">
                                        <div class="text-sm text-gray-500">Not available</div>
                                    </template>
                                </td>

                                @hasrole(['admin', 'authority'])
                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                                    <template x-if="testimonial.status === 'pending'">
                                        <div class="flex space-x-2">
                                            @hasrole(['admin', 'authority'])
                                            <button @click="openApproveModal(index)"
                                                class="text-green-600 hover:text-green-900" title="Approve">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button @click="rejectTestimonial(index)"
                                                class="text-red-600 hover:text-red-900" title="Reject">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                            @endhasrole
                                            @hasrole(['admin', 'ngo'])
                                            <button @click="downloadTestimonial(index)"
                                                class="text-blue-600 hover:text-blue-900" title="Download">
                                                <i class="fas fa-download"></i> Download
                                            </button>
                                            @endhasrole
                                        </div>
                                    </template>
                                    <template x-if="testimonial.status === 'rejected'">
                                        <button @click="resubmitTestimonial(index)"
                                            class="text-purple-600 hover:text-purple-900">
                                            <i class="fas fa-redo"></i> Resubmit
                                        </button>
                                        <!-- <p class="text-gray-400">Uncompleted</p> -->
                                    </template>
                                    <template x-if="testimonial.status === 'approved'">
                                        <div class="text-gray-400">Completed</div>
                                    </template>
                                </td>
                                @endhasrole
                            </tr>
                        </template>
                        <template x-if="testimonials.length === 0">
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No testimonial requests
                                    available.</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Request Testimonial Modal -->
            <div x-show="showRequestModal"
                class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3 text-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Request Testimonial</h3>
                        <div class="mt-2 px-7 py-3">
                            <p class="text-sm text-gray-500 mb-4">
                                Are you sure you want to request a testimonial for this project?
                            </p>
                            <div class="mb-4">
                                <label for="testimonialTitle"
                                    class="block text-sm font-medium text-gray-700 text-left">Title</label>
                                <input x-model="newTestimonial.title" type="text" id="testimonialTitle"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Enter testimonial title">
                            </div>
                            <div class="mb-4">
                                <label for="files"
                                    class="block text-left text-sm font-medium text-gray-700">Application</label>
                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <i class="fas fa-file-upload mx-auto h-8 w-12 text-gray-400"></i>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="files"
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload file</span>
                                                <input id="files" name="files[]" type="file" class="sr-only" multiple>
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            PDF, DOC, DOCX up to 10MB each
                                        </p>
                                        <div id="fileList" class="mt-2 text-left"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="items-center px-4 py-3">
                            <button @click="submitTestimonialRequest()"
                                class="px-4 py-2 bg-purple-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-300">
                                Submit Request
                            </button>
                            <button @click="showRequestModal = false"
                                class="ml-3 px-4 py-2 bg-gray-200 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Approve Testimonial Modal -->
            <div x-show="showApproveModal"
                class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3 text-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Upload Testimonial</h3>
                        <div class="mt-2 px-7 py-3">
                            <p class="text-sm text-gray-500 mb-4">
                                Please upload the testimonial document (PDF or Image) for this project.
                            </p>
                            <div class="mb-4">
                                <input type="file" id="testimonialFile" @change="handleFileUpload"
                                    accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-purple-50 file:text-purple-700
                                    hover:file:bg-purple-100">
                            </div>
                        </div>
                        <div class="items-center px-4 py-3">
                            <button @click="approveWithFile()"
                                class="px-4 py-2 bg-green-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300">
                                Upload & Approve
                            </button>
                            <button @click="showApproveModal = false"
                                class="ml-3 px-4 py-2 bg-gray-200 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('testimonialApp', () => ({
                testimonials: [{
                        id: 1,
                        title: 'Community Development Project',
                        status: 'pending',
                        requestedBy: 'Green Earth NGO',
                        date: '15 Jan 2023',
                        fileSize: '',
                        file: null
                    },
                    {
                        id: 2,
                        title: 'Education for All',
                        status: 'approved',
                        requestedBy: 'Hope Foundation',
                        date: '10 Dec 2022',
                        fileSize: '(2.4 MB)',
                        file: null
                    },
                    {
                        id: 3,
                        title: 'Clean Water Initiative',
                        status: 'rejected',
                        requestedBy: 'Water for Life',
                        date: '05 Nov 2022',
                        fileSize: '',
                        file: null
                    }
                ],
                showRequestModal: false,
                showApproveModal: false,
                newTestimonial: {
                    title: '',
                    status: 'pending',
                    requestedBy: 'Current User NGO',
                    date: new Date().toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    }),
                    fileSize: '',
                    file: null
                },
                selectedTestimonialIndex: null,
                testimonialFile: null,

                openRequestModal() {
                    this.newTestimonial = {
                        title: '',
                        status: 'pending',
                        requestedBy: 'Current User NGO',
                        date: new Date().toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        }),
                        fileSize: '',
                        file: null
                    };
                    this.showRequestModal = true;
                },

                openApproveModal(index) {
                    this.selectedTestimonialIndex = index;
                    this.testimonialFile = null;
                    this.showApproveModal = true;
                },

                handleFileUpload(event) {
                    this.testimonialFile = event.target.files[0];
                },

                submitTestimonialRequest() {
                    if (!this.newTestimonial.title) {
                        alert('Please enter a title for the testimonial request');
                        return;
                    }

                    // In a real app, you would make an API call here
                    this.testimonials.unshift({
                        ...this.newTestimonial
                    });
                    this.showRequestModal = false;
                },

                approveWithFile() {
                    if (!this.testimonialFile) {
                        alert('Please select a file to upload');
                        return;
                    }

                    const validTypes = ['application/pdf', 'image/jpeg', 'image/png'];
                    if (!validTypes.includes(this.testimonialFile.type)) {
                        alert('Please upload a PDF or image file (JPEG/PNG)');
                        return;
                    }

                    // Update the testimonial status and add file info
                    this.testimonials[this.selectedTestimonialIndex].status = 'approved';
                    this.testimonials[this.selectedTestimonialIndex].fileSize =
                        `(${(this.testimonialFile.size / (1024 * 1024)).toFixed(1)} MB)`;
                    this.testimonials[this.selectedTestimonialIndex].file = this.testimonialFile;

                    this.showApproveModal = false;
                    this.selectedTestimonialIndex = null;
                    this.testimonialFile = null;
                },

                rejectTestimonial(index) {
                    if (confirm('Are you sure you want to reject this testimonial request?')) {
                        this.testimonials[index].status = 'rejected';
                    }
                },

                resubmitTestimonial(index) {
                    if (confirm('Resubmit this testimonial request?')) {
                        this.testimonials[index].status = 'pending';
                        this.testimonials[index].date = new Date().toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        });
                    }
                }
            }));
        });
        </script>
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