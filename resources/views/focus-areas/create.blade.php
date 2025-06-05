<x-app-layout>
    <div class="container mx-auto max-w-lg py-10">
        <div class="bg-white shadow-xl rounded-lg p-8 border border-indigo-200 premium-form">
            <h2 class="text-2xl font-bold text-indigo-700 mb-6">Add New Focus Area</h2>
            <form method="POST" action="{{ route('focus-areas.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="redirect_url" value="{{ $redirectUrl ?? route('focus-areas.index') }}">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required />
                    @error('name')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                    <select id="type" name="type" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="Project" {{ old('type', 'Project') == 'Project' ? 'selected' : '' }}>Project</option>
                        <option value="NGO" {{ old('type') == 'NGO' ? 'selected' : '' }}>NGO</option>
                    </select>
                    @error('type')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="3"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex justify-between items-center pt-4">
                    <a href="{{ route('focus-areas.index') }}" class="text-indigo-600 hover:underline">&larr; Back to
                        list</a>
                    <button type="submit"
                        class="py-2 px-6 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold text-lg shadow-lg hover:from-indigo-700 hover:to-purple-700 transition">Create</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>