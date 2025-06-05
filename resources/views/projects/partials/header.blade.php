<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">{{ $project->title }}</h1>
        <div class="flex items-center mt-2">
            <span class="px-3 py-1 rounded-full text-xs font-semibold
                {{ $project->status == 'active' ? 'bg-emerald-100 text-emerald-800' : 
                   ($project->status == 'completed' ? 'bg-blue-100 text-blue-800' : 
                   ($project->status == 'suspended' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-700')) 
                }}">
                {{ ucfirst($project->status) }}
            </span>
            <span class="ml-3 text-gray-600 text-sm flex items-center">
                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ $project->location }}
            </span>
            
            <!-- Project Role Indicators -->
            @auth
                @if(Auth::user()->ngo)
                    @if(Auth::user()->ngo->id === $project->runner_id)
                        <span class="ml-3 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                            <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Runner NGO
                        </span>
                    @elseif(Auth::user()->ngo->id === $project->donner_id)
                        <span class="ml-3 bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                            <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Donner NGO
                        </span>
                    @endif
                @endif
            @endauth
        </div>
    </div>
    <div class="mt-4 md:mt-0 flex space-x-3">
        @auth
            @if(Auth::user()->hasRole('ngo') && Auth::user()->ngo)
                @if(Auth::user()->ngo->id === $project->runner_id)
                    <!-- Runner NGO Actions -->
                    <a href="{{ route('projects.runner') }}"
                        class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to My Projects
                    </a>
                    <a href="{{ route('projects.edit', $project->id) }}"
                        class="flex items-center px-4 py-2 bg-indigo-600 rounded-lg shadow-sm text-sm font-medium text-white hover:bg-indigo-700">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Project
                    </a>
                @elseif(Auth::user()->ngo->id === $project->donner_id)
                    <!-- Donner NGO Actions (View Only) -->
                    <a href="{{ route('projects.donner') }}"
                        class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to My Projects
                    </a>
                    <div class="flex items-center px-4 py-2 bg-gray-100 rounded-lg shadow-sm text-sm font-medium text-gray-500 cursor-not-allowed">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        View Only
                    </div>
                @else
                    <!-- Default Back Button for NGOs not associated with this project -->
                    <a href="{{ route('projects.index') }}"
                        class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Projects
                    </a>
                @endif
            @else
                <!-- Admin or Public User Actions -->
                <a href="{{ route('projects.index') }}"
                    class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Projects
                </a>
                @can('update', $project)
                <a href="{{ route('projects.edit', $project->id) }}"
                    class="flex items-center px-4 py-2 bg-indigo-600 rounded-lg shadow-sm text-sm font-medium text-white hover:bg-indigo-700">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Project
                </a>
                @endcan
            @endif
        @else
            <!-- Public User (Not Logged In) -->
            <a href="{{ route('projects.index') }}"
                class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Projects
            </a>
        @endauth
    </div>
</div>