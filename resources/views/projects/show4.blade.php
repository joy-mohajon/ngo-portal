<x-app-layout>
    <div class="p-6" x-data="projectShow()">
        <!-- Flash Messages -->
        @include('projects.partials.flash-messages')

        <!-- Header Section -->
        @include('projects.partials.header', ['project' => $project])

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Project Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Project Overview Card -->
                @include('projects.partials.overview-card', ['project' => $project])

                <!-- Reports Section -->
                <div x-data="reportsSection()">
                    @include('projects.partials.reports-card', ['project' => $project])
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-6">
                <!-- Key Organizations -->
                @include('projects.partials.organizations-card', ['project' => $project])

                <!-- Testimonials Section -->
                <div x-data="testimonialsSection({{ Js::from($project->testimonials) }})">
                    @include('projects.partials.testimonials-card', ['project' => $project])
                </div>
            </div>
        </div>

        <!-- Upload Reports Modal -->
        @include('projects.partials.upload-report-modal', ['project' => $project])

        <!-- Request Testimonial Modal -->
        @include('projects.partials.request-testimonial-modal')

        <!-- Approve Testimonial Modal -->
        @include('projects.partials.approve-testimonial-modal')
    </div>

    <!-- Alpine.js Components -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('projectShow', () => ({
                init() {
                    // Any initialization logic for the page
                }
            }));

            Alpine.data('reportsSection', () => ({
                openUploadModal(projectId, projectTitle) {
                    window.dispatchEvent(new CustomEvent('open-upload-modal', {
                        detail: { projectId, projectTitle }
                    }));
                },
                // Add a dummy upload handler for demo
                uploadReport() {
                    alert('Demo: Report uploaded!');
                },
            }));

            Alpine.data('testimonialsSection', (initialTestimonials) => ({
                testimonials: initialTestimonials,
                openRequestModal() {
                    window.dispatchEvent(new CustomEvent('open-testimonial-modal'));
                },
                // Add a dummy request handler for demo
                requestTestimonial() {
                    alert('Demo: Testimonial requested!');
                },
                openApproveModal(testimonialId) {
                    this.$dispatch('open-approve-modal', { testimonialId });
                },
                downloadApplicationFiles(testimonialId) {
                    const testimonial = this.testimonials.find(t => t.id === testimonialId);
                    alert(`Downloading application files for: ${testimonial.title}`);
                },
                downloadTestimonial(testimonialId) {
                    const testimonial = this.testimonials.find(t => t.id === testimonialId);
                    alert(`Downloading testimonial files for: ${testimonial.title}`);
                },
                rejectTestimonial(testimonialId) {
                    if (confirm('Are you sure you want to reject this testimonial request?')) {
                        const testimonial = this.testimonials.find(t => t.id === testimonialId);
                        testimonial.status = 'rejected';
                    }
                }
            }));
        });

        document.addEventListener('DOMContentLoaded', function() {
            const openBtn = document.getElementById('openUploadReportBtn');
            const modal = document.getElementById('uploadReportModal');
            const closeBtn = document.getElementById('closeUploadReportModalBtn');
            const form = document.getElementById('uploadReportForm');

            if (openBtn && modal && closeBtn) {
                openBtn.addEventListener('click', function() {
                    modal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                });
                closeBtn.addEventListener('click', function() {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
                // Optional: close modal on background click
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                });
            }
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('Demo: Report uploaded!');
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Upload Report Modal
            const openUploadBtn = document.getElementById('openUploadReportBtn');
            const uploadModal = document.getElementById('uploadReportModal');
            const closeUploadBtn = document.getElementById('closeUploadReportModalBtn');
            const uploadForm = document.getElementById('uploadReportForm');

            if (openUploadBtn && uploadModal && closeUploadBtn) {
                openUploadBtn.addEventListener('click', function() {
                    uploadModal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                });
                closeUploadBtn.addEventListener('click', function() {
                    uploadModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
                uploadModal.addEventListener('click', function(e) {
                    if (e.target === uploadModal) {
                        uploadModal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                });
            }
            if (uploadForm) {
                uploadForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('Demo: Report uploaded!');
                    uploadModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
            }

            // Request Testimonial Modal
            const openRequestBtn = document.getElementById('openRequestTestimonialBtn');
            const requestModal = document.getElementById('requestTestimonialModal');
            const closeRequestBtn = document.getElementById('closeRequestTestimonialModalBtn');
            const requestForm = document.getElementById('requestTestimonialForm');

            if (openRequestBtn && requestModal && closeRequestBtn) {
                openRequestBtn.addEventListener('click', function() {
                    requestModal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                });
                closeRequestBtn.addEventListener('click', function() {
                    requestModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
                requestModal.addEventListener('click', function(e) {
                    if (e.target === requestModal) {
                        requestModal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                });
            }
            if (requestForm) {
                requestForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('Demo: Testimonial requested!');
                    requestModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
            }

            // Dummy data for reports
            const reportsTable = document.getElementById('demoReportsTable');
            if (reportsTable) {
                const demoReports = [
                    { title: 'Quarterly Progress Report', month: 'April 2025', uploadedBy: 'Ayesha Rahman', file: 'progress_apr2025.pdf', size: '120 KB' },
                    { title: 'Annual Impact Report', month: '2024', uploadedBy: 'Md. Karim Uddin', file: 'impact_2024.pdf', size: '340 KB' }
                ];
                let html = '';
                demoReports.forEach(r => {
                    html += `<tr><td class='px-6 py-4'>${r.title}</td><td class='px-6 py-4'>${r.month}</td><td class='px-6 py-4'>${r.uploadedBy}</td><td class='px-6 py-4'>${r.file}<div class='text-xs text-gray-400'>${r.size}</div></td><td class='px-6 py-4'><button class='text-indigo-600'>View</button></td></tr>`;
                });
                reportsTable.innerHTML = html;
            }

            // Dummy data for testimonials
            const testimonialsList = document.getElementById('demoTestimonialsList');
            if (testimonialsList) {
                const demoTestimonials = [
                    { title: 'Excellent Support', author: 'Ayesha Rahman', date: '2025-05-10', status: 'approved', content: 'This project made a real difference in our community.' },
                    { title: 'Youth Empowerment', author: 'Md. Karim Uddin', date: '2025-04-22', status: 'pending', content: 'I am grateful for the opportunities this project created for local youth.' }
                ];
                let html = '';
                demoTestimonials.forEach(t => {
                    html += `<div class='border-l-4 pl-4 py-2 mb-2 ${t.status === 'approved' ? 'border-emerald-400 bg-emerald-50' : 'border-amber-400 bg-amber-50'}'>`;
                    html += `<div class='flex justify-between items-start'><div><p class='text-sm font-medium text-gray-900'>${t.title}</p><p class='text-xs text-gray-500'>${t.author} &middot; ${t.date}</p></div><span class='px-2 py-1 text-xs font-semibold rounded-full ${t.status === 'approved' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'}'>${t.status.charAt(0).toUpperCase() + t.status.slice(1)}</span></div>`;
                    html += `<div class='mt-2 text-sm text-gray-700'>${t.content}</div></div>`;
                });
                testimonialsList.innerHTML = html;
            }
        });
    </script>
</x-app-layout>