<x-app-layout>
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto my-12">
        <div class="text-center mb-8">
            <div class="bg-red-100 inline-flex p-4 rounded-full mb-4">
                <svg class="h-12 w-12 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Access Denied</h1>
            <p class="text-gray-600 mb-6">You don't have permission to access this page.</p>
            
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 text-left">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            @if(Auth::check() && Auth::user()->hasRole('ngo') && !Auth::user()->ngo)
                                You need to register your NGO before accessing this feature.
                            @elseif(Auth::check() && Auth::user()->hasRole('ngo') && Auth::user()->ngo && Auth::user()->ngo->status !== 'approved')
                                Your NGO registration is pending approval. You'll have access once it's approved.
                            @else
                                You don't have the required permissions to access this resource.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Return to Dashboard
                </a>
                
                @if(Auth::check() && Auth::user()->hasRole('ngo') && !Auth::user()->ngo)
                <a href="{{ route('ngos.create') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-indigo-100 hover:bg-indigo-200">
                    Register Your NGO
                </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 