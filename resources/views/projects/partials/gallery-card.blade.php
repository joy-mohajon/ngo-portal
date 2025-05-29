<div class="bg-white rounded-lg shadow p-0 mb-6 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900 flex items-center">
            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
            </svg>
            Gallery
        </h3>
        <button id="add-photos-btn"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition"
            type="button">
            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add
        </button>
    </div>
    <div class="px-6 py-4">
        <div id="gallery-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2"
            data-project-id="{{ $project->id }}">
            @foreach($project->galleries as $gallery)
            <div class="relative group bg-gray-50 rounded-lg overflow-hidden border border-gray-100 shadow-sm">
                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Gallery Image"
                    class="w-full h-16 object-cover rounded-t-lg">
                <button
                    class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition delete-photo-btn"
                    data-id="{{ $gallery->id }}" title="Delete">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Add Photos Modal -->
<div id="gallery-upload-modal"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg relative border border-indigo-100">
        <button id="close-gallery-modal" class="absolute top-4 right-4 text-gray-400 hover:text-indigo-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <h4 class="text-2xl font-bold mb-2 text-indigo-700 text-center">Upload Project Photos</h4>
        <p class="text-gray-500 mb-6 text-center">Drag & drop images here, or click to select. Max 4MB each. JPG, PNG,
            GIF, WEBP.</p>
        <form id="gallery-upload-form" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <label for="gallery-images-input" class="block cursor-pointer">
                <div id="gallery-drop-area"
                    class="flex flex-col items-center justify-center border-2 border-dashed border-indigo-300 rounded-xl p-6 bg-indigo-50 hover:bg-indigo-100 transition mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-400 mb-2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                    <span class="text-indigo-500 font-medium">Click or drag files to upload</span>
                </div>
                <input type="file" name="images[]" id="gallery-images-input" accept="image/*" multiple class="hidden">
            </label>
            <div id="gallery-preview" class="flex flex-wrap gap-3 mb-2 min-h-[48px]"></div>
            <div id="gallery-upload-progress" class="w-full h-2 bg-indigo-100 rounded overflow-hidden mb-2 hidden">
                <div class="h-full bg-indigo-500 transition-all" style="width:0%"></div>
            </div>
            <button type="submit"
                class="bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white px-6 py-2 rounded-xl font-semibold w-full shadow-lg transition">Upload</button>
        </form>
    </div>
</div>