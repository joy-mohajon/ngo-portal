<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Project</h2>
        <form method="POST" action="{{ route('projects.update', $project->id) }}"
            class="bg-white shadow rounded-lg p-8 space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title <span
                        class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('title')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $project->description) }}</textarea>
                @error('description')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $project->location) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('location')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="budget" class="block text-sm font-medium text-gray-700">Budget</label>
                    <input type="number" name="budget" id="budget" value="{{ old('budget', $project->budget) }}"
                        step="0.01" min="0"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('budget')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
            </div>
            <div id="major-activities-section" class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Major Activities</label>
                <div id="major-activities-list">
                    @php
                    $activities = old('major_activities', is_array($project->major_activities) ?
                    $project->major_activities : (empty($project->major_activities) ? [] : explode(',',
                    $project->major_activities)));
                    @endphp
                    @if(count($activities))
                    @foreach($activities as $activity)
                    <div class="flex items-center mb-2 major-activity-field">
                        <input type="text" name="major_activities[]" value="{{ $activity }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Enter activity" />
                        <button type="button"
                            class="ml-2 px-2 py-1 rounded-full bg-red-600 text-white flex items-center justify-center remove-major-activity-btn cursor-pointer"
                            title="Remove Activity">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </button>
                    </div>
                    @endforeach
                    @else
                    <div class="flex items-center mb-2 major-activity-field">
                        <input type="text" name="major_activities[]"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Enter activity" />
                        <button type="button"
                            class="ml-2 px-2 py-1 rounded-full bg-indigo-600 text-white flex items-center justify-center add-major-activity-btn cursor-pointer"
                            title="Add Activity">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                    @endif
                </div>
                @error('major_activities')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const list = document.getElementById('major-activities-list');
                list.addEventListener('click', function(e) {
                    if (e.target.closest('.add-major-activity-btn')) {
                        e.preventDefault();
                        const field = document.createElement('div');
                        field.className = 'flex items-center mb-2 major-activity-field';
                        field.innerHTML = `<input type=\"text\" name=\"major_activities[]\" class=\"mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500\" placeholder=\"Enter activity\" />
                            <button type=\"button\" class=\"ml-2 px-2 py-1 rounded-full bg-red-600 text-white flex items-center justify-center remove-major-activity-btn cursor-pointer\" title=\"Remove Activity\">
                                <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-5 w-5\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M20 12H4\" /></svg>
                            </button>`;
                        list.appendChild(field);
                    } else if (e.target.closest('.remove-major-activity-btn')) {
                        e.preventDefault();
                        e.target.closest('.major-activity-field').remove();
                    }
                });
            });
            </script>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="focus_area" class="block text-sm font-medium text-gray-700">Focus Area <span
                            class="text-red-500">*</span></label>
                    <select name="focus_area" id="focus_area" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select Focus Area</option>
                        @foreach($focusAreas as $focusArea)
                        <option value="{{ $focusArea->id }}" 
                            {{ (int)$project->focus_area === (int)$focusArea->id ? 'selected' : '' }}>
                            {{ $focusArea->name }}</option>
                        @endforeach
                    </select>
                    @error('focus_area')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="holder_id" class="block text-sm font-medium text-gray-700">Holder NGO <span
                            class="text-red-500">*</span></label>
                    <select name="holder_id" id="holder_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select NGO</option>
                        @foreach(App\Models\Ngo::all() as $ngo)
                        <option value="{{ $ngo->id }}"
                            {{ (int)$project->holder_id === (int)$ngo->id ? 'selected' : '' }}>{{ $ngo->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('holder_id')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="runner_id" class="block text-sm font-medium text-gray-700">Runner NGO <span
                            class="text-red-500">*</span></label>
                    <select name="runner_id" id="runner_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select NGO</option>
                        @foreach(App\Models\Ngo::all() as $ngo)
                        <option value="{{ $ngo->id }}"
                            {{ (int)$project->runner_id === (int)$ngo->id ? 'selected' : '' }}>{{ $ngo->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('runner_id')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="start_date" id="start_date"
                        value="{{ $project->start_date ? $project->start_date->format('Y-m-d') : '' }}"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('start_date')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="end_date" id="end_date"
                        value="{{ $project->end_date ? $project->end_date->format('Y-m-d') : '' }}"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('end_date')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status <span
                            class="text-red-500">*</span></label>
                    <select name="status" id="status" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="pending" {{ strtolower($project->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ strtolower($project->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ strtolower($project->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="suspended" {{ strtolower($project->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                    @error('status')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center px-6 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update
                    Project</button>
            </div>
        </form>
    </div>
</x-app-layout>