<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900 flex items-center">
            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Project Reports
        </h3>
        <div class="flex space-x-2">
            @can('manageAsRunner', $project)
            <button onclick="openUploadModal(`{{ $project->id }}`, `{{ $project->name }}`)"
                class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                Upload
            </button>
            @endcan
            @hasrole(['admin', 'authority'])
            <button onclick="openDownloadModal()"
                class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700">
                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download
            </button>
            @endhasrole
        </div>
    </div>
    <div class="px-6 py-4">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Uploaded By</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($project->reports as $report)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $report->title }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">
                                {{ $report->month ? \Carbon\Carbon::parse($report->month)->format('F Y') : '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $report->submitter->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $report->file_name }}</div>
                            <div class="text-xs text-gray-400">
                                @if(is_numeric($report->file_size) && $report->file_size > 0)
                                {{ number_format($report->file_size / 1048576, 2) . ' MB' }}
                                @else
                                -
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-medium">
                            @can('manageAsRunner', $project)
                            <div class="flex justify-center space-x-3">
                                @if($report->file_path)
                                <a href="{{ route('reports.download', $report->id) }}"
                                    class="text-emerald-600 hover:text-emerald-900" title="Download">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                                @endif
                                <form action="{{ route('reports.destroy', $report->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this report?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            @endcan
                            @can('manageAsHolder', $project)
                            <div class="flex justify-center space-x-3">
                                @if($report->file_path)
                                <a href="{{ route('reports.download', $report->id) }}"
                                    class="text-emerald-600 hover:text-emerald-900" title="Download">
                                    Download
                                </a>
                                @endif
                            </div>
                            @endcan
                            @hasrole(['admin', 'authority'])
                            <div class="flex justify-center space-x-3">
                                @if($report->file_path)
                                <a href="{{ route('reports.download', $report->id) }}"
                                    class="text-emerald-600 hover:text-emerald-900" title="Download">
                                    Download
                                </a>
                                @endif
                            </div>
                            @endhasrole
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
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
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
                                    <label for="title" class="block text-sm font-medium text-gray-700">Report
                                        Title</label>
                                    <input type="text" name="title" id="title"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <span id="uploadReportTitleError" class="text-xs text-red-600"></span>
                                </div>

                                <div class="mb-4">
                                    <label for="month" class="block text-sm font-medium text-gray-700">Report
                                        Month</label>
                                    <input type="month" placeholder="1999-06" name="month" id="month"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <span id="uploadReportMonthError" class="text-xs text-red-600"></span>
                                </div>

                                <div class="mb-4">
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="description" rows="3"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="files" class="block text-sm font-medium text-gray-700">Report
                                        Files</label>
                                    <div
                                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path
                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="files"
                                                    class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Upload files</span>
                                                    <input id="files" name="files[]" type="file" class="sr-only"
                                                        multiple>
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <span id="uploadReportFilesError" class="text-xs text-red-600"></span>
                                            <p class="text-xs text-gray-500">
                                                PDF, DOC, DOCX, XLS, XLSX up to 10MB each
                                            </p>
                                            <div id="fileList" class="mt-2 text-left"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Progress bar for uploads -->
                                <div id="report-upload-progress"
                                    class="w-full h-2 bg-gray-200 rounded overflow-hidden mb-4 hidden">
                                    <div class="h-full bg-indigo-500 transition-all" style="width:0%"></div>
                                </div>

                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" id="uploadButton"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Upload
                                    </button>
                                    <button type="button" onclick="closeUploadModal()"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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

<!-- Download Reports Modal -->
<div id="downloadReportModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
            onclick="closeDownloadModal()"></div>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Download Reports
                        </h3>
                        <div class="mt-4">
                            <form id="downloadReportForm" method="GET"
                                action="{{ route('projects.download-reports', $project) }}">
                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                <div class="mb-4">
                                    <label for="from_date" class="block text-sm font-medium text-gray-700">From
                                    </label>
                                    <input type="month" name="from_date" id="from_date" placeholder="1999-02"
                                        class="mt-1 focus:ring-emerald-500 focus:border-emerald-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="to_date" class="block text-sm font-medium text-gray-700">To</label>
                                    <input type="month" name="to_date" id="to_date" placeholder="1999-02"
                                        class="mt-1 focus:ring-emerald-500 focus:border-emerald-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Download
                                    </button>
                                    <button type="button" onclick="closeDownloadModal()"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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

<!-- Flash Message Container -->
<div id="flash-message-container" class="fixed top-4 right-4 z-50 max-w-md"></div>

<script>
function openUploadModal(projectId, projectTitle) {
    document.getElementById('projectId').value = projectId;
    document.getElementById('projectTitle').textContent = projectTitle;
    document.getElementById('uploadReportForm').reset();
    document.getElementById('fileList').innerHTML = '';
    document.getElementById('uploadReportForm').action = `/projects/${projectId}/upload-reports`;
    document.getElementById('uploadReportModal').classList.remove('hidden');
    // Clear previous errors
    clearUploadReportErrors();
}

function closeUploadModal() {
    document.getElementById('uploadReportModal').classList.add('hidden');
}

function clearUploadReportErrors() {
    document.getElementById('uploadReportTitleError').textContent = '';
    document.getElementById('uploadReportMonthError').textContent = '';
    document.getElementById('uploadReportFilesError').textContent = '';
}

function openDownloadModal() {
    document.getElementById('downloadReportModal').classList.remove('hidden');
}

function closeDownloadModal() {
    document.getElementById('downloadReportModal').classList.add('hidden');
}

// Show flash message function
function showFlashMessage(type, message, duration = 5000) {
    const container = document.getElementById('flash-message-container');

    // Create message element
    const flashMessage = document.createElement('div');
    flashMessage.className =
        `${type === 'success' ? 'bg-emerald-100 border-emerald-500 text-emerald-700' : 'bg-red-100 border-red-500 text-red-700'} border-l-4 p-4 mb-4 rounded-lg shadow-sm transform transition-all duration-300 ease-in-out opacity-0 translate-x-4`;

    // Create icon based on type
    const iconPath = type === 'success' ?
        'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z' :
        'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z';

    // Set HTML content
    flashMessage.innerHTML = `
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <svg class="h-5 w-5 ${type === 'success' ? 'text-emerald-500' : 'text-red-500'} mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="${iconPath}" clip-rule="evenodd" />
                </svg>
                <span class="font-medium">${message}</span>
            </div>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="this.parentElement.parentElement.remove()">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    `;

    // Add to container
    container.appendChild(flashMessage);

    // Animate in
    setTimeout(() => {
        flashMessage.classList.remove('opacity-0', 'translate-x-4');
    }, 10);

    // Auto remove after duration
    if (duration > 0) {
        setTimeout(() => {
            if (flashMessage.parentElement) {
                flashMessage.classList.add('opacity-0', 'translate-x-4');
                setTimeout(() => {
                    if (flashMessage.parentElement) {
                        flashMessage.remove();
                    }
                }, 300);
            }
        }, duration);
    }

    return flashMessage;
}

document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.getElementById('uploadReportForm');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Always prevent default to handle validation
            clearUploadReportErrors();

            let valid = true;
            const title = document.getElementById('title').value.trim();
            const month = document.getElementById('month').value.trim();
            const files = document.getElementById('files').files;

            // Validate title
            if (!title) {
                document.getElementById('uploadReportTitleError').textContent = 'Title is required.';
                valid = false;
            } else if (title.length < 3) {
                document.getElementById('uploadReportTitleError').textContent =
                    'Title must be at least 3 characters.';
                valid = false;
            } else if (title.length > 255) {
                document.getElementById('uploadReportTitleError').textContent =
                    'Title cannot exceed 255 characters.';
                valid = false;
            }

            // Validate month
            if (!month) {
                document.getElementById('uploadReportMonthError').textContent = 'Month is required.';
                valid = false;
            } else {
                // Check if it's a valid month format (YYYY-MM)
                const monthRegex = /^\d{4}-\d{2}$/;
                if (!monthRegex.test(month)) {
                    document.getElementById('uploadReportMonthError').textContent =
                        'Month must be in YYYY-MM format.';
                    valid = false;
                }
            }

            // Validate files
            if (!files || files.length === 0) {
                document.getElementById('uploadReportFilesError').textContent =
                    'At least one file is required.';
                valid = false;
            } else {
                // Check file types and sizes
                const allowedTypes = ['application/pdf', 'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ];
                const maxSize = 10 * 1024 * 1024; // 10MB

                let fileErrors = [];

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];

                    // Check file type
                    if (!allowedTypes.includes(file.type)) {
                        fileErrors.push(
                            `"${file.name}" is not an allowed file type. Only PDF, DOC, DOCX, XLS, and XLSX are supported.`
                        );
                    }

                    // Check file size
                    if (file.size > maxSize) {
                        fileErrors.push(
                            `"${file.name}" exceeds the 10MB size limit (${(file.size / (1024 * 1024)).toFixed(2)}MB).`
                        );
                    }
                }

                if (fileErrors.length > 0) {
                    document.getElementById('uploadReportFilesError').innerHTML = fileErrors.join(
                        '<br>');
                    valid = false;
                }
            }

            if (valid) {
                // Show loading state
                const uploadButton = document.getElementById('uploadButton');
                const originalText = uploadButton.innerHTML;
                uploadButton.disabled = true;
                uploadButton.innerHTML =
                    '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Uploading...';

                // Show progress bar
                const progressBar = document.getElementById('report-upload-progress');
                const progressIndicator = progressBar.querySelector('div');
                progressBar.classList.remove('hidden');
                progressIndicator.style.width = '0%';

                // Create FormData
                const formData = new FormData(this);

                // Use XMLHttpRequest for upload with progress
                const xhr = new XMLHttpRequest();
                xhr.open('POST', this.action, true);

                // Add progress event listener
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        progressIndicator.style.width = percentComplete + '%';
                    }
                });

                // Add load event listener
                xhr.addEventListener('load', function() {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        try {
                            const response = JSON.parse(xhr.responseText);

                            // Show flash message instead of alert
                            showFlashMessage('success', response.message ||
                                'Reports uploaded successfully');

                            // Close modal
                            closeUploadModal();

                            // Refresh page to show new reports
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000); // Short delay to allow user to see the message
                        } catch (error) {
                            console.error('Error parsing response:', error);
                            showFlashMessage('error',
                                'An error occurred while processing the response');

                            // Reset button
                            uploadButton.disabled = false;
                            uploadButton.innerHTML = originalText;
                        }
                    } else {
                        // Handle error response
                        try {
                            const response = JSON.parse(xhr.responseText);
                            let errorMessage = response.message || 'Upload failed';

                            // Handle validation errors
                            if (response.errors) {
                                if (response.errors.title) {
                                    document.getElementById('uploadReportTitleError')
                                        .textContent = response.errors.title[0];
                                }
                                if (response.errors.month) {
                                    document.getElementById('uploadReportMonthError')
                                        .textContent = response.errors.month[0];
                                }
                                if (response.errors.files) {
                                    document.getElementById('uploadReportFilesError')
                                        .textContent = response.errors.files[0];
                                }
                                errorMessage = 'Please fix the errors above';
                            }

                            showFlashMessage('error', 'Upload failed: ' + errorMessage);
                        } catch (error) {
                            console.error('Error parsing error response:', error);
                            showFlashMessage('error', 'Upload failed: ' + xhr.statusText);
                        }

                        // Reset button
                        uploadButton.disabled = false;
                        uploadButton.innerHTML = originalText;
                    }

                    // Hide progress bar
                    progressBar.classList.add('hidden');
                });

                // Add error event listener
                xhr.addEventListener('error', function() {
                    showFlashMessage('error',
                        'Upload failed. Please check your connection and try again.');

                    // Reset button
                    uploadButton.disabled = false;
                    uploadButton.innerHTML = originalText;

                    // Hide progress bar
                    progressBar.classList.add('hidden');
                });

                // Set proper headers
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                // Send the request
                xhr.send(formData);
            } else {
                // Scroll to the first error
                const firstError = document.querySelector('.text-red-600:not(:empty)');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }
        });
    }

    const fileInput = document.getElementById('files');
    const fileList = document.getElementById('fileList');
    if (fileInput && fileList) {
        fileInput.addEventListener('change', function() {
            fileList.innerHTML = '';
            document.getElementById('uploadReportFilesError').textContent =
                ''; // Clear file errors when new files are selected

            if (this.files.length === 0) {
                return;
            }

            const allowedTypes = ['application/pdf', 'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ];
            const maxSize = 10 * 1024 * 1024; // 10MB

            for (let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                const fileItem = document.createElement('div');
                fileItem.className = 'flex items-center text-sm py-1';

                // Determine icon based on file type
                let icon =
                    'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';

                if (file.type === 'application/pdf') {
                    icon =
                        'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z';
                } else if (file.type.includes('spreadsheet') || file.type.includes('excel')) {
                    icon =
                        'M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z';
                } else if (file.type.includes('word')) {
                    icon =
                        'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
                }

                // Format file size
                let fileSize;
                if (file.size < 1024) {
                    fileSize = file.size + ' B';
                } else if (file.size < 1048576) {
                    fileSize = (file.size / 1024).toFixed(1) + ' KB';
                } else {
                    fileSize = (file.size / 1048576).toFixed(1) + ' MB';
                }

                // Determine if file has any issues
                const isInvalidType = !allowedTypes.includes(file.type);
                const isOversized = file.size > maxSize;
                const hasIssue = isInvalidType || isOversized;

                fileItem.innerHTML = `
                    <svg class="inline h-4 w-4 mr-1 ${hasIssue ? 'text-red-500' : 'text-gray-400'}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${icon}"/>
                    </svg>
                    <span class="truncate max-w-xs ${hasIssue ? 'text-red-500' : ''}">${file.name}</span>
                    <span class="${hasIssue ? 'text-red-500 font-medium' : 'text-gray-500'} ml-1">(${fileSize})</span>
                    ${isInvalidType ? '<span class="text-xs text-red-600 ml-2">Invalid type</span>' : ''}
                    ${isOversized ? '<span class="text-xs text-red-600 ml-2">Too large</span>' : ''}
                `;

                fileList.appendChild(fileItem);
            }
        });

        // Add drag and drop support
        const dropArea = fileInput.closest('div.border-dashed');
        if (dropArea) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                }, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => {
                    dropArea.classList.add('border-indigo-500', 'bg-indigo-50');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => {
                    dropArea.classList.remove('border-indigo-500', 'bg-indigo-50');
                }, false);
            });

            dropArea.addEventListener('drop', (e) => {
                fileInput.files = e.dataTransfer.files;

                // Trigger change event
                const event = new Event('change', {
                    bubbles: true
                });
                fileInput.dispatchEvent(event);
            }, false);
        }
    }
});
</script>