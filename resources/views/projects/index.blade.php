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

        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8">
            <div class="mb-4 md:mb-0">
                <h1 class="text-2xl font-bold text-gray-900">Project Directory</h1>
                <p class="text-gray-600 text-sm mt-1">Browse development projects alphabetically</p>
            </div>
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                <a href="#" class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-[#00ACC1] hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add New Project
                </a>
            </div>
        </div>

        <!-- Alphabet navigation -->
        <div class="mb-8">
            <div class="flex flex-wrap gap-2">
                @php
                    // Color palette
                    $colorPalette = [
                        'emerald' => ['bg-emerald-100', 'bg-emerald-200'],
                        'violet' => ['bg-violet-100', 'bg-violet-200'],
                        'purple' => ['bg-purple-100', 'bg-purple-200'],
                        'green' => ['bg-green-100', 'bg-green-200'],
                        'fuchsia' => ['bg-fuchsia-100', 'bg-fuchsia-200'],
                        'indigo' => ['bg-indigo-100', 'bg-indigo-200'],
                        'teal' => ['bg-teal-100', 'bg-teal-200'],
                        'cyan' => ['bg-cyan-100', 'bg-cyan-200'],
                        'rose' => ['bg-rose-100', 'bg-rose-200'],
                        'sky' => ['bg-sky-100', 'bg-sky-200'],
                        'pink' => ['bg-pink-100', 'bg-pink-200'],
                        'blue' => ['bg-blue-100', 'bg-blue-200']
                    ];
                    
                    $colorSequence = [
                        'indigo', 'green', 'purple', 'blue', 'emerald',
                        'fuchsia',  'teal', 'cyan', 'violet',
                        'rose', 'sky', 'pink', 
                        'indigo', 'violet', 'emerald', 'teal',
                        'fuchsia', 'purple', 'green', 'cyan'
                    ];
                    
                    // Static project data grouped by first letter
                    $projects = [
                        [
                            'id' => 1,
                            'name' => 'Digital Financial Inclusion',
                            'organization' => 'BRAC',
                            'email' => 'info@brac.net',
                            'start_date' => '2023-01-01',
                            'sector' => 'Financial Inclusion',
                            'location' => 'Nationwide',
                            'status' => 'Active'
                        ],
                        [
                            'id' => 2,
                            'name' => 'Ultra-Poor Graduation Program',
                            'organization' => 'BRAC',
                            'email' => 'info@brac.net',
                            'start_date' => '2022-07-01',
                            'sector' => 'Poverty Alleviation',
                            'location' => 'Rural Areas',
                            'status' => 'Active'
                        ],
                        [
                            'id' => 3,
                            'name' => 'Skills Development for Youth',
                            'organization' => 'SKUS',
                            'email' => 'info@skus-bd.org',
                            'start_date' => '2023-02-01',
                            'sector' => 'Education',
                            'location' => 'Urban Areas',
                            'status' => 'Active'
                        ],
                        [
                            'id' => 4,
                            'name' => 'Ultra-Poor Graduation Initiative',
                            'organization' => 'Shelter',
                            'email' => 'info@shelter.org.bd',
                            'start_date' => '2021-01-01',
                            'sector' => 'Poverty Alleviation',
                            'location' => 'Rural Areas',
                            'status' => 'Active'
                        ],
                        [
                            'id' => 5,
                            'name' => 'Floating Hospitals',
                            'organization' => 'SKUS',
                            'email' => 'info@skus-bd.org',
                            'start_date' => '2020-01-01',
                            'sector' => 'Healthcare',
                            'location' => 'Coastal Areas',
                            'status' => 'Active'
                        ],
                        [
                            'id' => 6,
                            'name' => 'Climate Adaptation',
                            'organization' => 'SKUS',
                            'email' => 'info@skus-bd.org',
                            'start_date' => '2022-09-01',
                            'sector' => 'Climate Change',
                            'location' => 'Coastal Areas',
                            'status' => 'Active'
                        ],
                        [
                            'id' => 7,
                            'name' => 'Education Support',
                            'organization' => 'ASA',
                            'email' => 'contact@asa.org.bd',
                            'start_date' => '2023-01-01',
                            'sector' => 'Education',
                            'location' => 'Urban Slums',
                            'status' => 'Active'
                        ],
                        [
                            'id' => 8,
                            'name' => "Women's Empowerment",
                            'organization' => 'Friendship',
                            'email' => 'info@friendship.ngo',
                            'start_date' => '2023-03-01',
                            'sector' => 'Women Empowerment',
                            'location' => 'Urban Areas',
                            'status' => 'Active'
                        ],
                        [
                            'id' => 9,
                            'name' => 'Education for Underprivileged Children',
                            'organization' => 'ASA',
                            'email' => 'contact@asa.org.bd',
                            'start_date' => '2022-01-01',
                            'sector' => 'Education',
                            'location' => 'Rural Areas',
                            'status' => 'Active'
                        ],
                        [
                            'id' => 10,
                            'name' => "Women's Empowerment",
                            'organization' => 'Shelter',
                            'email' => 'info@shelter.org.bd',
                            'start_date' => '2023-01-01',
                            'sector' => 'Women Empowerment',
                            'location' => 'Rural Areas',
                            'status' => 'Active'
                        ]
                    ];
                    
                    // Group projects by first letter of their name
                    $grouped = [];
                    foreach ($projects as $project) {
                        $firstLetter = strtoupper(substr($project['name'], 0, 1));
                        if (!isset($grouped[$firstLetter])) {
                            $grouped[$firstLetter] = [];
                        }
                        $grouped[$firstLetter][] = $project;
                    }
                    
                    // Sort alphabetically
                    ksort($grouped);
                    
                    // Get active letters for navigation
                    $activeLetters = array_keys($grouped);
                    $letters = range('A', 'Z');
                @endphp
                
                @foreach($letters as $letter)
                    <a href="#section-{{ $letter }}" class="w-10 h-10 flex items-center justify-center rounded-lg font-medium text-sm shadow
                        {{ in_array($letter, $activeLetters) ? 'bg-[#9229AD] text-white hover:bg-[#7A1E93]' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}">
                        {{ $letter }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Project Listings -->
        <div class="space-y-4">
            @foreach($grouped as $letter => $group)
                @php
                    $letterIndex = array_search($letter, range('A', 'Z'));
                    $colorName = $colorSequence[$letterIndex % count($colorSequence)];
                    $bgClass = $colorPalette[$colorName][0]; // 100-level for card
                    $logoBgClass = $colorPalette[$colorName][1]; // 100-level for logo
                @endphp

                <section id="section-{{ $letter }}" class="scroll-mt-20 p-6 rounded-2xl {{ ($loop->iteration % 2 == 0)? 'bg-[#E8D4F0]' : 'bg-[#D1E7EC]'}}">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 border-b border-gray-200 pb-2">Section {{ $letter }}</h2>
                    </div>

                    <div class="flex flex-wrap gap-6 items-start">
                        @foreach($group as $index => $project)
                            @if($index < 2)
                                <!-- Featured Cards -->
                                <a href="#" class="flex flex-col shadow bg-gradient-to-tl from-white to-transparent-300 rounded-lg p-4 w-[280px] border border-gray-200 hover:shadow-md transition-all">
                                    <div class="flex items-center mb-3">
                                        <div class="w-16 h-16 bg-gradient-to-tr from-gray-100 to-gray-50 group-hover:from-gray-200 group-hover:to-gray-100 transition-all rounded-lg flex items-center justify-center overflow-hidden mr-4 flex-shrink-0">
                                            <span class="text-green-600 text-lg uppercase font-medium">{{ substr($project['organization'], 0, 2) }}</span>
                                        </div>
                                        <div class="min-w-0">
                                            <h3 class="font-semibold text-gray-900 truncate">{{ $project['name'] }}</h3>
                                            <p class="text-green-600 text-sm mt-1 truncate">{{ $project['organization'] }}</p>
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
                                            <span class="px-2 py-1 rounded-full text-xs {{ $project['status'] == 'Active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $project['status'] }}</span>
                                        </div>
                                    </div>
                                </a>
                            @elseif($index == 2)
                                <!-- Spacer Block -->
                                <div class="w-20 h-16 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 border border-gray-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                            @else
                                <!-- List Items -->
                                <a href="#" class="block w-full {{ $bgClass }} p-4 rounded-lg border border-gray-200 hover:shadow-md transition-all">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 {{ $logoBgClass }} rounded-lg flex items-center justify-center overflow-hidden mr-3 flex-shrink-0">
                                                <span class="{{ str_replace('bg-', 'text-', str_replace('-200', '-600', $logoBgClass)) }} text-sm">{{ substr($project['organization'], 0, 2) }}</span>
                                            </div>
                                            <div class="min-w-0">
                                                <h3 class="font-medium text-gray-900 truncate">{{ $project['name'] }}</h3>
                                                <p class="text-gray-600 text-xs mt-1 truncate">{{ $project['organization'] }}</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            <span class="px-2 py-1 rounded-full text-xs {{ $project['status'] == 'Active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $project['status'] }}</span>
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
    </div>

    <style>
        .scroll-mt-20 {
            scroll-margin-top: 5rem;
        }
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</x-app-layout>