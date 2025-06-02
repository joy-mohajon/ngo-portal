<x-app-layout>
    <?php
// phpinfo();
?>
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Dashboard Overview</h1>
        
        @role('ngo')
            @if(Auth::user()->ngo)
                <!-- NGO User Dashboard -->
                <div class="mb-6">
                    <div class="bg-indigo-50 p-6 rounded-lg border border-indigo-100">
                        <div class="flex items-center mb-4">
                            @if(Auth::user()->ngo->logo)
                                <img src="{{ asset('storage/' . Auth::user()->ngo->logo) }}" 
                                     alt="{{ Auth::user()->ngo->name }} Logo" 
                                     class="h-16 w-16 object-contain rounded-full border border-indigo-200 bg-white p-1 mr-4">
                            @else
                                <div class="h-16 w-16 bg-indigo-200 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-indigo-800 font-bold text-xl">{{ substr(Auth::user()->ngo->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <h2 class="text-xl font-bold text-indigo-900">{{ Auth::user()->ngo->name }}</h2>
                                <p class="text-indigo-700">{{ Auth::user()->ngo->approval_status }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                            <a href="{{ route('projects.runner') }}" class="bg-white p-4 rounded-lg border border-indigo-200 flex items-center hover:shadow-md transition-all">
                                <div class="bg-indigo-100 p-3 rounded-full mr-3">
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-indigo-900">My Runner Projects</h3>
                                    <p class="text-sm text-indigo-700">Projects you can manage and edit</p>
                                </div>
                            </a>
                            
                            <a href="{{ route('projects.holder') }}" class="bg-white p-4 rounded-lg border border-indigo-200 flex items-center hover:shadow-md transition-all">
                                <div class="bg-indigo-100 p-3 rounded-full mr-3">
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-indigo-900">My Holder Projects</h3>
                                    <p class="text-sm text-indigo-700">Projects you can monitor (view-only)</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <!-- Admin Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Stats Cards -->
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <h3 class="text-blue-800 font-medium">Pending Approvals</h3>
                    <p class="text-3xl font-bold text-blue-600">5</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                    <h3 class="text-green-800 font-medium">Approved NGOs</h3>
                    <p class="text-3xl font-bold text-green-600">24</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
                    <h3 class="text-purple-800 font-medium">Active Projects</h3>
                    <p class="text-3xl font-bold text-purple-600">12</p>
                </div>
            </div>
        @endrole

        <!-- Recent Activity Section -->
        <div class="border rounded-lg p-4">
            <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                        <i class="fas fa-check-circle text-blue-500"></i>
                    </div>
                    <div>
                        <p class="font-medium">New NGO "Green Earth" approved</p>
                        <p class="text-sm text-gray-500">2 hours ago</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-yellow-100 p-2 rounded-full mr-3">
                        <i class="fas fa-exclamation-circle text-yellow-500"></i>
                    </div>
                    <div>
                        <p class="font-medium">3 new applications pending review</p>
                        <p class="text-sm text-gray-500">5 hours ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>




</x-app-layout>