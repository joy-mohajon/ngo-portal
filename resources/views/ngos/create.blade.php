<x-app-layout>
    <div class="container mx-auto max-w-2xl py-10">
        <div class="bg-white shadow-xl rounded-lg p-8 border border-gray-200 premium-form">
            <h2 class="text-3xl font-bold text-center text-indigo-700 mb-6">Create New NGO</h2>
            <form class="space-y-6">
                <div class="flex flex-col items-center mb-4">
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">NGO Logo</label>
                    <input type="file" id="logo" name="logo"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">NGO Name</label>
                    <input type="text" id="name" name="name"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Enter NGO name" value="{{ old('name', $userName ?? '') }}" />
                </div>
                <!-- <div>
                    <label for="registration_id" class="block text-sm font-medium text-gray-700">Registration ID</label>
                    <input type="text" id="registration_id" name="registration_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Registration number" />
                </div> -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Contact email" value="{{ old('email', $userEmail ?? '') }}" />
                </div>
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                    <input type="url" id="website" name="website"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="https://example.org" />
                </div>
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" id="location" name="location"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="City, Country" />
                </div>
                <div>
                    <label for="focus_area" class="block text-sm font-medium text-gray-700">Focus Area</label>
                    <input type="text" id="focus_area" name="focus_area"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="e.g. Education, Health" />
                </div>
                <div>
                    <label for="focus_activity" class="block text-sm font-medium text-gray-700">Focus Activity</label>
                    <textarea id="focus_activity" name="focus_activity" rows="2"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Describe main activities"></textarea>
                </div>
                <div>
                    <label for="certificate_path" class="block text-sm font-medium text-gray-700">Registration
                        Certificate</label>
                    <input type="file" id="certificate_path" name="certificate_path"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                </div>
                <div>
                    <label for="established_year" class="block text-sm font-medium text-gray-700">Established
                        Year</label>
                    <input type="text" id="established_year" name="established_year"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="YYYY" />
                </div>
                <!-- <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div> -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="3"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Brief description of the NGO"></textarea>
                </div>
                <div class="pt-4">
                    <button type="button"
                        class="w-full py-3 px-6 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold text-lg shadow-lg hover:from-indigo-700 hover:to-purple-700 transition">Create
                        NGO</button>
                </div>
            </form>
        </div>
    </div>
    <style>
    .premium-form {
        background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
        border-radius: 1.25rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        border: 1px solid #e0e7ff;
    }
    </style>
</x-app-layout>