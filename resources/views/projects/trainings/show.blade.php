<x-app-layout>
    <div class="bg-white rounded-lg shadow p-6">
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

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Training Details</h1>
            <div class="flex space-x-3">
                <a href="{{ route('projects.trainings.index', $project) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
                @hasrole(['admin', 'ngo'])
                <a href="{{ route('projects.trainings.edit', $project, $training) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Training
                </a>
                @endhasrole
            </div>
        </div>

        <!-- Training Details -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Main Information -->
            <div class="md:col-span-2 bg-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold">{{ $training->title }}</h2>
                    @php
                    $status = strtolower($training->status);
                    $statusColors = [
                        'upcoming' => 'bg-blue-100 text-blue-800',
                        'ongoing' => 'bg-green-100 text-green-800',
                        'completed' => 'bg-gray-100 text-gray-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                    ];
                    $colorClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $colorClass }}">
                        {{ ucfirst($status) }}
                    </span>
                </div>
                
                <div class="prose max-w-none mb-6">
                    <p class="text-gray-700">{{ $training->description }}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Category</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $training->category }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Location</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $training->location }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Start Date</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $training->start_date->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">End Date</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $training->end_date->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Capacity</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $training->capacity }} participants</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Registration Deadline</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $training->registration_deadline->format('M d, Y') }}</p>
                    </div>
                </div>
                
                <!-- Schedule Section -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Schedule</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center mb-3">
                            <div class="h-4 w-4 rounded-full bg-blue-500 mr-2"></div>
                            <span class="text-sm text-gray-800">
                                <span class="font-medium">Start:</span> {{ $training->start_date->format('l, F d, Y') }} at {{ $training->start_date->format('h:i A') }}
                            </span>
                        </div>
                        <div class="flex items-center mb-3">
                            <div class="h-4 w-4 rounded-full bg-red-500 mr-2"></div>
                            <span class="text-sm text-gray-800">
                                <span class="font-medium">End:</span> {{ $training->end_date->format('l, F d, Y') }} at {{ $training->end_date->format('h:i A') }}
                            </span>
                        </div>
                        <div class="flex items-center mb-3">
                            <div class="h-4 w-4 rounded-full bg-yellow-500 mr-2"></div>
                            <span class="text-sm text-gray-800">
                                <span class="font-medium">Duration:</span> 
                                {{ $training->start_date->diffInDays($training->end_date) + 1 }} days
                                ({{ $training->start_date->diffForHumans($training->end_date, true) }})
                            </span>
                        </div>
                        <div class="flex items-center">
                            <div class="h-4 w-4 rounded-full bg-purple-500 mr-2"></div>
                            <span class="text-sm text-gray-800">
                                <span class="font-medium">Registration Closes:</span> {{ $training->registration_deadline->format('l, F d, Y') }}
                                @if($training->registration_deadline->isPast())
                                    <span class="text-red-500 font-medium">(Closed)</span>
                                @else
                                    <span class="text-green-500 font-medium">({{ $training->registration_deadline->diffForHumans() }})</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Side Information -->
            <div class="space-y-6">
                <!-- Organizer Information -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Organizer</h3>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12">
                            <img class="h-12 w-12 rounded-full" src="https://ui-avatars.com/api/?name={{ $training->organizer->name ?? 'Unknown' }}&background=random" alt="">
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">{{ $training->organizer->name ?? 'Not Assigned' }}</h4>
                            <p class="text-sm text-gray-500">{{ $training->organizer->email ?? '' }}</p>
                            <p class="text-xs text-gray-500 mt-1">Training Organizer</p>
                        </div>
                    </div>
                </div>
                
                <!-- Project Information -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Related Project</h3>
                    @if($training->project)
                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                        <a href="{{ route('projects.show', $training->project_id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">{{ $training->project->title }}</a>
                        <p class="text-xs text-gray-500 mt-1">
                            @php
                                $projectStatus = strtolower($training->project->status);
                                $projectStatusColors = [
                                    'active' => 'bg-green-100 text-green-800',
                                    'inactive' => 'bg-red-100 text-red-800',
                                    'suspended' => 'bg-yellow-100 text-yellow-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                ];
                                $projectColorClass = $projectStatusColors[$projectStatus] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $projectColorClass }}">
                                {{ ucfirst($projectStatus) }}
                            </span>
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            <span class="font-medium">Focus Area:</span> {{ $training->project->focus_area }}
                        </p>
                        <p class="text-xs text-gray-500">
                            <span class="font-medium">Location:</span> {{ $training->project->location }}
                        </p>
                    </div>
                    @else
                    <p class="text-sm text-gray-500">This training is not associated with any project.</p>
                    @endif
                </div>
                
                <!-- Registration Status -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Registration Status</h3>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-900">Capacity</span>
                        <span class="text-sm text-gray-500">{{ $training->capacity }} participants</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: 25%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>0 registered</span>
                        <span>{{ $training->capacity }}</span>
                    </div>
                    <div class="mt-4">
                        @if($training->registration_deadline->isPast() || $training->status === 'completed' || $training->status === 'cancelled')
                            <button disabled class="w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-md cursor-not-allowed">
                                Registration Closed
                            </button>
                        @else
                            <button class="w-full px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">
                                Register for Training
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 