<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Rangpur Agricultural Development Project</h1>
        <div class="flex items-center mt-2">
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                Active
            </span>
            <span class="ml-3 text-gray-600 text-sm flex items-center">
                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Pirgachha Upazila, Rangpur
            </span>
        </div>
    </div>
    <div class="mt-4 md:mt-0 flex space-x-3">
        <a href="{{ route('projects.index') }}" class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
            <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to List
        </a>
        @hasrole(['admin', 'ngo'])
        <a href="{{ route('projects.edit', $project->id) }}" class="flex items-center px-4 py-2 bg-indigo-600 rounded-lg shadow-sm text-sm font-medium text-white hover:bg-indigo-700">
            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Project
        </a>
        @endhasrole
    </div>
</div>