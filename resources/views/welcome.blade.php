<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGO Connect | Government Collaboration Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    .gallery-item img {
        transition: all 0.4s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.05);
    }
    
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

    .animate-fadeIn {
        animation: fadeIn 0.5s ease-in-out forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="#" class="flex items-center">
                        <svg class="h-8 w-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3z" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-800">NGO Portal</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-gray-700 hover:text-blue-600">Home</a>
                    <a href="#ngos" class="text-gray-700 hover:text-blue-600">NGOs</a>
                    <a href="#gallery" class="text-gray-700 hover:text-blue-600">Gallery</a>
                    <a href="{{ route('gallery.public.index') }}" class="text-gray-700 hover:text-blue-600">All Images</a>
                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                        @auth
                        <a href="{{ url('/dashboard') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                        @else
                        <a href="{{ route('login') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                            in</a>

                        @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                        @endauth
                    </button>
                </div>
                <div class="md:hidden flex items-center">
                    <!-- Mobile menu button -->
                    <button class="text-gray-500 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-800 to-blue-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold font-serif leading-tight mb-6">
                    Empowering NGOs.<br>Trusted by Authorities.
                </h1>
                <p class="text-lg text-blue-100 mb-8">
                    Search verified NGOs, track development projects, and measure impact with transparent reporting.
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    @auth
                    <a href="{{ url('/dashboard') }}"
                        class="bg-white text-blue-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-medium transition duration-200 text-center">
                        Go to Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                        class="bg-white text-blue-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-medium transition duration-200 text-center">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="border-2 border-white text-white hover:bg-blue-700 px-6 py-3 rounded-lg font-medium transition duration-200 text-center">
                        Register
                    </a>
                    @endauth
                </div>
                <div class="mt-10 flex items-center space-x-6">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="ml-2 text-sm">Government Verified</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2 text-sm">ISO Certified</span>
                    </div>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <div class="relative">
                    <div class="absolute -right-4 -bottom-4 w-full h-full bg-blue-400 rounded-xl opacity-50"></div>
                    <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/20 to-transparent rounded-xl"></div>
                    <img src="{{ asset('images/hero-illustration.jpg') }}" alt="Collaboration Illustration"
                        class="w-full max-w-md rounded-xl shadow-xl relative z-10 animate-float">
                </div>
            </div>
        </div>
    </section>

    <!-- Project Gallery Section -->
    <section id="gallery" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 font-serif">Latest Projects</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Explore recent images from our NGO projects
                </p>
            </div>

            <!-- Focus Area Filter -->
            <div class="flex flex-wrap justify-center gap-3 mb-10">
                <button type="button" data-focus-area=""
                    class="focus-filter px-4 py-2 rounded-full text-sm font-medium {{ !request('focus_area') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    All Projects
                </button>
                @foreach($projectFocusAreas as $area)
                <button type="button" data-focus-area="{{ $area->id }}"
                    class="focus-filter px-4 py-2 rounded-full text-sm font-medium {{ request('focus_area') == $area->id ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    {{ $area->name }}
                </button>
                @endforeach
            </div>

            <!-- Gallery Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                            <h3 class="text-white font-bold text-xl mb-3 leading-tight">{{ $image->project_title ?? 'Project' }}</h3>
                            
                            <div class="flex items-center">
                                <div class="ngo-badge">
                                    <svg class="w-4 h-4 mr-2 opacity-90" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                    </svg>
                                    {{ $image->ngo_name ?? 'NGO' }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-span-3 text-center py-10">
                    <p class="text-gray-500">No gallery images available</p>
                </div>
                @endforelse
            </div>

            <!-- View All Projects Button -->
            <div class="text-center mt-12">
                <a href="{{ route('gallery.public.index') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out">
                    View All Images
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured NGOs -->
    <section id="ngos" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 font-serif">Verified NGO Partners</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    All verified organizations working with government authorities
                </p>
            </div>

            <!-- NGO Focus Area Filter -->
            @if(count($ngoFocusAreas) > 0)
            <div class="mb-10">
                <h3 class="text-lg font-medium text-gray-800 mb-4 text-center">Filter NGOs by Expertise</h3>
                <div class="flex flex-wrap justify-center gap-2">
                    <button type="button" data-ngo-focus-area=""
                        class="ngo-focus-filter px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ !$selectedNgoFocusArea ? 'bg-blue-600 text-white' : 'bg-white border-2 border-blue-600 text-blue-700 hover:bg-blue-50' }}">
                        All Areas
                    </button>
                    @foreach($ngoFocusAreas as $area)
                    <button type="button" data-ngo-focus-area="{{ $area->id }}"
                        class="ngo-focus-filter px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ $selectedNgoFocusArea == $area->id ? 'bg-blue-600 text-white' : 'bg-white border-2 border-blue-600 text-blue-700 hover:bg-blue-50' }}">
                        {{ $area->name }}
                    </button>
                    @endforeach
                </div>
            </div>
            @endif

            <div id="ngos-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($ngos as $ngo)
                <!-- NGO Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            @if($ngo->logo)
                            <img src="{{ asset('storage/' . $ngo->logo) }}" alt="{{ $ngo->name }} Logo"
                                class="h-12 object-contain">
                            @else
                            <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-lg">{{ substr($ngo->name, 0, 1) }}</span>
                            </div>
                            @endif
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Govt.
                                Verified</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $ngo->name }}</h3>
                        <p class="text-gray-600 mb-6">
                            {{ Str::limit($ngo->description ?? 'Working on development and social welfare projects', 120) }}
                        </p>
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($ngo->focusAreas->take(3) as $area)
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                {{ $area->name }}
                            </span>
                            @endforeach
                            @if($ngo->focusAreas->count() > 3)
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">
                                +{{ $ngo->focusAreas->count() - 3 }} more
                            </span>
                            @endif
                        </div>
                        <a href="{{ route('ngos.show', $ngo) }}"
                            class="block w-full text-center border border-blue-600 text-blue-600 hover:bg-blue-50 py-2 px-4 rounded-lg transition duration-200">
                            View Profile
                        </a>
                    </div>
                </div>
                @empty
                <!-- No NGOs Found Message -->
                <div class="col-span-3 text-center py-12">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-700 mb-2">No NGOs Available</h3>
                    <p class="text-gray-500 max-w-md mx-auto">
                        Currently, there are no verified NGO partners in the system. Please check back later.
                    </p>
                </div>
                @endforelse
            </div>

            <!-- Load More Button -->
            <div class="mt-10 text-center" id="load-more-container">
                @if(isset($ngos) && $ngos->count() > 6)
                <button id="load-more-ngos"
                    class="inline-block bg-white border border-blue-600 text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg transition duration-200">
                    Load More NGOs
                </button>
                @else
                <button id="load-more-ngos" style="display: none;"
                    class="inline-block bg-white border border-blue-600 text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg transition duration-200">
                    Load More NGOs
                </button>
                @endif
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Join Our Network Today</h2>
            <p class="max-w-2xl mx-auto mb-8 text-blue-100">
                Register your NGO and connect with government authorities, access funding opportunities, and showcase
                your impact.
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                @auth
                <a href="{{ url('/dashboard') }}"
                    class="bg-white text-blue-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-medium transition duration-200">
                    Go to Dashboard
                </a>
                @else
                <a href="{{ route('register') }}"
                    class="bg-white text-blue-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-medium transition duration-200">
                    Register Now
                </a>
                <a href="{{ route('login') }}"
                    class="border-2 border-white text-white hover:bg-blue-700 px-6 py-3 rounded-lg font-medium transition duration-200">
                    Login
                </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
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
                        <li><a href="#" class="hover:text-white">Home</a></li>
                        <li><a href="#" class="hover:text-white">About Us</a></li>
                        <li><a href="#" class="hover:text-white">NGOs</a></li>
                        <li><a href="{{ route('gallery.public.index') }}" class="hover:text-white">Gallery</a></li>
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
        // Handle project focus area filter clicks
        document.querySelectorAll('.focus-filter').forEach(button => {
            button.addEventListener('click', function() {
                const focusArea = this.getAttribute('data-focus-area');
                
                // Update active button styling
                document.querySelectorAll('.focus-filter').forEach(btn => {
                    btn.classList.remove('bg-blue-600', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700',
                        'hover:bg-gray-300');
                });

                this.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                this.classList.add('bg-blue-600', 'text-white');

                // Show loading indicator
                const galleryGrid = document.querySelector('.grid');
                galleryGrid.innerHTML =
                    '<div class="col-span-3 text-center py-10"><div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-600"></div><p class="mt-2 text-gray-600">Loading images...</p></div>';
                
                // Fetch filtered gallery images
                fetch(`/api/gallery-images${focusArea ? '?focus_area=' + focusArea : ''}`)
                    .then(response => response.json())
                    .then(data => {
                        // Update URL without reloading the page
                        const url = new URL(window.location);
                        if (focusArea) {
                            url.searchParams.set('focus_area', focusArea);
                        } else {
                            url.searchParams.delete('focus_area');
                        }
                        window.history.pushState({}, '', url);
                        
                        // Update gallery with new images
                        updateGallery(data);
                    })
                    .catch(error => {
                        console.error('Error fetching gallery images:', error);
                        galleryGrid.innerHTML =
                            '<div class="col-span-3 text-center py-10"><p class="text-red-500">Error loading images. Please try again.</p></div>';
                    });
            });
        });

        // Handle NGO focus area filter clicks
        document.querySelectorAll('.ngo-focus-filter').forEach(button => {
            button.addEventListener('click', function() {
                const focusArea = this.getAttribute('data-ngo-focus-area');

                // Update all buttons to inactive state
                document.querySelectorAll('.ngo-focus-filter').forEach(btn => {
                    // Remove active styling
                    btn.classList.remove('bg-blue-600', 'text-white');
                    btn.classList.add('bg-white', 'border-2', 'border-blue-600',
                        'text-blue-700', 'hover:bg-blue-50');
                });

                // Apply active styling to clicked button
                this.classList.remove('bg-white', 'border-2', 'border-blue-600',
                    'text-blue-700', 'hover:bg-blue-50');
                this.classList.add('bg-blue-600', 'text-white');

                // Show loading indicator
                const ngosGrid = document.getElementById('ngos-grid');
                ngosGrid.innerHTML =
                    '<div class="col-span-3 text-center py-10"><div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-600"></div><p class="mt-2 text-gray-600">Loading NGOs...</p></div>';

                // Fetch filtered NGOs
                fetch(`/api/ngos-by-focus-area${focusArea ? '?focus_area=' + focusArea : ''}`)
                    .then(response => response.json())
                    .then(data => {
                        // Update URL without reloading the page
                        const url = new URL(window.location);
                        if (focusArea) {
                            url.searchParams.set('ngo_focus_area', focusArea);
                        } else {
                            url.searchParams.delete('ngo_focus_area');
                        }
                        window.history.pushState({}, '', url);

                        // Update NGO grid with new NGOs
                        updateNgos(data);
                    })
                    .catch(error => {
                        console.error('Error fetching NGOs:', error);
                        ngosGrid.innerHTML =
                            '<div class="col-span-3 text-center py-10"><p class="text-red-500">Error loading NGOs. Please try again.</p></div>';
                    });
            });
        });

        // Handle Load More NGOs button
        const loadMoreNgosBtn = document.getElementById('load-more-ngos');
        if (loadMoreNgosBtn) {
            const ngoCards = document.querySelectorAll('#ngos-grid > div');
            const cardsPerPage = 6;
            let currentlyShown = cardsPerPage;

            // Initially hide cards beyond the first page
            for (let i = cardsPerPage; i < ngoCards.length; i++) {
                ngoCards[i].style.display = 'none';
            }

            loadMoreNgosBtn.addEventListener('click', function() {
                // Show the next batch of cards
                for (let i = currentlyShown; i < currentlyShown + cardsPerPage && i < ngoCards
                    .length; i++) {
                    ngoCards[i].style.display = 'block';

                    // Add a fade-in effect
                    ngoCards[i].classList.add('animate-fadeIn');
                }

                currentlyShown += cardsPerPage;

                // Hide button if all cards are shown
                if (currentlyShown >= ngoCards.length) {
                    loadMoreNgosBtn.style.display = 'none';
                }
            });
        }

        function updateGallery(images) {
            const galleryGrid = document.querySelector('.grid');

            if (images.length === 0) {
                galleryGrid.innerHTML =
                    '<div class="col-span-3 text-center py-10"><p class="text-gray-500">No gallery images available</p></div>';
                return;
            }

            // Clear existing gallery
            galleryGrid.innerHTML = '';

            // Add new images
            images.forEach(image => {
                const galleryItem = createGalleryItem(image);
                galleryGrid.appendChild(galleryItem);
            });
        }

        function updateNgos(ngos) {
            const ngosGrid = document.getElementById('ngos-grid');
            
            if (ngos.length === 0) {
                ngosGrid.innerHTML = `
                    <div class="col-span-3 text-center py-12">
                        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-700 mb-2">No NGOs Found</h3>
                        <p class="text-gray-500 max-w-md mx-auto">
                            No NGOs match the selected filter criteria. Please try a different filter.
                        </p>
                    </div>
                `;
                
                // Hide load more button when no NGOs
                document.getElementById('load-more-ngos').style.display = 'none';
                return;
            }

            // Clear existing NGOs
            ngosGrid.innerHTML = '';

            // Add new NGOs
            ngos.forEach(ngo => {
                const ngoCard = document.createElement('div');
                ngoCard.className =
                    'bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300';

                // Create focus areas HTML
                let focusAreasHtml = '';
                ngo.focus_areas.forEach(area => {
                    focusAreasHtml += `
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                            ${area.name}
                        </span>
                    `;
                });

                if (ngo.focus_areas_count > 3) {
                    focusAreasHtml += `
                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">
                            +${ngo.focus_areas_count - 3} more
                        </span>
                    `;
                }

                ngoCard.innerHTML = `
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            ${ngo.logo ? 
                                `<img src="${ngo.logo}" alt="${ngo.name} Logo" class="h-12 object-contain">` : 
                                `<div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-semibold text-lg">${ngo.name.charAt(0)}</span>
                                </div>`
                            }
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Govt. Verified</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">${ngo.name}</h3>
                        <p class="text-gray-600 mb-6">
                            ${ngo.description.length > 120 ? ngo.description.substring(0, 120) + '...' : ngo.description}
                        </p>
                        <div class="flex flex-wrap gap-2 mb-6">
                            ${focusAreasHtml}
                        </div>
                        <a href="${ngo.profile_url}"
                            class="block w-full text-center border border-blue-600 text-blue-600 hover:bg-blue-50 py-2 px-4 rounded-lg transition duration-200">
                            View Profile
                        </a>
                    </div>
                `;

                ngosGrid.appendChild(ngoCard);
            });

            // Set up load more functionality
            const ngoCards = document.querySelectorAll('#ngos-grid > div');
            const cardsPerPage = 6;
            let currentlyShown = cardsPerPage;

            // Show/hide load more button
            const loadMoreBtn = document.getElementById('load-more-ngos');
            loadMoreBtn.style.display = ngoCards.length > cardsPerPage ? 'inline-block' : 'none';

            // Initially hide cards beyond the first page
            for (let i = cardsPerPage; i < ngoCards.length; i++) {
                ngoCards[i].style.display = 'none';
            }
        }

        // Function to create a gallery item element
        function createGalleryItem(image) {
            const galleryItem = document.createElement('div');
            galleryItem.className = 'gallery-item';
            
            galleryItem.innerHTML = `
                <a href="/projects/${image.project_id}/details" class="block">
                    <div class="overlay"></div>
                    
                    ${image.focus_area_name ? 
                    `<div class="focus-area-badge">
                        ${image.focus_area_name}
                    </div>` : ''}
                    
                    <img src="/storage/${image.image_path}" alt="${image.project_title || 'Project Image'}"
                        class="w-full h-64 object-cover">
                    
                    <div class="absolute bottom-0 left-0 right-0 px-5 py-4 z-10">
                        <h3 class="text-white font-bold text-xl mb-3 leading-tight">${image.project_title || 'Project'}</h3>
                        
                        <div class="flex items-center">
                            <div class="ngo-badge">
                                <svg class="w-4 h-4 mr-2 opacity-90" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                </svg>
                                ${image.ngo_name || 'NGO'}
                            </div>
                        </div>
                    </div>
                </a>
            `;
            
            return galleryItem;
        }
    });
    </script>
</body>

</html>