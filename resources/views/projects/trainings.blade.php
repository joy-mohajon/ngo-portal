<x-app-layout>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold">Trainings for {{ $project->title }}</h1>
                <p class="text-gray-600">Project status:
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $project->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $project->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $project->status === 'completed' ? 'bg-gray-100 text-gray-800' : '' }}
                        {{ $project->status === 'suspended' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($project->status) }}
                    </span>
                </p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('projects.show', $project) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    View Project Details
                </a>
                <a href="{{ route('trainings.create', ['project_id' => $project->id]) }}"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Add New Training
                </a>
            </div>
        </div>

        <!-- Project Information Summary -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <span class="text-gray-500 block">Project Holder</span>
                    <span class="font-medium">{{ $project->holder->name ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="text-gray-500 block">Project Runner</span>
                    <span class="font-medium">{{ $project->runner->name ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="text-gray-500 block">Duration</span>
                    <span class="font-medium">{{ $project->start_date->format('M d, Y') }} -
                        {{ $project->end_date->format('M d, Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Trainings Table -->
        <div class="overflow-x-auto max-h-[calc(100vh-400px)] overflow-y-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start
                            Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($trainings as $training)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $training->title }}</div>
                            <div class="text-xs text-gray-500">Organizer: {{ $training->organizer->name ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $training->location }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $training->start_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $training->category }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $training->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $training->status === 'ongoing' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $training->status === 'completed' ? 'bg-gray-100 text-gray-800' : '' }}
                                {{ $training->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($training->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('trainings.show', $training->id) }}"
                                    class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @hasrole(['admin', 'ngo'])
                                <a href="{{ route('trainings.edit', $training->id) }}"
                                    class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('trainings.destroy', $training->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                @endhasrole
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No trainings found for this project.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-6">
            <div class="text-sm text-gray-500">
                Showing <span class="font-medium">{{ $trainings->firstItem() ?: 0 }}</span> to
                <span class="font-medium">{{ $trainings->lastItem() ?: 0 }}</span> of
                <span class="font-medium">{{ $trainings->total() }}</span> trainings
            </div>
            <div class="mt-2">
                {{ $trainings->links() }}
            </div>
        </div>
    </div>
</x-app-layout>