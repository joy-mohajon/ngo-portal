// Project Gallery JS

document.addEventListener('DOMContentLoaded', function () {
    const addBtn = document.getElementById('add-photos-btn');
    const modal = document.getElementById('gallery-upload-modal');
    const closeModal = document.getElementById('close-gallery-modal');
    const form = document.getElementById('gallery-upload-form');
    const input = document.getElementById('gallery-images-input');
    const preview = document.getElementById('gallery-preview');
    const galleryGrid = document.getElementById('gallery-grid');
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let projectId = galleryGrid.dataset.projectId || window.location.pathname.match(/projects\/(\d+)/)?.[1];

    // Modal open/close
    addBtn?.addEventListener('click', () => modal.classList.remove('hidden'));
    closeModal?.addEventListener('click', () => {
        modal.classList.add('hidden');
        form.reset();
        preview.innerHTML = '';
    });

    // Image preview
    input?.addEventListener('change', function () {
        preview.innerHTML = '';
        Array.from(this.files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-16 h-16 object-cover rounded border';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });

    // Drag-and-drop support
    preview?.addEventListener('dragover', e => { e.preventDefault(); preview.classList.add('ring-2', 'ring-indigo-400'); });
    preview?.addEventListener('dragleave', e => { preview.classList.remove('ring-2', 'ring-indigo-400'); });
    preview?.addEventListener('drop', e => {
        e.preventDefault();
        preview.classList.remove('ring-2', 'ring-indigo-400');
        input.files = e.dataTransfer.files;
        input.dispatchEvent(new Event('change'));
    });

    // AJAX upload
    form?.addEventListener('submit', function (e) {
        e.preventDefault();
        const files = input.files;
        if (!files.length) return alert('Please select at least one image.');
        const formData = new FormData();
        Array.from(files).forEach(f => formData.append('images[]', f));
        fetch(`/projects/${projectId}/galleries`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf },
            body: formData,
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                updateGalleryGrid(data.galleries);
                modal.classList.add('hidden');
                form.reset();
                preview.innerHTML = '';
            } else {
                alert('Upload failed.');
            }
        })
        .catch(() => alert('Upload error.'));
    });

    // Delete photo
    galleryGrid?.addEventListener('click', function (e) {
        if (e.target.closest('.delete-photo-btn')) {
            const btn = e.target.closest('.delete-photo-btn');
            if (!confirm('Delete this photo?')) return;
            const galleryId = btn.dataset.id;
            fetch(`/projects/${projectId}/galleries/${galleryId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    btn.closest('.group').remove();
                } else {
                    alert('Delete failed.');
                }
            })
            .catch(() => alert('Delete error.'));
        }
    });

    // Update gallery grid after upload
    function updateGalleryGrid(galleries) {
        galleryGrid.innerHTML = '';
        galleries.forEach(gallery => {
            const div = document.createElement('div');
            div.className = 'relative group';
            div.innerHTML = `
                <img src="/storage/${gallery.image_path}" alt="Gallery Image" class="w-full h-24 object-cover rounded shadow">
                <button class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition delete-photo-btn" data-id="${gallery.id}" title="Delete">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;
            galleryGrid.appendChild(div);
        });
    }
}); 