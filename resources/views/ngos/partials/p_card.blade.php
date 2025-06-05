<div
    class="bg-white rounded-xl shadow overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300">
    <div class="p-6">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="text-xl font-bold text-gray-800">{{ $project->title }}</h3>
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
                <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Budget</h4>
                <p class="mt-1 text-gray-800 font-medium">{{ number_format($project->budget) }} BDT</p>
            </div>
        </div>
        <div class="mt-6 pt-4 border-t border-gray-100 flex justify-between items-center">
            <div class="flex space-x-2">
                <span class="text-base font-semibold text-gray-500">Run By: </span>
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">
                    {{ $project->runner->name ?? '-' }}
                </span>
                <span class="text-base font-semibold text-gray-500">Funded By: </span>
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $project->donner->name ?? '-' }}
                </span>
            </div>
            <a href="{{ route('projects.show', $project->id) }}"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                <i class="fas fa-eye mr-2"></i> View Details
            </a>
        </div>
    </div>
</div>