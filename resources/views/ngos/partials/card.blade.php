<a href="{{ route('ngos.show', $ngo) }}"
    class="flex items-center rounded-lg p-4 w-[280px] bg-gradient-to-tl from-white to-transparent-300 border border-gray-200 hover:shadow-md transition-all group shadow">
    <div
        class="w-16 h-16 rounded-lg flex items-center justify-center overflow-hidden mr-4 flex-shrink-0 bg-gradient-to-tr from-blue-100 to-blue-50 group-hover:from-blue-200 group-hover:to-blue-100 transition-all">
        @if($ngo->logo)
        <img src="{{ asset('storage/' . $ngo->logo) }}" alt="{{ $ngo->name }} logo"
            class="w-full h-full object-contain p-2">
        @else
        <span
            class="{{ str_replace('bg-', 'text-', str_replace('-200', '-600', $logoBgClass)) }} text-lg uppercase font-medium">{{ substr($ngo->name, 0, 2) }}</span>
        @endif
    </div>
    <div class="min-w-0">
        <h3 class="font-semibold text-xl text-gray-900 truncate group-hover:text-gray-900 transition-colors">
            {{ $ngo->name }}</h3>
        <p class="text-sm text-green-600 mt-1 truncate group-hover:text-green-600 transition-colors">
            {{ $ngo->location ?? 'Global' }}</p>
    </div>
</a>