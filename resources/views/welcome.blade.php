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
    <!-- Light Gallery -->
    <link href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/zoom/lg-zoom.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/thumbnail/lg-thumbnail.min.js"></script>
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
        transition: all 0.3s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.05);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
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
                        <span class="ml-2 text-xl font-bold text-gray-800">NGOConnect</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-gray-700 hover:text-blue-600">Home</a>
                    <a href="#ngos" class="text-gray-700 hover:text-blue-600">NGOs</a>
                    <a href="#gallery" class="text-gray-700 hover:text-blue-600">Gallery</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600">About</a>
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
                    <button
                        class="bg-white text-blue-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-medium transition duration-200">
                        Login
                    </button>
                    <button
                        class="border-2 border-white text-white hover:bg-blue-700 px-6 py-3 rounded-lg font-medium transition duration-200">
                        How It Works
                    </button>
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
                <img src="{{ asset('images/hero-illustration.png') }}" alt="Collaboration Illustration"
                    class="w-full max-w-md animate-float">
            </div>
        </div>
    </section>

    <!-- Project Gallery Section -->
    <section id="gallery" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 font-serif">Project Gallery</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Explore our impactful projects through captivating imagery
                </p>
            </div>

            <!-- Focus Area Filter -->
            <div class="flex flex-wrap justify-center gap-3 mb-10">
                <a href="{{ route('welcome') }}"
                    class="px-4 py-2 rounded-full text-sm font-medium {{ !request('focus_area') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    All Projects
                </a>
                @foreach($focusAreas as $area)
                <a href="{{ route('welcome', ['focus_area' => $area->id]) }}"
                    class="px-4 py-2 rounded-full text-sm font-medium {{ request('focus_area') == $area->id ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    {{ $area->name }}
                </a>
                @endforeach
            </div>

            <!-- Gallery Grid -->
            <div id="lightgallery" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($galleryImages as $image)
                <div class="gallery-item" data-src="{{ asset('storage/' . $image->image_path) }}">
                    <div
                        class="rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 bg-white h-full flex flex-col">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->project_title }}"
                                class="w-full h-64 object-cover">
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                <h3 class="text-white font-semibold">{{ $image->project_title }}</h3>
                                @if($image->project->focusArea)
                                <span class="inline-block bg-blue-600 text-white text-xs px-2 py-1 rounded-full mt-1">
                                    {{ $image->project->focusArea->name }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-10">
                    <p class="text-gray-500">No gallery images available</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Featured NGOs -->
    <section id="ngos" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 font-serif">Verified NGO Partners</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Trusted organizations working with government authorities
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredNgos as $ngo)
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
                        </div>
                        <a href="{{ route('ngos.show', $ngo) }}"
                            class="block w-full text-center border border-blue-600 text-blue-600 hover:bg-blue-50 py-2 px-4 rounded-lg transition duration-200">
                            View Profile
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-10 text-center">
                <a href="{{ route('ngos.index') }}"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200">
                    View All NGOs
                </a>
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
                        <span class="ml-2 text-xl font-bold">NGOConnect</span>
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
                        <li><a href="#" class="hover:text-white">Projects</a></li>
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
                            <span>info@ngoconnect.org</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            <span>+880 1712 345678</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} NGOConnect. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        lightGallery(document.getElementById('lightgallery'), {
            selector: '.gallery-item',
            plugins: [lgZoom, lgThumbnail],
            speed: 500,
            download: false,
            licenseKey: 'your-license-key',
        });
    });
    </script>
</body>

</html>