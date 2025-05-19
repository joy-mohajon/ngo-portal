<x-app-layout>
    <div class="p-4">
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 relative">
            <div class="relative">
                <div class="absolute -left-4 -top-2 w-3 h-3 bg-[#D4AF37] rounded-full"></div>
                <h1 class="text-2xl font-bold text-gray-900">Project Portfolio</h1>
                <p class="text-gray-600 mt-2">Browse and manage all active initiatives</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="#" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#9229AD] to-[#7A1E93] text-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 group relative overflow-hidden">
                    <span class="absolute inset-0 bg-gradient-to-r from-[#D4AF37]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    New Project
                </a>
            </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-gray-100">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#9229AD]" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
            </svg>
            Filter Projects
        </h2>
        <form method="GET" action="{{ route('projects.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <div class="relative">
                    <select id="status" name="status" class="appearance-none w-full pl-3 pr-10 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-[#9229AD] focus:ring focus:ring-[#9229AD] focus:ring-opacity-50 bg-white">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div>
                <label for="sector" class="block text-sm font-medium text-gray-700 mb-1">Sector</label>
                <div class="relative">
                    <select id="sector" name="sector" class="appearance-none w-full pl-3 pr-10 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-[#9229AD] focus:ring focus:ring-[#9229AD] focus:ring-opacity-50 bg-white">
                        <option value="">All Sectors</option>
                        @foreach($sectors as $sector)
                            <option value="{{ $sector }}" {{ request('sector') == $sector ? 'selected' : '' }}>{{ $sector }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                <div class="relative">
                    <select id="location" name="location" class="appearance-none w-full pl-3 pr-10 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-[#9229AD] focus:ring focus:ring-[#9229AD] focus:ring-opacity-50 bg-white">
                        <option value="">All Locations</option>
                        @foreach($locations as $location)
                            <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>{{ $location }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div>
                <label for="organization" class="block text-sm font-medium text-gray-700 mb-1">Organization</label>
                <div class="relative">
                    <select id="organization" name="organization" class="appearance-none w-full pl-3 pr-10 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-[#9229AD] focus:ring focus:ring-[#9229AD] focus:ring-opacity-50 bg-white">
                        <option value="">All Organizations</option>
                        @foreach($organizations as $org)
                            <option value="{{ $org }}" {{ request('organization') == $org ? 'selected' : '' }}>{{ $org }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="md:col-span-4 flex justify-end space-x-3">
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-[#9229AD] to-[#7A1E93] text-white rounded-lg shadow hover:shadow-md transition-all duration-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                    Apply Filters
                </button>
                <a href="{{ route('projects.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                    </svg>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Alphabet Navigation -->
    <div class="bg-white p-4 rounded-xl shadow-sm mb-6 border border-gray-100">
        <div class="flex flex-wrap gap-2">
            @foreach($letters as $letter)
                <a href="#section-{{ $letter }}" class="w-10 h-10 flex items-center justify-center rounded-lg font-medium text-sm shadow transition-all duration-200
                    {{ in_array($letter, $activeLetters) ? 'bg-gradient-to-br from-[#9229AD] to-[#7A1E93] text-white hover:shadow-md' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}">
                    {{ $letter }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Project Listings -->
    <div class="space-y-6">
        @foreach($grouped as $letter => $group)
            <section id="section-{{ $letter }}" class="scroll-mt-20 p-6 rounded-xl border border-gray-100 {{ ($loop->iteration % 2 == 0) ? 'bg-gradient-to-br from-[#E8D4F0] to-[#E8D4F0]/50' : 'bg-gradient-to-br from-[#D1E7EC] to-[#D1E7EC]/50' }}">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 pb-2 border-b border-gray-200/50 flex items-center">
                        <span class="w-10 h-10 bg-white rounded-lg shadow-sm flex items-center justify-center mr-3 text-[#9229AD] font-bold">{{ $letter }}</span>
                        Projects starting with {{ $letter }}
                    </h2>
                </div>

                <div class="flex flex-wrap gap-6 items-start">
                    @foreach($group as $index => $project)
                        @if($index < 2)
                            <!-- Featured Cards -->
                            <a href="{{ route('projects.show', $project['id']) }}" class="flex flex-col bg-white rounded-xl p-5 w-[300px] border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 group">
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-tr from-gray-50 to-gray-100 rounded-lg flex items-center justify-center overflow-hidden mr-4 flex-shrink-0 border border-gray-100 group-hover:border-[#9229AD]/30 transition-all">
                                        <span class="text-[#9229AD] text-lg uppercase font-bold">{{ substr($project['organization'], 0, 2) }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="font-semibold text-gray-900 truncate group-hover:text-[#9229AD] transition-colors">{{ $project['name'] }}</h3>
                                        <p class="text-[#9229AD] text-sm mt-1 truncate">{{ $project['organization'] }}</p>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center text-sm">
                                        <span class="text-gray-500 mr-2">Sector:</span>
                                        <span class="text-gray-800 font-medium">{{ $project['sector'] }}</span>
                                    </div>
                                    <div class="flex items-center text-sm">
                                        <span class="text-gray-500 mr-2">Location:</span>
                                        <span>{{ $project['location'] }}</span>
                                    </div>
                                    <div class="flex items-center text-sm">
                                        <span class="text-gray-500 mr-2">Status:</span>
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $project['status'] == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $project['status'] }}</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
                                    <span class="text-xs text-[#9229AD] font-medium flex items-center">
                                        View Details
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                            </a>
                        @elseif($index == 2)
                            <!-- Spacer Block -->
                            <div class="w-20 h-16 bg-white rounded-lg flex items-center justify-center text-gray-400 border border-gray-100 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                        @else
                            <!-- List Items -->
                            <a href="{{ route('projects.show', $project['id']) }}" class="block w-full bg-white p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 group">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center overflow-hidden mr-3 flex-shrink-0 border border-gray-100 group-hover:border-[#9229AD]/30 transition-all">
                                            <span class="text-[#9229AD] text-sm font-medium">{{ substr($project['organization'], 0, 2) }}</span>
                                        </div>
                                        <div class="min-w-0">
                                            <h3 class="font-medium text-gray-900 truncate group-hover:text-[#9229AD] transition-colors">{{ $project['name'] }}</h3>
                                            <p class="text-gray-600 text-xs mt-1 truncate">{{ $project['organization'] }}</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $project['status'] == 'Active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $project['status'] }}</span>
                                        <span class="text-xs text-gray-500 mt-1">{{ $project['sector'] }}</span>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>

    @if(count($grouped) === 0)
        <div class="bg-white p-8 rounded-xl shadow-sm text-center border border-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No projects found</h3>
            <p class="mt-1 text-gray-500">Try adjusting your filters to find what you're looking for.</p>
            <a href="{{ route('projects.index') }}" class="mt-4 inline-flex items-center px-6 py-2 bg-gradient-to-r from-[#9229AD] to-[#7A1E93] text-white rounded-lg shadow hover:shadow-md transition-all duration-300">
                Reset Filters
            </a>
        </div>
    @endif
</div>

   
</x-app-layout>