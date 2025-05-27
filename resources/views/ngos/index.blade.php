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
                <h1 class="text-2xl font-bold text-gray-900">NGO Directory</h1>
                <p class="text-gray-600 text-sm mt-1">Browse organizations alphabetically</p>
            </div>
            <!-- <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                <a href="{{ route('ngos.create') }}" class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-[#00ACC1] hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add New NGO
                </a>
            </div> -->
        </div>

        <!-- NGO Listings -->
        <div class="space-y-12" x-data="{ activeTab: 'all', activeLetter: 'all' }">
            <!-- Focus Area Tabs -->
            <div class="mb-8">
                <div class="flex flex-wrap border-b border-gray-200">
                    <button @click="activeTab = 'all'; activeLetter = 'all'"
                        :class="{ 'bg-white text-green-600 border-b-2 border-green-600': activeTab === 'all' }"
                        class="px-6 py-3 font-medium text-sm rounded-t-lg transition-colors duration-200">
                        All NGOs ({{ $allNgos->count() }})
                    </button>

                    @foreach($focusAreas as $focusArea)
                    <button @click="activeTab = '{{ $focusArea->slug }}'; activeLetter = 'all'"
                        :class="{ 'bg-white rounded-t-lg text-green-600 border-b-2 border-green-600': activeTab === '{{ $focusArea->slug }}' }"
                        class="px-6 py-3 font-medium text-sm transition-colors duration-200">
                        {{ $focusArea->name }} ({{ $focusArea->ngos_count }})
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Tab Contents -->
            <div>
                <!-- A-Z Navigation -->
                <div class="flex flex-wrap justify-start gap-2 mb-8" x-show="activeTab === 'all'">
                    @php
                    $activeLetters = $grouped->keys()->map(function($letter) {
                    return strtoupper($letter);
                    })->toArray();
                    @endphp

                    <button @click="activeLetter = 'all'"
                        :class="{ 'bg-[#9229AD] text-white': activeLetter === 'all', ' bg-gray-300 hover:bg-gray-200': activeLetter !== 'all' }"
                        class="w-10 h-10 flex items-center justify-center rounded-lg font-medium text-sm transition-colors duration-200 shadow">
                        All
                    </button>

                    @foreach(range('A', 'Z') as $letter)
                    @if(in_array($letter, $activeLetters))
                    <button @click="activeLetter = '{{ $letter }}'"
                        :class="{ 'bg-[#9229AD] text-white': activeLetter === '{{ $letter }}', 'bg-gray-300 hover:bg-[#9229AD] hover:text-white': activeLetter !== '{{ $letter }}' }"
                        class="w-10 h-10 flex items-center justify-center rounded-lg font-medium text-sm transition-colors duration-200 shadow">
                        {{ $letter }}
                    </button>
                    @else
                    <span
                        class="w-10 h-10 flex items-center justify-center rounded-lg font-medium text-sm shadow bg-gray-100 text-gray-400 cursor-not-allowed">
                        {{ $letter }}
                    </span>
                    @endif
                    @endforeach
                </div>

                <!-- All NGOs Content (Alphabetical) -->
                <div x-show="activeTab === 'all'" x-transition x-cloak>
                    @foreach($grouped as $letter => $ngos)
                    <div x-show="activeLetter === 'all' || activeLetter === '{{ $letter }}'"
                        class="mb-4 {{ ($loop->iteration % 2 == 0)? 'bg-[#F2E0DB]' : 'bg-[#D1E7EC]'}} p-6 rounded-2xl">
                        <h2 class="text-2xl font-bold mb-4">Section {{ $letter }}</h2>
                        <div class="flex flex-1 flex-wrap justify-start items-center gap-6">
                            @foreach($ngos as $ngo)
                            @include('ngos.partials.card', ['ngo' => $ngo])
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Focus Area Contents -->
                @foreach($focusAreas as $focusArea)
                <div x-show="activeTab === '{{ $focusArea->slug }}'" x-transition x-cloak
                    class="p-6 rounded-2xl {{ ($loop->iteration % 2 == 0)? 'bg-[#F2E0DB]' : 'bg-[#D1E7EC]'}}">
                    <h2 class="text-2xl font-bold mb-6">{{ $focusArea->name }}</h2>
                    <div class="flex flex-1 flex-wrap justify-start items-center gap-6">
                        @foreach($focusArea->ngos as $ngo)
                        @include('ngos.partials.card', ['ngo' => $ngo])
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>