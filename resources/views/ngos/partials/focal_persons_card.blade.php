@php
$crudEnabled = $crudEnabled ?? false;
@endphp
<div class="bg-white rounded-lg shadow p-0 mt-6 mb-6 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-900 flex items-center">
            <i class="fas fa-address-book text-indigo-500 mr-2 text-xl"></i>
            Focal Persons
        </h3>
        @if($crudEnabled)
        @auth
        <button @click="openFocalPersonModal('add')"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition"
            type="button">
            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add
        </button>
        @endauth
        @endif
    </div>
    <div class="px-6 py-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse($ngo->focalPersons as $person)
            <div
                class="relative group bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl overflow-hidden border border-gray-100 p-6 flex flex-col transition-transform hover:scale-105 hover:shadow-lg">
                <div class="flex items-center mb-4">
                    <div
                        class="flex-shrink-0 h-14 w-14 rounded-full bg-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-2xl shadow-inner border-2 border-white">
                        <i class="fas fa-user-alt"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-lg font-semibold text-gray-900">{{ $person->name }}</p>
                        <p class="text-xs text-indigo-600 font-medium">{{ $person->designation }}</p>
                    </div>
                </div>
                <div class="flex-1 mb-2">
                    <p class="text-sm text-gray-700 flex items-center mb-1"><i
                            class="fas fa-envelope mr-2 text-indigo-400"></i> <span
                            class="truncate">{{ $person->email }}</span></p>
                    <p class="text-sm text-gray-700 flex items-center"><i class="fas fa-phone mr-2 text-indigo-400"></i>
                        <span class="truncate">{{ $person->mobile }}</span>
                    </p>
                </div>
                @if($crudEnabled)
                @auth
                @if(auth()->user()->is_ngo)
                <div class="mt-4 flex space-x-2">
                    <button @click="openFocalPersonModal('edit', {{ $person->id }})"
                        class="text-indigo-600 hover:text-indigo-900 text-xs font-semibold">Edit</button>
                    <button @click="openFocalPersonModal('delete', {{ $person->id }})"
                        class="text-red-600 hover:text-red-900 text-xs font-semibold">Delete</button>
                </div>
                @endif
                @endauth
                @endif
            </div>
            @empty
            <div class="col-span-full text-center text-gray-400 py-8">
                <i class="fas fa-user-friends text-3xl mb-2"></i>
                <div>No focal persons found for this NGO.</div>
            </div>
            @endforelse
        </div>
    </div>
    <!-- Modals will be injected here by parent view -->
    @if($crudEnabled)
    <!-- Add Focal Person Modal -->
    <x-modal name="add-focal-person" id="addFocalPersonModal" x-show="showAddModal" @close="showAddModal = false">
        <form id="addFocalPersonForm" class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Add Focal Person</h2>
            <div>
                <x-input-label for="name" value="Name" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                <x-input-error for="name" />
            </div>
            <div>
                <x-input-label for="designation" value="Designation" />
                <x-text-input id="designation" name="designation" type="text" class="mt-1 block w-full" required />
                <x-input-error for="designation" />
            </div>
            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                <x-input-error for="email" />
            </div>
            <div>
                <x-input-label for="mobile" value="Mobile" />
                <x-text-input id="mobile" name="mobile" type="text" class="mt-1 block w-full" required />
                <x-input-error for="mobile" />
            </div>
            <div class="flex justify-end space-x-2 mt-4">
                <x-secondary-button type="button" @click="showAddModal = false">Cancel</x-secondary-button>
                <x-primary-button type="submit">Add</x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Edit Focal Person Modal -->
    <x-modal name="edit-focal-person" id="editFocalPersonModal" x-show="showEditModal" @close="showEditModal = false">
        <form id="editFocalPersonForm" class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Edit Focal Person</h2>
            <input type="hidden" id="edit_id" name="id" />
            <div>
                <x-input-label for="edit_name" value="Name" />
                <x-text-input id="edit_name" name="name" type="text" class="mt-1 block w-full" required />
                <x-input-error for="edit_name" />
            </div>
            <div>
                <x-input-label for="edit_designation" value="Designation" />
                <x-text-input id="edit_designation" name="designation" type="text" class="mt-1 block w-full" required />
                <x-input-error for="edit_designation" />
            </div>
            <div>
                <x-input-label for="edit_email" value="Email" />
                <x-text-input id="edit_email" name="email" type="email" class="mt-1 block w-full" required />
                <x-input-error for="edit_email" />
            </div>
            <div>
                <x-input-label for="edit_mobile" value="Mobile" />
                <x-text-input id="edit_mobile" name="mobile" type="text" class="mt-1 block w-full" required />
                <x-input-error for="edit_mobile" />
            </div>
            <div class="flex justify-end space-x-2 mt-4">
                <x-secondary-button type="button" @click="showEditModal = false">Cancel</x-secondary-button>
                <x-primary-button type="submit">Update</x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal name="delete-focal-person" id="deleteFocalPersonModal" x-show="showDeleteModal"
        @close="showDeleteModal = false">
        <form id="deleteFocalPersonForm">
            <input type="hidden" id="delete_id" name="id" />
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Delete Focal Person</h2>
            <p class="mb-6">Are you sure you want to delete this focal person? This action can be undone from the admin
                panel.</p>
            <div class="flex justify-end space-x-2">
                <x-secondary-button type="button" @click="showDeleteModal = false">Cancel</x-secondary-button>
                <x-danger-button type="submit">Delete</x-danger-button>
            </div>
        </form>
    </x-modal>
    @endif
</div>