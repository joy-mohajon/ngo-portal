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