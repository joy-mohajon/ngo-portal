<x-app-layout>
    <div class="container mx-auto max-w-2xl py-10">
        <div class="bg-white shadow-xl rounded-lg p-8 border border-gray-200 premium-form">
            <h2 class="text-3xl font-bold text-center text-indigo-700 mb-6">Get Approval for your NGO</h2>
            
            @if(session('error'))
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                <p>{{ session('error') }}</p>
            </div>
            @endif
            
            <form method="POST" action="{{ route('ngos.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">NGO Name</label>
                    <input type="text" id="name" name="name"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Enter NGO name" value="{{ old('name', $userName ?? '') }}" required />
                    @error('name')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
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
                        placeholder="Contact email" value="{{ old('email', $userEmail ?? '') }}" required />
                    @error('email')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="border-radius-lg">
                    <div class="flex items-center justify-between mb-2">
                        <label for="focus_areas" class="block text-sm font-medium text-gray-700 mb-2">Focus
                            Areas</label>
                        <a href="{{ route('focus-areas.create', ['redirect_url' => route('ngos.create')]) }}"
                            class="px-4 py-2 text-white bg-indigo-600 rounded-lg shadow transition text-sm font-semibold">+
                            Add Focus Area</a>
                    </div>
                    <select id="focus_areas" name="focus_areas[]" multiple data-hs-select='{
                          "hasSearch": true,
                          "searchPlaceholder": "Search focus areas...",
                          "placeholder": "Select focus areas...",
                          "mode": "tags",
                          "wrapperClasses": "relative ps-0.5 pe-9 min-h-11.5 flex items-center flex-wrap w-full border border-indigo-200 rounded-xl text-start text-sm focus:border-indigo-500 focus:ring-indigo-500",
                          "tagsItemTemplate": "<div class=\"flex flex-nowrap items-center text-nowrap relative z-10 bg-white border border-indigo-200 rounded-full p-1 m-1\"><div class=\"whitespace-nowrap text-indigo-800 font-semibold\" data-title></div><div class=\"inline-flex shrink-0 justify-center items-center size-5 ms-2 rounded-full text-indigo-800 bg-indigo-200 hover:bg-indigo-300 focus:outline-hidden focus:ring-2 focus:ring-indigo-400 text-sm cursor-pointer\" data-remove><svg class=\"shrink-0 size-3\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M18 6 6 18\"/><path d=\"m6 6 12 12\"/></svg></div></div>",
                          "tagsInputClasses": "py-3 px-2 rounded-lg order-1 border-transparent focus:ring-0 text-sm outline-hidden",
                          "dropdownClasses": "mt-2 z-50 w-full max-h-72 pb-1 px-1 space-y-0.5 bg-white border border-indigo-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-indigo-100 [&::-webkit-scrollbar-thumb]:bg-indigo-300",
                          "optionClasses": "py-2 px-4 w-full text-sm text-indigo-800 cursor-pointer hover:bg-indigo-100 rounded-lg focus:outline-hidden focus:bg-indigo-100",
                          "optionTemplate": "<div class=\"flex items-center\"><div><div class=\"text-sm font-semibold text-indigo-800\" data-title></div></div><div class=\"ms-auto\"><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-4 text-indigo-600\" xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" viewBox=\"0 0 16 16\"><path d=\"M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/></svg></span></div></div>",
                          "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-indigo-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                        }' class="">
                        @foreach($focusAreas as $focusArea)
                        <option value="{{ $focusArea->id }}">{{ $focusArea->name }}</option>
                        @endforeach
                    </select>
                    @error('focus_areas')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex flex-row items-center justify-between mb-4 gap-4">
                    <div class="w-1/2 flex flex-col items-start">
                        <label for="short_name" class="block text-sm font-medium text-gray-700">Short Name</label>
                        <input type="text" id="short_name" name="short_name"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Enter short name" required value="{{ old('short_name') }}" />
                        @error('short_name')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-1/2 flex flex-col items-start">
                        <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">NGO Logo <span class="text-red-500">*</span></label>
                        <input type="file" id="logo" name="logo"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                        <p class="text-xs text-gray-500 mt-1">Accepted formats: JPEG, PNG, JPG, GIF (Max: 2MB, Min dimensions: 100x100px)</p>
                        @error('logo')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                    <input type="url" id="website" name="website"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="https://example.org" value="{{ old('website') }}" />
                    @error('website')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" id="location" name="location"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="City, Country" value="{{ old('location') }}" required />
                    @error('location')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- <div>
                    <label for="focus_area" class="block text-sm font-medium text-gray-700">Focus Area</label>
                    <input type="text" id="focus_area" name="focus_area"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="e.g. Education, Health" />
                </div> -->
                <!-- Focus Activity Dynamic Input -->
                <div id="focus-activities-section" class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Focus Activities</label>
                    <div id="focus-activities-list">
                        <div class="flex items-center mb-2 activity-field">
                            <input type="text" name="focus_activities[]"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Enter activity" />
                            <button type="button"
                                class="ml-2 px-2 py-1 rounded-full bg-indigo-600 text-white flex items-center justify-center add-activity-btn"
                                title="Add Activities">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @error('focus_activities')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="certificate_path" class="block text-sm font-medium text-gray-700">Registration
                        Certificate <span class="text-red-500">*</span></label>
                    <input type="file" id="certificate_path" name="certificate_path"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                    <p class="text-xs text-gray-500 mt-1">Accepted formats: PDF, JPEG, JPG, PNG (Max: 4MB)</p>
                    @error('certificate_path')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="established_year" class="block text-sm font-medium text-gray-700">Established
                        Year</label>
                    <input type="text" id="established_year" name="established_year"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="YYYY" value="{{ old('established_year') }}" required />
                    @error('established_year')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
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
                        placeholder="Brief description of the NGO">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="pt-4">
                    <button type="submit"
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

    .premium-multiselect {
        background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
        border: 1.5px solid #a5b4fc;
        min-height: 3.2rem;
        box-shadow: 0 2px 8px 0 rgba(99, 102, 241, 0.08);
        transition: border 0.2s, box-shadow 0.2s;
    }

    .premium-multiselect:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 2px #6366f1;
    }
    </style>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const element = document.getElementById('focus_areas');
        let choicesInstance = null;
        if (element) {
            choicesInstance = new Choices(element, {
                removeItemButton: true,
                placeholder: true,
                placeholderValue: 'Select focus areas...',
                searchPlaceholderValue: 'Search focus areas...',
                shouldSort: false,
            });
        }
        // Dynamic Focus Activities
        const activitiesList = document.getElementById('focus-activities-list');
        activitiesList.addEventListener('click', function(e) {
            if (e.target.closest('.add-activity-btn')) {
                e.preventDefault();
                const newField = document.createElement('div');
                newField.className = 'flex items-center mb-2 activity-field';
                newField.innerHTML = `
                    <input type="text" name="focus_activities[]" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter activity" />
                    <button type="button" class="ml-2 px-2 py-1 rounded-full bg-red-500 text-white flex items-center justify-center remove-activity-btn" title="Remove Activity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                `;
                activitiesList.appendChild(newField);
            } else if (e.target.closest('.remove-activity-btn')) {
                e.preventDefault();
                e.target.closest('.activity-field').remove();
            }
        });
    });
    </script>
</x-app-layout>