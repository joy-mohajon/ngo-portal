<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->title }} | NGO Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <!-- Light Gallery -->
    <link href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/zoom/lg-zoom.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/thumbnail/lg-thumbnail.min.js"></script>
    <style>
        .gallery-item {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <svg class="h-8 w-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3z" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-800">NGO Portal</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600">Home</a>
                    <a href="{{ url('/#ngos') }}" class="text-gray-700 hover:text-blue-600">NGOs</a>
                    <a href="{{ url('/#gallery') }}" class="text-gray-700 hover:text-blue-600">Gallery</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Project Header -->
    <div class="bg-blue-600 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ $project->title }}</h1>
                    <div class="flex items-center text-blue-100">
                        <span class="mr-4">
                            <i class="fas fa-calendar-alt mr-1"></i> {{ $project->start_date->format('M Y') }} - {{ $project->end_date->format('M Y') }}
                        </span>
                        <span>
                            <i class="fas fa-map-marker-alt mr-1"></i> {{ $project->location }}
                        </span>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 flex flex-col md:flex-row items-start md:items-center space-y-2 md:space-y-0 md:space-x-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $project->status == 'active' ? 'bg-green-100 text-green-800' : ($project->status == 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                        <i class="fas fa-circle text-xs mr-1"></i>
                        {{ ucfirst($project->status) }}
                    </span>
                    @if($project->focusArea)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-200 text-blue-800">
                        <i class="fas fa-tag text-xs mr-1"></i>
                        {{ $project->focusArea->name }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Project Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Project Overview -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Project Overview</h2>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 whitespace-pre-line">{{ $project->description }}</p>
                        
                    </div>
                </div>

                <!-- Project Gallery -->
                @if($project->galleries->count() > 0)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Project Gallery</h2>
                    </div>
                    <div class="p-6">
                        <div id="lightgallery" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($project->galleries as $image)
                            <div class="gallery-item rounded-lg overflow-hidden shadow-sm" data-src="{{ asset('storage/' . $image->image_path) }}">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Project Image" class="w-full h-40 object-cover">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-6">
                <!-- Key Organizations -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900">Key Organizations</h2>
                    </div>
                    <div class="p-6 space-y-5">
                        <!-- Donner Organization -->
                        <div>
                            <div class="text-sm font-medium text-gray-500 mb-1">Project Donner</div>
                            <div class="flex items-center">
                                @if($project->donner->logo)
                                <img src="{{ asset('storage/' . $project->donner->logo) }}" alt="{{ $project->donner->name }} Logo" class="h-8 w-8 rounded-full object-cover mr-2">
                                @else
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mr-2">
                                    <span class="text-blue-600 font-semibold">{{ substr($project->donner->name, 0, 1) }}</span>
                                </div>
                                @endif
                                <span class="text-gray-900 font-medium">{{ $project->donner->name }}</span>
                            </div>
                        </div>

                        <!-- Runner Organization -->
                        <div>
                            <div class="text-sm font-medium text-gray-500 mb-1">Project Runner</div>
                            <div class="flex items-center">
                                @if($project->runner->logo)
                                <img src="{{ asset('storage/' . $project->runner->logo) }}" alt="{{ $project->runner->name }} Logo" class="h-8 w-8 rounded-full object-cover mr-2">
                                @else
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mr-2">
                                    <span class="text-blue-600 font-semibold">{{ substr($project->runner->name, 0, 1) }}</span>
                                </div>
                                @endif
                                <span class="text-gray-900 font-medium">{{ $project->runner->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Major Activities -->
                @if(is_array($project->major_activities) && count($project->major_activities) > 0)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900">Major Activities</h2>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-2">
                            @foreach($project->major_activities as $activity)
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                <span class="text-gray-700">{{ $activity }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} NGO Portal. All rights reserved.</p>
        </div>
    </footer>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize lightGallery
        if (document.getElementById('lightgallery')) {
            lightGallery(document.getElementById('lightgallery'), {
                selector: '.gallery-item',
                plugins: [lgZoom, lgThumbnail],
                speed: 500,
                download: false,
                mode: 'lg-fade',
                counter: true,
                loop: true,
                backdropDuration: 400
            });
        }
    });
    </script>
</body>
</html> 