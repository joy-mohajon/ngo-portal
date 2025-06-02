<div class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-gray-100">
    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#9229AD]" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                clip-rule="evenodd" />
        </svg>
        Filter Projects
    </h2>
    <form method="GET" action="{{ route(request()->route()->getName()) }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <div class="relative">
                <select id="status" name="status"
                    class="appearance-none w-full pl-3 pr-10 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-[#9229AD] focus:ring focus:ring-[#9229AD] focus:ring-opacity-50 bg-white">
                    <option value="">All Statuses</option>
                    @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ $status }}</option>
                    @endforeach
                </select>
                <div
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
        </div>

        <div>
            <label for="sector" class="block text-sm font-medium text-gray-700 mb-1">Sector</label>
            <div class="relative">
                <select id="sector" name="sector"
                    class="appearance-none w-full pl-3 pr-10 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-[#9229AD] focus:ring focus:ring-[#9229AD] focus:ring-opacity-50 bg-white">
                    <option value="">All Sectors</option>
                    @foreach($sectors as $sector)
                    <option value="{{ $sector }}" {{ request('sector') == $sector ? 'selected' : '' }}>
                        {{ $sector }}
                    </option>
                    @endforeach
                </select>
                <div
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
        </div>

        <div>
            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
            <div class="relative">
                <select id="location" name="location"
                    class="appearance-none w-full pl-3 pr-10 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-[#9229AD] focus:ring focus:ring-[#9229AD] focus:ring-opacity-50 bg-white">
                    <option value="">All Locations</option>
                    @foreach($locations as $location)
                    <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                        {{ $location }}</option>
                    @endforeach
                </select>
                <div
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
        </div>

        <div>
            <label for="organization" class="block text-sm font-medium text-gray-700 mb-1">Organization</label>
            <div class="relative">
                <select id="organization" name="organization"
                    class="appearance-none w-full pl-3 pr-10 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-[#9229AD] focus:ring focus:ring-[#9229AD] focus:ring-opacity-50 bg-white">
                    <option value="">All Organizations</option>
                    @foreach($organizations as $org)
                    <option value="{{ $org }}" {{ request('organization') == $org ? 'selected' : '' }}>
                        {{ $org }}</option>
                    @endforeach
                </select>
                <div
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="md:col-span-4 flex justify-end space-x-3">
            <button type="submit"
                class="px-4 py-2 bg-gradient-to-r from-[#9229AD] to-[#7A1E93] text-white rounded-lg shadow hover:shadow-md transition-all duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                        clip-rule="evenodd" />
                </svg>
                Apply Filters
            </button>
            <a href="{{ route(request()->route()->getName()) }}"
                class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                        clip-rule="evenodd" />
                </svg>
                Reset
            </a>
        </div>
    </form>
</div> 