<x-app-layout>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Pending NGOs</h2>

        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            NGO Details
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Focus Areas
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($ngos as $ngo)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($ngo->logo)
                                <div class="flex-shrink-0 h-12 w-12 rounded-full overflow-hidden bg-gray-200">
                                    <img class="h-full w-full object-cover" src="{{ asset('storage/'.$ngo->logo) }}"
                                        alt="{{ $ngo->name }} logo">
                                </div>
                                @else
                                <div
                                    class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <span
                                        class="text-indigo-600 font-medium">{{ strtoupper(substr($ngo->name, 0, 2)) }}</span>
                                </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $ngo->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $ngo->registration_id }}</div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        Registered by {{ $ngo->user->name }} on {{ $ngo->created_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $ngo->email }}</div>
                            <div class="text-sm text-gray-500">{{ $ngo->website ?? 'No website' }}</div>
                            <div class="text-sm text-gray-500">{{ $ngo->location }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($ngo->focusAreas as $focusArea)
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                    {{ $focusArea->name }}
                                </span>
                                @endforeach
                            </div>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-4">
                                <a href="{{ route('ngos.show', $ngo) }}" class="text-indigo-600 hover:text-indigo-900">
                                    View
                                </a>
                                <form action="{{ route('ngos.approve', $ngo) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900">
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('ngos.reject', $ngo) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                            No pending NGO applications found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $ngos->links() }}
        </div>
    </div>
</x-app-layout>