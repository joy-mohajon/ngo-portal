<x-app-layout>
    <div class="bg-white rounded-lg shadow overflow-hidden max-w-4xl mx-auto">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800">Add New Student</h2>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mx-6 mt-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-6 mt-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        @if(isset($selectedProjectId) && $selectedProjectId)
            @php $project = \App\Models\Project::find($selectedProjectId); @endphp
            @can('manageAsRunner', $project)
                <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="px-6 py-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Personal Information</h3>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('name')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('email')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('phone')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                            <select name="gender" id="gender"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('date_of_birth')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                            <input type="file" name="photo" id="photo"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('photo')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="batch" class="block text-sm font-medium text-gray-700">Batch</label>
                            <input type="text" name="batch" id="batch" value="{{ old('batch') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('batch')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <!-- Identification -->
                        <div class="col-span-2 mt-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Identification</h3>
                        </div>

                        <div>
                            <label for="national_id" class="block text-sm font-medium text-gray-700">National ID</label>
                            <input type="text" name="national_id" id="national_id" value="{{ old('national_id') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('national_id')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="national_id_file" class="block text-sm font-medium text-gray-700">National ID
                                File</label>
                            <input type="file" name="national_id_file" id="national_id_file"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('national_id_file')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="birth_certificate_number" class="block text-sm font-medium text-gray-700">Birth
                                Certificate No.</label>
                            <input type="text" name="birth_certificate_number" id="birth_certificate_number" value="{{ old('birth_certificate_number') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('birth_certificate_number')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="birth_certificate_file" class="block text-sm font-medium text-gray-700">Birth
                                Certificate File</label>
                            <input type="file" name="birth_certificate_file" id="birth_certificate_file"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('birth_certificate_file')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <!-- Guardian Information -->
                        <div class="col-span-2 mt-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Guardian Information</h3>
                        </div>

                        <div>
                            <label for="guardian_name" class="block text-sm font-medium text-gray-700">Guardian Name</label>
                            <input type="text" name="guardian_name" id="guardian_name" value="{{ old('guardian_name') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('guardian_name')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="guardian_phone" class="block text-sm font-medium text-gray-700">Guardian Phone</label>
                            <input type="text" name="guardian_phone" id="guardian_phone" value="{{ old('guardian_phone') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('guardian_phone')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-span-2">
                            <label for="guardian_address" class="block text-sm font-medium text-gray-700">Guardian
                                Address</label>
                            <textarea name="guardian_address" id="guardian_address" rows="2"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('guardian_address') }}</textarea>
                            @error('guardian_address')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <!-- Education Information -->
                        <div class="col-span-2 mt-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Education Information</h3>
                        </div>

                        <div>
                            <label for="education_level" class="block text-sm font-medium text-gray-700">Education Level</label>
                            <input type="text" name="education_level" id="education_level" value="{{ old('education_level') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('education_level')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="education_institution"
                                class="block text-sm font-medium text-gray-700">Institution</label>
                            <input type="text" name="education_institution" id="education_institution" value="{{ old('education_institution') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('education_institution')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="enrollment_date" class="block text-sm font-medium text-gray-700">Enrollment Date</label>
                            <input type="date" name="enrollment_date" id="enrollment_date" value="{{ old('enrollment_date') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('enrollment_date')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                            <select name="status" id="status" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="graduated" {{ old('status') == 'graduated' ? 'selected' : '' }}>Graduated</option>
                                <option value="dropped" {{ old('status') == 'dropped' ? 'selected' : '' }}>Dropped</option>
                            </select>
                            @error('status')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
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
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                        @if(collect(old('projects', isset($selectedProjectId) ? [$selectedProjectId] : []))->contains($project->id)) checked @endif>
                                    <label for="project-{{ $project->id }}"
                                        class="ml-2 block text-sm text-gray-900">{{ $project->title }}</label>
                                </div>
                                @endforeach
                            </div>
                            @error('projects')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-span-2 mt-2">
                            <label for="project_enrollment_date" class="block text-sm font-medium text-gray-700">Project Enrollment Date</label>
                            <p class="text-xs text-gray-500 mb-1">This date will be used for all selected projects</p>
                            <input type="date" name="project_enrollment_date" id="project_enrollment_date"
                                value="{{ old('project_enrollment_date') ?? date('Y-m-d') }}"
                                class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('project_enrollment_date')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>

                        <!-- Notes -->
                        <div class="col-span-2 mt-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Additional Information</h3>
                        </div>

                        <div class="col-span-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
                            @error('notes')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('students.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md mr-3">Cancel</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Save
                            Student</button>
                    </div>
                </form>
            @endcan
        @else
            <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="px-6 py-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Personal Information</h3>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('name')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('email')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('phone')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                        <select name="gender" id="gender"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('date_of_birth')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                        <input type="file" name="photo" id="photo"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('photo')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="batch" class="block text-sm font-medium text-gray-700">Batch</label>
                        <input type="text" name="batch" id="batch" value="{{ old('batch') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('batch')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <!-- Identification -->
                    <div class="col-span-2 mt-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Identification</h3>
                    </div>

                    <div>
                        <label for="national_id" class="block text-sm font-medium text-gray-700">National ID</label>
                        <input type="text" name="national_id" id="national_id" value="{{ old('national_id') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('national_id')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="national_id_file" class="block text-sm font-medium text-gray-700">National ID
                            File</label>
                        <input type="file" name="national_id_file" id="national_id_file"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('national_id_file')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="birth_certificate_number" class="block text-sm font-medium text-gray-700">Birth
                            Certificate No.</label>
                        <input type="text" name="birth_certificate_number" id="birth_certificate_number" value="{{ old('birth_certificate_number') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('birth_certificate_number')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="birth_certificate_file" class="block text-sm font-medium text-gray-700">Birth
                            Certificate File</label>
                        <input type="file" name="birth_certificate_file" id="birth_certificate_file"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('birth_certificate_file')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <!-- Guardian Information -->
                    <div class="col-span-2 mt-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Guardian Information</h3>
                    </div>

                    <div>
                        <label for="guardian_name" class="block text-sm font-medium text-gray-700">Guardian Name</label>
                        <input type="text" name="guardian_name" id="guardian_name" value="{{ old('guardian_name') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('guardian_name')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="guardian_phone" class="block text-sm font-medium text-gray-700">Guardian Phone</label>
                        <input type="text" name="guardian_phone" id="guardian_phone" value="{{ old('guardian_phone') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('guardian_phone')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-span-2">
                        <label for="guardian_address" class="block text-sm font-medium text-gray-700">Guardian
                            Address</label>
                        <textarea name="guardian_address" id="guardian_address" rows="2"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('guardian_address') }}</textarea>
                        @error('guardian_address')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <!-- Education Information -->
                    <div class="col-span-2 mt-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Education Information</h3>
                    </div>

                    <div>
                        <label for="education_level" class="block text-sm font-medium text-gray-700">Education Level</label>
                        <input type="text" name="education_level" id="education_level" value="{{ old('education_level') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('education_level')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="education_institution"
                            class="block text-sm font-medium text-gray-700">Institution</label>
                        <input type="text" name="education_institution" id="education_institution" value="{{ old('education_institution') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('education_institution')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="enrollment_date" class="block text-sm font-medium text-gray-700">Enrollment Date</label>
                        <input type="date" name="enrollment_date" id="enrollment_date" value="{{ old('enrollment_date') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('enrollment_date')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                        <select name="status" id="status" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="graduated" {{ old('status') == 'graduated' ? 'selected' : '' }}>Graduated</option>
                            <option value="dropped" {{ old('status') == 'dropped' ? 'selected' : '' }}>Dropped</option>
                        </select>
                        @error('status')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
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
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    @if(collect(old('projects', isset($selectedProjectId) ? [$selectedProjectId] : []))->contains($project->id)) checked @endif>
                                <label for="project-{{ $project->id }}"
                                    class="ml-2 block text-sm text-gray-900">{{ $project->title }}</label>
                            </div>
                            @endforeach
                        </div>
                        @error('projects')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-span-2 mt-2">
                        <label for="project_enrollment_date" class="block text-sm font-medium text-gray-700">Project Enrollment Date</label>
                        <p class="text-xs text-gray-500 mb-1">This date will be used for all selected projects</p>
                        <input type="date" name="project_enrollment_date" id="project_enrollment_date"
                            value="{{ old('project_enrollment_date') ?? date('Y-m-d') }}"
                            class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('project_enrollment_date')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>

                    <!-- Notes -->
                    <div class="col-span-2 mt-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Additional Information</h3>
                    </div>

                    <div class="col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" id="notes" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
                        @error('notes')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('students.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md mr-3">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Save
                        Student</button>
                </div>
            </form>
        @endif
    </div>
</x-app-layout>