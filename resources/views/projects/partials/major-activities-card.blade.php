<div class="bg-gradient-to-br from-white via-gray-50 to-gray-100 shadow rounded-lg border border-gray-200">
    <div class="px-6 py-5 border-b border-gray-200 flex items-center space-x-3">
        <div class="bg-indigo-100 p-2 rounded-full">
            <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z" />
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 tracking-tight">Major Activities</h3>
    </div>
    <div class="px-6 py-5">
        @if(!empty($project->major_activities) && is_array($project->major_activities))
            <ul class="text-sm text-gray-700 space-y-4">
                @foreach($project->major_activities as $activity)
                <li class="flex items-start space-x-3">
                    <div class="mt-1">
                        <svg class="h-4 w-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L9 13.414l4.707-4.707z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span>{{ $activity }}</span>
                </li>
                @endforeach
            </ul>
        @else
            <div class="text-gray-500 italic">No major activities listed for this project.</div>
        @endif
    </div>
</div>