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
                    <a href="#" class="text-gray-700 hover:text-blue-600">NGOs</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600">Projects</a>
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

    <!-- Search Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md p-6 -mt-10">
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" placeholder="Search NGOs by name, sector, or location..."
                            class="w-full px-5 py-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <button
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sector</label>
                        <select
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option>All Categories</option>
                            <option>Education</option>
                            <option>Healthcare</option>
                            <option>Environment</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <select
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option>All Regions</option>
                            <option>Dhaka</option>
                            <option>Chittagong</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Project Type</label>
                        <select
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option>All Projects</option>
                            <option>Ongoing</option>
                            <option>Completed</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-200">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured NGOs -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 font-serif">Verified NGO Partners</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Trusted organizations working with government authorities
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- NGO Card 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <img src="{{ asset('images/brac-logo.png') }}" alt="BRAC Logo" class="h-12">
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Govt.
                                Verified</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">BRAC</h3>
                        <p class="text-gray-600 mb-6">
                            Largest NGO in Bangladesh focusing on poverty alleviation through multifaceted programs.
                        </p>
                        <div class="flex justify-between mb-6">
                            <div class="text-center">
                                <span class="block text-2xl font-bold text-blue-600">1,200+</span>
                                <span class="text-sm text-gray-500">Projects</span>
                            </div>
                            <div class="text-center">
                                <span class="block text-2xl font-bold text-green-600">98%</span>
                                <span class="text-sm text-gray-500">Success Rate</span>
                            </div>
                        </div>
                        <button
                            class="w-full border border-blue-600 text-blue-600 hover:bg-blue-50 py-2 px-4 rounded-lg transition duration-200">
                            View Profile
                        </button>
                    </div>
                </div>

                <!-- NGO Card 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <img src="{{ asset('images/asa-logo.png') }}" alt="ASA Logo" class="h-12">
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Govt.
                                Verified</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">ASA</h3>
                        <p class="text-gray-600 mb-6">
                            Microfinance institution providing financial services to low-income populations.
                        </p>
                        <div class="flex justify-between mb-6">
                            <div class="text-center">
                                <span class="block text-2xl font-bold text-blue-600">850+</span>
                                <span class="text-sm text-gray-500">Projects</span>
                            </div>
                            <div class="text-center">
                                <span class="block text-2xl font-bold text-green-600">95%</span>
                                <span class="text-sm text-gray-500">Success Rate</span>
                            </div>
                        </div>
                        <button
                            class="w-full border border-blue-600 text-blue-600 hover:bg-blue-50 py-2 px-4 rounded-lg transition duration-200">
                            View Profile
                        </button>
                    </div>
                </div>

                <!-- NGO Card 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <img src="{{ asset('images/grameen-logo.png') }}" alt="Grameen Logo" class="h-12">
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Govt.
                                Verified</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Grameen Foundation</h3>
                        <p class="text-gray-600 mb-6">
                            Works to replicate the Grameen Bank microcredit model worldwide.
                        </p>
                        <div class="flex justify-between mb-6">
                            <div class="text-center">
                                <span class="block text-2xl font-bold text-blue-600">700+</span>
                                <span class="text-sm text-gray-500">Projects</span>
                            </div>
                            <div class="text-center">
                                <span class="block text-2xl font-bold text-green-600">97%</span>
                                <span class="text-sm text-gray-500">Success Rate</span>
                            </div>
                        </div>
                        <button
                            class="w-full border border-blue-600 text-blue-600 hover:bg-blue-50 py-2 px-4 rounded-lg transition duration-200">
                            View Profile
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-12 text-center">
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                    View All NGOs
                </button>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 font-serif">Authority-Approved Projects</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Collaborative initiatives making measurable impact
                </p>
            </div>

            <div class="flex justify-center mb-8">
                <div class="inline-flex rounded-md shadow-sm">
                    <button class="px-6 py-2 text-sm font-medium rounded-l-lg bg-blue-600 text-white">
                        Ongoing
                    </button>
                    <button
                        class="px-6 py-2 text-sm font-medium border-t border-b border-gray-300 text-gray-700 hover:bg-gray-50">
                        Completed
                    </button>
                    <button
                        class="px-6 py-2 text-sm font-medium rounded-r-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                        High Impact
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Project Card 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="md:flex">
                        <div class="md:flex-shrink-0">
                            <img class="h-48 w-full md:w-48 object-cover"
                                src="{{ asset('images/education-project.jpg') }}" alt="Education project">
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <span
                                    class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Ongoing</span>
                                <span class="text-xs text-gray-500">Ministry of Education</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Digital Education for Rural Bangladesh</h3>
                            <p class="text-gray-600 text-sm mb-4">
                                Providing tablet-based learning to 50,000 students in remote areas with BRAC and
                                government partnership.
                            </p>
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-500 mb-1">
                                    <span>Progress</span>
                                    <span>65%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: 65%"></div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <img class="h-10 w-10 rounded-full" src="{{ asset('images/minister-avatar.jpg') }}"
                                    alt="Minister">
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500 italic">"This project shows how NGO-govt
                                        collaboration should work."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Card 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="md:flex">
                        <div class="md:flex-shrink-0">
                            <img class="h-48 w-full md:w-48 object-cover" src="{{ asset('images/health-project.jpg') }}"
                                alt="Health project">
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Completed</span>
                                <span class="text-xs text-gray-500">Ministry of Health</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Community Health Worker Training</h3>
                            <p class="text-gray-600 text-sm mb-4">
                                Trained 5,000 community health workers to provide primary care in underserved regions.
                            </p>
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-500 mb-1">
                                    <span>Progress</span>
                                    <span>100%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <img class="h-10 w-10 rounded-full"
                                    src="{{ asset('images/health-minister-avatar.jpg') }}" alt="Health Minister">
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500 italic">"Exceeded all targets with measurable health
                                        improvements."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Indicators -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 font-serif">Built for Transparency</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Our platform ensures accountability at every step
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300">
                    <div
                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 text-blue-600 mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Verified Reporting</h3>
                    <p class="text-gray-600">
                        All projects include audited impact reports with government validation
                    </p>
                </div>
                <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300">
                    <div
                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 text-green-600 mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Real-time Tracking</h3>
                    <p class="text-gray-600">
                        Monitor project progress with live updates and milestones
                    </p>
                </div>
                <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300">
                    <div
                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 text-purple-600 mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Secure Platform</h3>
                    <p class="text-gray-600">
                        Enterprise-grade security with role-based access control
                    </p>
                </div>
                <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300">
                    <div
                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 text-yellow-600 mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Standardized Processes</h3>
                    <p class="text-gray-600">
                        Government-approved workflows for seamless collaboration
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-blue-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold font-serif mb-6">Ready to Collaborate?</h2>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto mb-8">
                Join the platform trusted by 500+ NGOs and 20+ government agencies
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <button
                    class="bg-white text-blue-700 hover:bg-gray-100 px-8 py-3 rounded-lg font-medium transition duration-200">
                    Register Your NGO
                </button>
                <button
                    class="border-2 border-white text-white hover:bg-blue-800 px-8 py-3 rounded-lg font-medium transition duration-200">
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
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <a href="#" class="flex items-center">
                        <svg class="h-8 w-8 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3z" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-white">NGOConnect</span>
                    </a>
                    <p class="mt-4 text-sm">
                        Connecting NGOs and Authorities since 2023
                    </p>
                    <div class="mt-6 flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider">Platform</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-sm hover:text-white">Features</a></li>
                        <li><a href="#" class="text-sm hover:text-white">How It Works</a></li>
                        <li><a href="#" class="text-sm hover:text-white">Pricing</a></li>
                        <li><a href="#" class="text-sm hover:text-white">API</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider">Resources</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-sm hover:text-white">Documentation</a></li>
                        <li><a href="#" class="text-sm hover:text-white">Help Center</a></li>
                        <li><a href="#" class="text-sm hover:text-white">Webinars</a></li>
                        <li><a href="#" class="text-sm hover:text-white">Community</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider">Contact</h3>
                    <address class="mt-4 not-italic">
                        <div class="text-sm">Level 5, Tech Hub</div>
                        <div class="text-sm">Dhaka 1212, Bangladesh</div>
                        <div class="mt-2 text-sm"><a href="mailto:contact@ngoconnect.gov.bd"
                                class="hover:text-white">contact@ngoconnect.gov.bd</a></div>
                        <div class="text-sm"><a href="tel:+880212345678" class="hover:text-white">+880 2 12345678</a>
                        </div>
                    </address>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between">
                <p class="text-sm">&copy; 2023 NGO Collaboration Platform. All rights reserved.</p>
                <div class="mt-4 md:mt-0 flex space-x-6">
                    <a href="#" class="text-sm hover:text-white">Privacy Policy</a>
                    <a href="#" class="text-sm hover:text-white">Terms of Service</a>
                    <a href="#" class="text-sm hover:text-white">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Help Button -->
    <div class="fixed bottom-6 right-6">
        <button class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg transition duration-200">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
        </button>
    </div>
</body>

</html>