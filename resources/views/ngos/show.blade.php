<x-app-layout>
    <div class="p-4" x-data="{ activeTab: 'runner' }">
        <!-- NGO Header Section - Premium Redesign -->
        <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100">
            <div class="flex flex-col md:flex-row">
                <!-- Logo Section -->
                <div class="md:w-1/4 p-8 bg-gradient-to-br from-indigo-50 to-blue-50 flex items-center justify-center">
                    @if($ngo->logo)
                        <div class="p-4 bg-white rounded-xl shadow-inner border border-gray-100">
                            <img src="{{ asset('storage/' . $ngo->logo) }}" alt="{{ $ngo->name }} logo" class="h-32 w-32 object-contain">
                        </div>
                    @else
                        <div class="h-32 w-32 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white text-3xl font-bold shadow-md">
                            {{ substr($ngo->name, 0, 2) }}
                        </div>
                    @endif
                </div>
                
                <!-- Details Section -->
                <div class="md:w-3/4 p-8">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">{{ $ngo->name }}</h1>
                            <div class="mt-3 flex items-center space-x-3">
                                <span class="px-3 py-1 text-xs rounded-full font-semibold
                                    {{ $ngo->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($ngo->status) }}
                                </span>
                                <span class="text-sm text-gray-600 bg-gray-50 px-3 py-1 rounded-full">
                                    <i class="fas fa-calendar-alt mr-1"></i> Est. {{ $ngo->established_year }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right bg-gray-50 px-4 py-2 rounded-lg">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Registration ID</span>
                            <p class="font-mono text-gray-800 font-semibold">{{ $ngo->registration_id }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <p class="text-gray-600 font-medium">{{ $ngo->description }}</p>
                    </div>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Focus Area</h3>
                            <p class="mt-1 text-gray-800 font-medium">{{ $ngo->focus_area }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Location</h3>
                            <p class="mt-1 text-gray-800 font-medium">{{ $ngo->location }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Website</h3>
                            <a href="{{ $ngo->website }}" class="mt-1 text-blue-600 font-medium">{{ $ngo->website }}</a>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</h3>
                            <p class="mt-1 text-gray-800 font-medium">{{ $ngo->phone_number }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Email</h3>
                            <p class="mt-1 text-blue-600 font-medium">{{ $ngo->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Section -->
        <div class="mt-12">
            <div class="flex border-b border-gray-200">
                <button 
                    @click="activeTab = 'runner'" 
                    :class="{ 
                        'border-blue-500 text-blue-600': activeTab === 'runner',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'runner'
                    }" 
                    class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-lg flex items-center"
                >
                    <i class="fas fa-running mr-2"></i>
                    Run By {{ $ngo->name }} ({{ $projectsRunner->count() }})
                </button>
                <button 
                    @click="activeTab = 'holder'" 
                    :class="{ 
                        'border-blue-500 text-blue-600': activeTab === 'holder',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'holder'
                    }" 
                    class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-lg flex items-center"
                >
                <i class="fas fa-coins mr-2"></i>
                    Funded By {{ $ngo->name }} ({{ $projectsHolder->count() }})
                </button>
                <button 
                    @click="activeTab = 'both'" 
                    :class="{ 
                        'border-blue-500 text-blue-600': activeTab === 'both',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'both'
                    }" 
                    class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-lg flex items-center"
                >
                <i class="fas fa-hand-holding-usd mr-2"></i>
                    Run & Funded By {{ $ngo->name }} ({{ $projectsHolder->count() }})
                </button>
            </div>

            <!-- Runner Projects -->
            <div x-show="activeTab === 'runner'" class="mt-6 grid grid-cols-1 gap-8">
                @forelse($projectsRunner as $project)
                    <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">{{ $project->name }}</h3>
                                    <p class="mt-2 text-gray-600">{{ $project->description }}</p>
                                </div>

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $project->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </div>
                            
                            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-gray-100 p-3 rounded-lg">
                                    <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</h4>
                                    <p class="mt-1 text-gray-800 font-medium">{{ $project->start_date->format('M d, Y') }}</p>
                                </div>
                                <div class="bg-gray-100 p-3 rounded-lg">
                                    <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</h4>
                                    <p class="mt-1 text-gray-800 font-medium">{{ $project->end_date->format('M d, Y') }}</p>
                                </div>
                                <div class="bg-gray-100 p-3 rounded-lg">
                                    <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Budget</h4>
                                    <p class="mt-1 text-gray-800 font-medium">{{ number_format($project->budget) }} BDT</p>
                                </div>
                            </div>
                            
                            <div class="mt-6 pt-4 border-t border-gray-200 flex justify-between items-center">
                                <div class="flex space-x-2">
                                <span class="text-base font-semibold text-gray-500">Funded By: </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $project->holder->name }}
                                    </span>
                                </div>
                                
                                <a href="{{ route('projects.show', $project->id) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                    <i class="fas fa-eye mr-2"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow p-8 text-center border border-gray-100">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 font-medium">No running projects found</p>
                    </div>
                @endforelse
            </div>

            <!-- Holder Projects -->
            <div x-show="activeTab === 'holder'" class="mt-6 grid grid-cols-1 gap-8" x-cloak>
                @forelse($projectsHolder as $project)
                    <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6">
                        <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">{{ $project->name }}</h3>
                                    <p class="mt-2 text-gray-600">{{ $project->description }}</p>
                                </div>

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $project->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </div>
                            
                            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-gray-100 p-3 rounded-lg">
                                    <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Location</h4>
                                    <p class="mt-1 text-gray-800 font-medium">{{ $project->location }}</p>
                                </div>
                                <div class="bg-gray-100 p-3 rounded-lg">
                                    <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</h4>
                                    <p class="mt-1 text-gray-800 font-medium">
                                        {{ $project->start_date->format('M Y') }} - {{ $project->end_date->format('M Y') }}
                                    </p>
                                </div>
                                <div class="bg-gray-100 p-3 rounded-lg">
                                    <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Funding</h4>
                                    <p class="mt-1 text-gray-800 font-medium">{{ number_format($project->budget) }} BDT</p>
                                </div>
                            </div>
                            
                            <div class="mt-6 pt-4 border-t border-gray-100 flex justify-between items-center">
                                <div class="flex space-x-2">
                                    <span class="text-base font-semibold text-gray-500">Run By: </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">
                                        {{ $project->runner->name }}
                                    </span>
                                </div>
                                
                                <a href="{{ route('projects.show', $project->id) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                    <i class="fas fa-eye mr-2"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow p-8 text-center border border-gray-100">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 font-medium">No holding projects found</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</x-app-layout>