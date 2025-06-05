<x-app-layout>
    <div class="p-4">
        <!-- Flash Messages -->
        @include('projects.partials.flash-messages')

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 relative">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Projects</h1>
                <p class="text-gray-600 mt-1.5">Manage projects where you are a runner or donner NGO</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('projects.create') }}"
                    class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-[#9229AD] to-[#7A1E93] font-medium text-white rounded-lg shadow-sm hover:shadow-xl transition-all duration-300 group relative overflow-hidden">
                    <span
                        class="absolute inset-0 bg-gradient-to-r from-[#D4AF37]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    New Project
                </a>
            </div>
        </div>

        <!-- Role Tabs -->
        <div class="bg-white rounded-xl shadow-sm mb-6 border border-gray-100" x-data="{ activeTab: '{{ request()->route()->getName() == 'projects.runner' ? 'runner' : 'donner' }}' }">
            <div class="flex border-b border-gray-200">
                <a href="{{ route('projects.runner') }}" 
                   class="px-6 py-4 text-center flex-1 font-medium text-sm"
                   :class="activeTab === 'runner' ? 'border-b-2 border-[#9229AD] text-[#9229AD]' : 'text-gray-500 hover:text-gray-700'"
                   @click.prevent="activeTab = 'runner'; window.location.href='{{ route('projects.runner') }}'">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        My Runner Projects
                    </span>
                    <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Can Edit
                    </span>
                </a>
                <a href="{{ route('projects.donner') }}" 
                   class="px-6 py-4 text-center flex-1 font-medium text-sm"
                   :class="activeTab === 'donner' ? 'border-b-2 border-[#9229AD] text-[#9229AD]' : 'text-gray-500 hover:text-gray-700'"
                   @click.prevent="activeTab = 'donner'; window.location.href='{{ route('projects.donner') }}'">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        My Donner Projects
                    </span>
                    <span class="ml-2 bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        View Only
                    </span>
                </a>
            </div>
        </div>

        <!-- Filter Card -->
        @include('projects.partials.filter-card')

        <!-- Project Listings -->
        <div class="space-y-6">
            @foreach($grouped as $letter => $group)
            <section id="section-{{ $letter }}"
                class="scroll-mt-20 p-6 rounded-xl border border-gray-200 {{ ($loop->iteration % 2 == 0) ? 'bg-[#F2E0DB]' : 'bg-[#D1E7EC]' }}">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 pb-2 border-b border-gray-200/50 flex items-center">
                        <span
                            class="w-10 h-10 bg-white rounded-lg shadow-sm flex items-center justify-center mr-3 text-[#9229AD] font-bold">{{ $letter }}</span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($group as $project)
                    <a href="{{ route('projects.show', $project['id']) }}"
                        class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 hover:-translate-y-0.5">
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">{{ $project['organization'] }}</p>
                                    <h3 class="text-lg font-semibold text-gray-800 leading-tight">
                                        {{ $project['name'] }}</h3>
                                </div>
                                <span class="text-xs bg-purple-100 text-purple-800 px-2.5 py-1 rounded-full">
                                    {{ $project['focus_area_name'] ?? '-' }}
                                </span>
                            </div>

                            <div class="space-y-2.5 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt text-gray-400 mr-2 w-4"></i>
                                    <span>{{ $project['location'] }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-dollar-sign text-gray-400 mr-2 w-4"></i>
                                    <span>${{ $project['budget'] }} Budget</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="far fa-calendar text-gray-400 mr-2 w-4"></i>
                                    <span>{{ $project['start_date'] }} - {{ $project['end_date'] }}</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-3 border-t">
                                @if($project['status'] == 'active')
                                <span
                                    class="bg-green-50 text-green-600 px-2.5 py-1 rounded-full text-xs font-medium">
                                    <i class="fas fa-check-circle mr-1"></i> {{ $project['status'] }}
                                </span>
                                @elseif($project['status'] == 'completed')
                                <span
                                    class="bg-violet-50 text-violet-600 px-2.5 py-1 rounded-full text-xs font-medium">
                                    <i class="fas fa-flag-checkered mr-1"></i> {{ $project['status'] }}
                                </span>
                                @else
                                <span
                                    class="bg-amber-50 text-amber-600 px-2.5 py-1 rounded-full text-xs font-medium">
                                    <i class="fas fa-clock mr-1"></i> {{ $project['status'] }}
                                </span>
                                @endif

                                <div class="flex -space-x-2">
                                    <button
                                        class="text-purple-500 hover:text-purple-700 text-sm font-medium flex items-center">
                                        Details <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
            @endforeach
        </div>

        @if(count($grouped) === 0)
        <div class="bg-white p-8 rounded-xl shadow-sm text-center border border-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No projects found</h3>
            <p class="mt-1 text-gray-500">Try adjusting your filters to find what you're looking for.</p>
            <a href="{{ route('projects.index') }}"
                class="mt-4 inline-flex items-center px-6 py-2 bg-gradient-to-r from-[#9229AD] to-[#7A1E93] text-white rounded-lg shadow hover:shadow-md transition-all duration-300">
                Reset Filters
            </a>
        </div>
        @endif
    </div>
</x-app-layout> 