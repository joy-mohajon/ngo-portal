<x-app-layout>
    <div class="bg-white rounded-lg shadow overflow-hidden max-w-4xl mx-auto">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800">Add New Student</h2>
        </div>

        <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="px-6 py-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div class="col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Personal Information</h3>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                    <input type="text" name="name" id="name" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select name="gender" id="gender"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                    <input type="file" name="photo" id="photo"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <!-- Identification -->
                <div class="col-span-2 mt-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Identification</h3>
                </div>

                <div>
                    <label for="national_id" class="block text-sm font-medium text-gray-700">National ID</label>
                    <input type="text" name="national_id" id="national_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="national_id_file" class="block text-sm font-medium text-gray-700">National ID
                        File</label>
                    <input type="file" name="national_id_file" id="national_id_file"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div>
                    <label for="birth_certificate_number" class="block text-sm font-medium text-gray-700">Birth
                        Certificate No.</label>
                    <input type="text" name="birth_certificate_number" id="birth_certificate_number"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="birth_certificate_file" class="block text-sm font-medium text-gray-700">Birth
                        Certificate File</label>
                    <input type="file" name="birth_certificate_file" id="birth_certificate_file"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <!-- Guardian Information -->
                <div class="col-span-2 mt-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Guardian Information</h3>
                </div>

                <div>
                    <label for="guardian_name" class="block text-sm font-medium text-gray-700">Guardian Name</label>
                    <input type="text" name="guardian_name" id="guardian_name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="guardian_phone" class="block text-sm font-medium text-gray-700">Guardian Phone</label>
                    <input type="text" name="guardian_phone" id="guardian_phone"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="col-span-2">
                    <label for="guardian_address" class="block text-sm font-medium text-gray-700">Guardian
                        Address</label>
                    <textarea name="guardian_address" id="guardian_address" rows="2"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>

                <!-- Education Information -->
                <div class="col-span-2 mt-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Education Information</h3>
                </div>

                <div>
                    <label for="education_level" class="block text-sm font-medium text-gray-700">Education Level</label>
                    <input type="text" name="education_level" id="education_level"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="education_institution"
                        class="block text-sm font-medium text-gray-700">Institution</label>
                    <input type="text" name="education_institution" id="education_institution"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="enrollment_date" class="block text-sm font-medium text-gray-700">Enrollment Date</label>
                    <input type="date" name="enrollment_date" id="enrollment_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                    <select name="status" id="status" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="graduated">Graduated</option>
                        <option value="dropped">Dropped</option>
                    </select>
                </div>

                <!-- Project Assignment -->
                <div class="col-span-2 mt-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Project Assignment</h3>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Assign to Projects</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($projects as $project)
                        <div class="flex items-center">
                            <input type="checkbox" name="projects[]" id="project-{{ $project->id }}"
                                value="{{ $project->id }}"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="project-{{ $project->id }}"
                                class="ml-2 block text-sm text-gray-900">{{ $project->title }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Notes -->
                <div class="col-span-2 mt-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Additional Information</h3>
                </div>

                <div class="col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('students.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md mr-3">Cancel</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Save
                    Student</button>
            </div>
        </form>
    </div>
</x-app-layout>