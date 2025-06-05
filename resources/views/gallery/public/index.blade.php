<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery | NGO Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        .gallery-item {
            position: relative;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
        }
        
        .gallery-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }
        
        .gallery-item img {
            transition: all 0.5s ease;
            transform-origin: center;
        }
        
        .gallery-item:hover img {
            transform: scale(1.08);
        }
        
        .gallery-item .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.2) 50%, rgba(0, 0, 0, 0) 100%);
            opacity: 0.85;
            transition: all 0.4s ease;
            z-index: 1;
        }
        
        .gallery-item:hover .overlay {
            opacity: 0.95;
        }
        
        .gallery-item .focus-area-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            z-index: 2;
            padding: 6px 12px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #1e40af;
            font-weight: 600;
            font-size: 0.75rem;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover .focus-area-badge {
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .gallery-item .ngo-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            background-color: rgba(37, 99, 235, 0.9);
            color: white;
            font-weight: 500;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover .ngo-badge {
            background-color: rgb(37, 99, 235);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
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
                    <a href="{{ url('/public/gallery') }}" class="text-blue-600 font-medium">Gallery</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-800 to-blue-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="text-4xl font-bold font-serif">Project Gallery</h1>
                    <p class="mt-2 text-blue-100 text-lg">Explore photos from NGO projects across the country</p>
                </div>
                <div class="flex items-center bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                    <div class="text-center px-4 border-r border-white/20">
                        <div class="text-3xl font-bold">{{ $galleryImages->total() }}</div>
                        <div class="text-sm text-blue-100">Total Images</div>
                    </div>
                    <div class="text-center px-4 border-r border-white/20">
                        <div class="text-3xl font-bold">{{ $totalProjects }}</div>
                        <div class="text-sm text-blue-100">Projects</div>
                    </div>
                    <div class="text-center px-4">
                        <div class="text-3xl font-bold">{{ $focusAreas->count() }}</div>
                        <div class="text-sm text-blue-100">Focus Areas</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Filters -->
        <div class="mb-10 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-lg font-bold text-gray-800">Filter Gallery</h2>
                <div class="text-sm text-gray-500">
                    Showing {{ $galleryImages->firstItem() ?? 0 }}-{{ $galleryImages->lastItem() ?? 0 }} of {{ $galleryImages->total() }} images
                </div>
            </div>
            
            <form action="{{ route('gallery.public.index') }}" method="GET" class="flex flex-wrap gap-4">
                <!-- Focus Area Filter -->
                <div class="w-full md:w-1/3">
                    <label for="focus_area" class="block text-sm font-medium text-gray-700 mb-1">Focus Area</label>
                    <select name="focus_area" id="focus_area" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Focus Areas</option>
                        @foreach($focusAreas as $area)
                            <option value="{{ $area->id }}" {{ request('focus_area') == $area->id ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- NGO Filter -->
                <div class="w-full md:w-1/3">
                    <label for="ngo" class="block text-sm font-medium text-gray-700 mb-1">NGO</label>
                    <select name="ngo" id="ngo" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All NGOs</option>
                        @foreach($ngos as $ngo)
                            <option value="{{ $ngo->id }}" {{ request('ngo') == $ngo->id ? 'selected' : '' }}>
                                {{ $ngo->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Submit Button -->
                <div class="w-full md:w-auto flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                        <i class="fas fa-filter mr-1"></i> Apply Filter
                    </button>
                    @if(request('focus_area') || request('ngo'))
                        <a href="{{ route('gallery.public.index') }}" class="ml-2 text-gray-600 hover:text-gray-800 font-medium py-2 px-4 border border-gray-300 rounded-md transition duration-200">
                            <i class="fas fa-times mr-1"></i> Clear Filters
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Gallery Heading -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">
                @if(request('ngo') && $ngos->where('id', request('ngo'))->first())
                    {{ $ngos->where('id', request('ngo'))->first()->name }} Images
                @elseif(request('focus_area') && $focusAreas->where('id', request('focus_area'))->first())
                    {{ $focusAreas->where('id', request('focus_area'))->first()->name }} Project Images
                @else
                    All Project Images
                @endif
            </h2>
            
            <div class="flex items-center gap-3 text-sm text-gray-500">
                <span class="hidden md:flex items-center gap-1">
                    <i class="fas fa-th-large text-gray-400"></i> Grid View
                </span>
                <span class="hidden md:inline text-gray-300">|</span>
                <span class="flex items-center gap-1">
                    <i class="fas fa-sort-amount-down text-gray-400 mr-1"></i> 
                    Sorted by Latest
                </span>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @forelse($galleryImages as $image)
                <div class="gallery-item">
                    <a href="{{ route('projects.public.details', $image->project_id) }}" class="block">
                        <div class="overlay"></div>
                        
                        @if(isset($image->project) && isset($image->project->focusArea))
                        <div class="focus-area-badge">
                            {{ $image->project->focusArea->name }}
                        </div>
                        @endif
                        
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                            alt="{{ $image->project_title ?? 'Project Image' }}" class="w-full h-64 object-cover">
                        
                        <div class="absolute bottom-0 left-0 right-0 px-5 py-4 z-10">
                            <h3 class="text-white font-bold text-xl mb-3 leading-tight">{{ $image->project_title }}</h3>
                            
                            @if(isset($image->project))
                            <div class="flex items-center text-white/80 text-sm mb-3">
                                @if(isset($image->project->location))
                                <span class="flex items-center">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    {{ $image->project->location }}
                                </span>
                                @endif
                            </div>
                            @endif
                            
                            <div class="flex items-center">
                                <div class="ngo-badge">
                                    <svg class="w-4 h-4 mr-2 opacity-90" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                    </svg>
                                    {{ $image->ngo_name }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-3 py-12 text-center">
                    <div class="bg-white rounded-lg shadow-sm p-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No images found</h3>
                        <p class="mt-2 text-gray-500">There are no images matching your filter criteria. Please try a different filter or check back later.</p>
                        <div class="mt-6">
                            <a href="{{ route('gallery.public.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                View all images
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            <div class="bg-white p-4 rounded-lg shadow-sm">
                {{ $galleryImages->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <svg class="h-8 w-8 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3z" />
                        </svg>
                        <span class="ml-2 text-xl font-bold">NGO Portal</span>
                    </div>
                    <p class="text-gray-400 mb-4 max-w-md">
                        Connecting NGOs and government authorities for greater transparency, accountability, and impact.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ url('/') }}" class="hover:text-white">Home</a></li>
                        <li><a href="{{ url('/#ngos') }}" class="hover:text-white">NGOs</a></li>
                        <li><a href="{{ url('/public/gallery') }}" class="hover:text-white">Gallery</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-2"></i>
                            <span>123 Development Rd, Dhaka, Bangladesh</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            <span>info@ngoportal.org</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            <span>+880 1712 345678</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} NGO Portal. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth scrolling to focus area filter change
        const filterSelect = document.getElementById('focus_area');
        if (filterSelect) {
            filterSelect.addEventListener('change', function() {
                // Add a subtle highlight effect
                this.classList.add('ring-2', 'ring-blue-300');
                setTimeout(() => {
                    this.classList.remove('ring-2', 'ring-blue-300');
                }, 500);
            });
        }
        
        // Add smooth scrolling to NGO filter change
        const ngoSelect = document.getElementById('ngo');
        if (ngoSelect) {
            ngoSelect.addEventListener('change', function() {
                // Add a subtle highlight effect
                this.classList.add('ring-2', 'ring-blue-300');
                setTimeout(() => {
                    this.classList.remove('ring-2', 'ring-blue-300');
                }, 500);
            });
        }
    });
    </script>
</body>
</html> 