<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-6 py-5 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 flex items-center">
            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Project Overview
        </h3>
    </div>
    <div class="px-6 py-5">
        <div class="prose max-w-none text-gray-700 mb-6">
            {{ $project->description }}
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h4 class="text-sm font-medium text-gray-500">Focus Area</h4>
                <p class="mt-1 text-sm text-gray-900">{{ $project->focus_area }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500">Budget</h4>
                <p class="mt-1 text-sm text-gray-900">৳{{ number_format($project->budget, 2) }} (BDT)</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500">Start Date</h4>
                <p class="mt-1 text-sm text-gray-900">
                    {{ $project->start_date ? $project->start_date->format('M d, Y') : '-' }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500">End Date</h4>
                <p class="mt-1 text-sm text-gray-900">
                    {{ $project->end_date ? $project->end_date->format('M d, Y') : 'Ongoing' }}</p>
            </div>
            <!-- <div>
                <h4 class="text-sm font-medium text-gray-500">Beneficiaries</h4>
                <p class="mt-1 text-sm text-gray-900">1,250 farming families</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500">Coverage Area</h4>
                <p class="mt-1 text-sm text-gray-900">12 villages in Pirgachha</p>
            </div> -->

        </div>
    </div>
</div>