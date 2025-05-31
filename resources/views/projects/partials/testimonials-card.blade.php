<!-- <div class="bg-white overflow-hidden shadow rounded-lg">
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
            <div class="border-l-4 border-indigo-400 pl-4 py-2 bg-indigo-50 rounded-r">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Farmer Success Stories</p>
                                        <p class="text-xs text-gray-500">Requested on Feb 10, 2023</p>
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
                                    <span class="text-xs text-gray-500">3.1 MB</span>
                                </div>
                            </div>

                            <div class="border-l-4 border-amber-400 pl-4 py-2 bg-amber-50 rounded-r">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Impact Assessment 2023</p>
                                        <p class="text-xs text-gray-500">Requested on Mar 15, 2023</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">Pending</span>
                                </div>
                                <div class="mt-2 text-sm text-gray-500">
                                    Under review by Upazila Agriculture Officer
                                </div>
                            </div>

                            <div class="border-l-4 border-red-400 pl-4 py-2 bg-red-50 rounded-r">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Crop Yield Comparison</p>
                                        <p class="text-xs text-gray-500">Requested on Jan 5, 2023</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                </div>
                                <div class="mt-2 text-sm text-gray-500">
                                    Requires additional verification data
                                </div>
                            </div>
        </div>
    </div>
</div> -->

<!-- Testimonial Section -->
<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900 flex items-center">
            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            Testimonials
        </h3>
        @can('manageAsRunner', $project)
        <button onclick="openRequestModal()"
            class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Request
        </button>
        @endcan
    </div>

    <div class="overflow-x-auto bg-white px-6 py-4 shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requested
                        By</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Application</th>
                    <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Testimonial</th> -->
                    <th
                        class="px-6 py-3 text-left text-xs text-center font-medium text-gray-500 uppercase tracking-wider">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                @forelse($project->testimonials as $testimonial)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $testimonial->title }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                        $statusColors = [
                        'approved' => 'bg-green-100 text-green-800',
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'rejected' => 'bg-red-100 text-red-800',
                        ];
                        $color = $statusColors[$testimonial->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
                            {{ ucfirst($testimonial->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $testimonial->requester->name ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ $testimonial->date ? \Carbon\Carbon::parse($testimonial->date)->format('d F Y') : '-' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($testimonial->application_file)
                        <a href="{{ route('testimonials.download-application', $testimonial->id) }}"
                            class="text-blue-600 text-sm hover:text-blue-900 transition-colors"
                            title="Download Application" download>
                            <i class="fas fa-download mr-1"></i> Download Application
                        </a>
                        @else
                        <div class="text-sm text-gray-500 italic">Not available</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                        @if($testimonial->status === 'pending')
                        @hasrole(['admin', 'authority'])
                        {{-- Approve Button --}}
                        <button onclick="openApproveModal(`{{ $testimonial->id }}`)"
                            class="text-green-600 hover:text-green-900 transition-colors" title="Approve">
                            <i class="fas fa-check mr-1"></i> Approve
                        </button>

                        {{-- Reject Button --}}
                        <button onclick="submitRejectForm(`{{ $testimonial->id }}`)"
                            class="text-red-600 hover:text-red-900 transition-colors" title="Reject">
                            <i class="fas fa-times mr-1"></i> Reject
                        </button>
                        @else
                        <div class="text-sm text-gray-500 italic">Not available</div>
                        @endhasrole

                        @elseif($testimonial->status === 'rejected')
                        <div class="text-purple-600 italic">Not available</div>

                        @else
                        <div class="text-gray-400 italic">
                            @if($testimonial->testimonial_file)
                            <a href="{{ route('testimonials.download-testimonial', $testimonial->id) }}"
                                class="text-blue-600 text-sm hover:text-blue-900 transition-colors"
                                title="Download Testimonial" download>
                                <i class="fas fa-download mr-1"></i> Download Testimonial
                            </a>
                            @else
                            <div class="text-sm text-gray-500 italic">Not available</div>
                            @endif
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No testimonials available for this
                        project.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>



<!-- Request Testimonial Modal -->
<div id="requestTestimonialModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
            onclick="closeRequestModal()"></div>

        <!-- Modal panel -->
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Request Testimonial
                        </h3>
                        <div class="mt-4">
                            <form id="requestTestimonialForm" method="POST" enctype="multipart/form-data"
                                action="{{ route('projects.testimonials.store', $project->id) }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="testimonialTitle"
                                        class="block text-sm font-medium text-gray-700">Title</label>
                                    <input type="text" name="title" id="testimonialTitle"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="mb-4">
                                    <label for="testimonialDescription"
                                        class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="testimonialDescription" rows="3"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="testimonialFiles"
                                        class="block text-sm font-medium text-gray-700">Supporting Document</label>
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
                                                <label for="testimonialFiles"
                                                    class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Upload files</span>
                                                    <input id="testimonialFiles" name="application_file" type="file"
                                                        class="sr-only" accept=".pdf,.doc,.docx" required>
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 10MB each</p>
                                            <div id="testimonialFileList" class="mt-2 text-left"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Submit Request
                                    </button>
                                    <button type="button" onclick="closeRequestModal()"
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


<!-- Approve Testimonial Modal -->
<div id="approveTestimonialModal"
    class="fixed inset-0 -top-6 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Approve Testimonial</h3>
            <form id="approveTestimonialForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="testimonial_id" id="approveTestimonialId">
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 mb-4">
                        Please upload the testimonial document (PDF or Image) for this project.
                    </p>
                    <div class="mb-4">
                        <label for="testimonialFile" class="block text-sm font-medium text-gray-700 mb-1">Testimonial
                            File (PDF/Image)</label>
                        <input type="file" name="testimonial_file" id="testimonialFile" class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-purple-50 file:text-purple-700
                                    hover:file:bg-purple-100" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                </div>
                <div class="items-center px-4 py-3">
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300">
                        Upload & Approve
                    </button>
                    <button type="button" onclick="closeApprovalModal()"
                        class="ml-3 px-4 py-2 bg-gray-200 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Request Testimonial
function openRequestModal() {
    document.getElementById('requestTestimonialForm').reset();
    document.getElementById('requestTestimonialModal').classList.remove('hidden');
}

function closeRequestModal() {
    document.getElementById('requestTestimonialModal').classList.add('hidden');
}

// Approval modal  
function openApproveModal(testimonialId) {
    document.getElementById('approveTestimonialForm').reset();
    document.getElementById('approveTestimonialId').value = testimonialId;
    document.getElementById('approveTestimonialForm').action = `/testimonials/${testimonialId}/approve`;
    document.getElementById('approveTestimonialModal').classList.remove('hidden');
}

function closeApprovalModal() {
    document.getElementById('approveTestimonialModal').classList.add('hidden');
}

function submitRejectForm(testimonialId) {
    if (confirm('Are you sure you want to reject this testimonial?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/testimonials/${testimonialId}/reject`;
        // Add CSRF token as hidden input
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const testimonialFileInput = document.getElementById('testimonialFiles');
    const testimonialFileList = document.getElementById('testimonialFileList');
    if (testimonialFileInput && testimonialFileList) {
        testimonialFileInput.addEventListener('change', function() {
            testimonialFileList.innerHTML = '';
            for (let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                const fileItem = document.createElement('div');
                fileItem.className = 'text-sm py-1';
                fileItem.textContent = file.name;
                testimonialFileList.appendChild(fileItem);
            }
        });
    }
});
</script>