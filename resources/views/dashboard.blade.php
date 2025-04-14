<x-app-layout>
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Dashboard Overview</h1>
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