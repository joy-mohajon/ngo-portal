@php
$crudEnabled = $crudEnabled ?? false;
@endphp

<div class="bg-white rounded-lg shadow p-0 mt-6 mb-6 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-900 flex items-center">
            <i class="fas fa-address-book text-indigo-500 mr-2 text-xl"></i>
            Focal Persons
        </h3>
        @auth
        @hasrole('ngo')
        <button type="button" onclick="document.getElementById('addFocalPersonModal').style.display='flex'"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition">
            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add
        </button>
        @endhasrole
        @endauth
    </div>
    <div class="px-6 py-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                @auth
                @hasrole('ngo')
                <div class="mt-4 flex space-x-2">
                    <button type="button" class="edit-focal-person-btn" data-id="{{ $person->id }}"
                        data-name="{{ htmlspecialchars($person->name, ENT_QUOTES) }}"
                        data-designation="{{ htmlspecialchars($person->designation, ENT_QUOTES) }}"
                        data-email="{{ htmlspecialchars($person->email, ENT_QUOTES) }}"
                        data-mobile="{{ htmlspecialchars($person->mobile, ENT_QUOTES) }}">
                        Edit
                    </button>
                    <button type="button" onclick="openDeleteFocalPersonModal(`{{ $person->id }}`)"
                        class="text-red-600 hover:text-red-900 text-xs font-semibold">Delete</button>
                </div>
                @endhasrole
                @endauth
            </div>
            @empty
            <div class="col-span-full text-center text-gray-400 py-8">
                <i class="fas fa-user-friends text-3xl mb-2"></i>
                <div>No focal persons found for this NGO.</div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addFocalPersonModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 @if($errors->has('name') || $errors->has('designation') || $errors->has('email') || $errors->has('mobile')) flex @else hidden @endif">
        <div class="bg-white rounded-xl shadow-xl border border-indigo-100 w-full max-w-lg p-8 relative">
            <form method="POST" action="{{ route('ngos.focal-persons.store', $ngo->id) }}" class="space-y-6">
                @csrf
                <h2 class="text-2xl font-bold text-indigo-700 mb-4">Add Focal Person</h2>
                <div>
                    <x-input-label for="add_name" value="Name" />
                    <x-text-input id="add_name" name="name" type="text" class="mt-1 block w-full" required
                        value="{{ old('name') }}" />
                    <x-input-error :messages="$errors->get('name')" />
                </div>
                <div>
                    <x-input-label for="add_designation" value="Designation" />
                    <x-text-input id="add_designation" name="designation" type="text" class="mt-1 block w-full" required
                        value="{{ old('designation') }}" />
                    <x-input-error :messages="$errors->get('designation')" />
                </div>
                <div>
                    <x-input-label for="add_email" value="Email" />
                    <x-text-input id="add_email" name="email" type="email" class="mt-1 block w-full" required
                        value="{{ old('email') }}" />
                    <x-input-error :messages="$errors->get('email')" />
                </div>
                <div>
                    <x-input-label for="add_mobile" value="Mobile" />
                    <x-text-input id="add_mobile" name="mobile" type="text" class="mt-1 block w-full" required
                        value="{{ old('mobile') }}" />
                    <x-input-error :messages="$errors->get('mobile')" />
                </div>
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" onclick="closeModal('addFocalPersonModal')"
                        class="px-4 py-2 rounded bg-gray-200 text-gray-700">Cancel</button>
                    <x-primary-button type="submit">Add</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editFocalPersonModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-xl shadow-xl border border-indigo-100 w-full max-w-lg p-8 relative">
            <form method="POST" id="editFocalPersonForm" class="space-y-6">
                @csrf
                @method('PUT')
                <h2 class="text-2xl font-bold text-indigo-700 mb-4">Edit Focal Person</h2>
                <input type="hidden" id="edit_id" name="id" />
                <div>
                    <x-input-label for="edit_name" value="Name" />
                    <x-text-input id="edit_name" name="name" type="text" class="mt-1 block w-full" required />
                    <x-input-error for="name" />
                </div>
                <div>
                    <x-input-label for="edit_designation" value="Designation" />
                    <x-text-input id="edit_designation" name="designation" type="text" class="mt-1 block w-full"
                        required />
                    <x-input-error for="designation" />
                </div>
                <div>
                    <x-input-label for="edit_email" value="Email" />
                    <x-text-input id="edit_email" name="email" type="email" class="mt-1 block w-full" required />
                    <x-input-error for="email" />
                </div>
                <div>
                    <x-input-label for="edit_mobile" value="Mobile" />
                    <x-text-input id="edit_mobile" name="mobile" type="text" class="mt-1 block w-full" required />
                    <x-input-error for="mobile" />
                </div>
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" onclick="closeModal('editFocalPersonModal')"
                        class="px-4 py-2 rounded bg-gray-200 text-gray-700">Cancel</button>
                    <x-primary-button type="submit">Update</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteFocalPersonModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-xl shadow-xl border border-red-100 w-full max-w-lg p-8 relative">
            <form method="POST" id="deleteFocalPersonForm">
                @csrf
                @method('DELETE')
                <input type="hidden" id="delete_id" name="id" />
                <h2 class="text-2xl font-bold text-red-700 mb-4">Delete Focal Person</h2>
                <p class="mb-6">Are you sure you want to delete this focal person? This action can be undone from the
                    admin panel.</p>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('deleteFocalPersonModal')"
                        class="px-4 py-2 rounded bg-gray-200 text-gray-700">Cancel</button>
                    <x-danger-button type="submit">Delete</x-danger-button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

function openEditFocalPersonModal(id, name, designation, email, mobile) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_designation').value = designation;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_mobile').value = mobile;
    document.getElementById('editFocalPersonForm').action = `/ngos/{{ $ngo->id }}/focal-persons/${id}`;
    document.getElementById('editFocalPersonModal').style.display = 'flex';
}

function openDeleteFocalPersonModal(id) {
    document.getElementById('delete_id').value = id;
    document.getElementById('deleteFocalPersonForm').action = `/ngos/{{ $ngo->id }}/focal-persons/${id}`;
    document.getElementById('deleteFocalPersonModal').style.display = 'flex';
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.edit-focal-person-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            openEditFocalPersonModal(
                btn.getAttribute('data-id'),
                btn.getAttribute('data-name'),
                btn.getAttribute('data-designation'),
                btn.getAttribute('data-email'),
                btn.getAttribute('data-mobile')
            );
        });
    });
});
</script>