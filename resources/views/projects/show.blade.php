<x-app-layout>
    <div class="p-6">
        <!-- Flash Messages -->
        @include('projects.partials.flash-messages')

        <!-- Header Section -->
        @include('projects.partials.header')

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Project Details -->
            <div class="lg:col-span-2 space-y-6">

                @include('projects.partials.overview-card')

                <!-- Reports Section -->
                @include('projects.partials.reports-card')

                <!-- Testimonials -->
                @include('projects.partials.testimonials-card')
            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-6">
                <!-- Key Organizations -->
                @include('projects.partials.key-organizations')

                <!-- Major Activities -->
                @include('projects.partials.major-activities-card')

                @include('projects.partials.gallery-card', ['project' => $project])

                {{-- Student Card Section --}}
                @php
                $students = $project->students()->latest()->take(3)->get();
                @endphp
                <div class="bg-white rounded-lg shadow p-0 mt-6 mb-6 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <i class="fas fa-user-graduate text-indigo-500 mr-2 text-xl"></i>
                            Students
                        </h3>
                        @can('manageAsRunner', $project)
                        <a href="{{ route('students.create', ['project_id' => $project->id]) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add
                        </a>
                        @endcan
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 gap-4">
                            @forelse($students as $student)
                            @include('students.partials.preview-card', ['student' => $student])
                            @empty
                            <div class="text-center text-gray-400 py-8">
                                <i class="fas fa-user-friends text-3xl mb-2"></i>
                                <div>No students assigned to this project.</div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    @auth
                    @hasrole('ngo')
                    <div class="px-6 pb-4 flex justify-end ">
                        <a href="{{ route('students.index', ['project_id' => $project->id]) }}"
                            class="inline-flex w-full justify-center items-center px-5 py-2 rounded-lg font-semibold shadow bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-100 hover:text-indigo-900 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-200">
                            <i class="fas fa-users mr-2"></i>
                            View All Students
                        </a>
                    </div>
                    @endhasrole
                    @endauth
                </div>

                <!-- Project Location -->
                <!-- @include('projects.partials.location-card') -->

            </div>
        </div>
    </div>

    <!-- Upload Reports Modal -->


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="/js/project-gallery.js"></script>

    <script>
    // JavaScript code remains the same as in your original code
    </script>
</x-app-layout>