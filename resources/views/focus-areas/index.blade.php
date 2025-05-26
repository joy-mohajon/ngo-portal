<x-app-layout>
    <div class="container mx-auto max-w-4xl py-10">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-indigo-700">Focus Areas</h2>
            <a href="{{ route('focus-areas.create') }}"
                class="px-5 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition font-semibold">+
                Add Focus Area</a>
        </div>
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($focusAreas as $focusArea)
            <div class="bg-white shadow-lg rounded-xl p-6 border border-indigo-100 flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-indigo-800 mb-2">{{ $focusArea->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ $focusArea->description ?? 'No description' }}</p>
                </div>
                <div class="flex space-x-2 mt-4">
                    <a href="{{ route('focus-areas.edit', $focusArea) }}"
                        class="px-4 py-2 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transition">Edit</a>
                    <form action="{{ route('focus-areas.destroy', $focusArea) }}" method="POST"
                        onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Delete</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-2 text-center text-gray-500">No focus areas found.</div>
            @endforelse
        </div>
        <div class="mt-8">{{ $focusAreas->links() }}</div>
    </div>
</x-app-layout>