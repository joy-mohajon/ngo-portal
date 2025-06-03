<x-app-layout>
    <div class="p-4" x-data="{ activeTab: 'runner' }">
        <!-- NGO Header Section - Premium Redesign -->
        <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100">
            <div class="flex flex-col md:flex-row">
                <!-- Logo Section -->
                <div class="md:w-1/4 p-8 bg-gradient-to-br from-indigo-50 to-blue-50 flex items-center justify-center">
                    @if($ngo->logo)
                    <div class="p-4 bg-white rounded-xl shadow-inner border border-gray-100">
                        <img src="{{ asset('storage/' . $ngo->logo) }}?v={{ time() }}" alt="{{ $ngo->name }} logo"
                            class="h-32 w-32 object-contain">
                    </div>
                    @else
                    <div
                        class="h-32 w-32 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white text-3xl font-bold shadow-md">
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
                                <span
                                    class="px-3 py-1 text-xs rounded-full font-semibold
                                    {{ $ngo->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($ngo->status) }}
                                </span>
                                <span class="text-sm text-gray-600 bg-gray-50 px-3 py-1 rounded-full">
                                    <i class="fas fa-calendar-alt mr-1"></i> Est. {{ $ngo->established_year }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right bg-gray-50 px-4 py-2 rounded-lg">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Registration
                                ID</span>
                            <p class="font-mono text-gray-800 font-semibold">{{ $ngo->registration_id }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <p class="text-gray-600 font-medium">{{ $ngo->description }}</p>
                    </div>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Location</h3>
                            <p class="mt-1 text-gray-800 font-medium">{{ $ngo->location }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Website</h3>
                            <a href="{{ $ngo->website }}" class="mt-1 text-blue-600 font-medium">{{ $ngo->website }}</a>
                        </div>
                        <!-- <div class="bg-gray-100 p-4 rounded-lg">
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</h3>
                            <p class="mt-1 text-gray-800 font-medium">{{ $ngo->phone_number }}</p>
                        </div> -->
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Email</h3>
                            <p class="mt-1 text-blue-600 font-medium">{{ $ngo->email }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Focus Areas</h3>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach($ngo->focusAreas as $focusArea)
                                <span
                                    class="px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700 font-semibold">{{ $focusArea->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Focus Activities</h3>
                            <ul class="list-disc list-inside mt-1 text-gray-800 text-sm">
                                @foreach($ngo->focus_activities ?? [] as $activity)
                                <li>{{ $activity }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('ngos.partials.focal_persons_card', ['ngo' => $ngo, 'crudEnabled' => false])

        <!-- Projects Section -->
        <div class="mt-12">
            <div class="flex border-b border-gray-200">
                <button @click="activeTab = 'runner'"
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'runner', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'runner' }"
                    class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-lg flex items-center">
                    <i class="fas fa-running mr-2"></i>
                    Run By {{ $ngo->name }} ({{ $projectsRunner->count() }})
                </button>
                <button @click="activeTab = 'donner'"
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'donner', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'donner' }"
                    class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-lg flex items-center">
                    <i class="fas fa-coins mr-2"></i>
                    Funded By {{ $ngo->name }} ({{ $projectsDonner->count() }})
                </button>
                <button @click="activeTab = 'both'"
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'both', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'both' }"
                    class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-lg flex items-center">
                    <i class="fas fa-hand-holding-usd mr-2"></i>
                    Run & Funded By {{ $ngo->name }} ({{ $projectsBoth->count() }})
                </button>
            </div>

            <!-- Runner Projects -->
            <div x-show="activeTab === 'runner'" class="mt-6 grid grid-cols-1 gap-8">
                @forelse($projectsRunner as $project)
                <!-- Project card -->
                @include('ngos.partials.p_card', ['project' => $project])
                @empty
                <div class="bg-white rounded-xl shadow p-8 text-center border border-gray-100">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 font-medium">No running projects found</p>
                </div>
                @endforelse
            </div>

            <!-- Donner Projects -->
            <div x-show="activeTab === 'donner'" class="mt-6 grid grid-cols-1 gap-8" x-cloak>
                @forelse($projectsDonner as $project)
                <!-- Project card -->
                @include('ngos.partials.p_card', ['project' => $project])
                @empty
                <div class="bg-white rounded-xl shadow p-8 text-center border border-gray-100">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 font-medium">No donner projects found</p>
                </div>
                @endforelse
            </div>

            <!-- Both Projects -->
            <div x-show="activeTab === 'both'" class="mt-6 grid grid-cols-1 gap-8" x-cloak>
                @forelse($projectsBoth as $project)
                <!-- Project card -->
                @include('ngos.partials.p_card', ['project' => $project])
                @empty
                <div class="bg-white rounded-xl shadow p-8 text-center border border-gray-100">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 font-medium">No run & funded projects found</p>
                </div>
                @endforelse
            </div>
        </div>


    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</x-app-layout>