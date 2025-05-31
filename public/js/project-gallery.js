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
    let projectId = galleryGrid?.dataset.projectId || window.location.pathname.match(/projects\/(\d+)/)?.[1];
    
    // Constants for image resizing
    const MAX_WIDTH = 1800;
    const MAX_HEIGHT = 1200;
    const QUALITY = 0.7;
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB limit for server restrictions

    // Modal open/close
    addBtn?.addEventListener('click', () => modal.classList.remove('hidden'));
    closeModal?.addEventListener('click', () => {
        modal.classList.add('hidden');
        form.reset();
        preview.innerHTML = '';
        
        // Clear error messages
        const errorContainer = document.getElementById('upload-error-container');
        if (errorContainer) {
            errorContainer.innerHTML = '';
            errorContainer.classList.add('hidden');
        }
    });

    // Image preview with resizing information
    input?.addEventListener('change', function () {
        preview.innerHTML = '';
        
        if (this.files.length === 0) return;
        
        Array.from(this.files).forEach((file, index) => {
            if (!file.type.startsWith('image/')) return;
            
            const reader = new FileReader();
            reader.onload = e => {
                const imgContainer = document.createElement('div');
                imgContainer.className = 'relative';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-16 h-16 object-cover rounded border';
                img.setAttribute('data-original-size', formatFileSize(file.size));
                
                const sizeBadge = document.createElement('span');
                sizeBadge.className = 'absolute -top-2 -right-2 bg-gray-800 text-white text-xs px-1 rounded-full';
                sizeBadge.textContent = formatFileSize(file.size);
                
                imgContainer.appendChild(img);
                imgContainer.appendChild(sizeBadge);
                preview.appendChild(imgContainer);
                
                // Show warning for large files
                if (file.size > MAX_FILE_SIZE) {
                    sizeBadge.classList.remove('bg-gray-800');
                    sizeBadge.classList.add('bg-yellow-500');
                    
                    const warningText = document.createElement('div');
                    warningText.className = 'text-xs text-yellow-600 mt-1';
                    warningText.textContent = 'Will be resized';
                    imgContainer.appendChild(warningText);
                }
            };
            reader.readAsDataURL(file);
        });
    });

    // Drag-and-drop support
    const dropArea = document.getElementById('gallery-drop-area');
    dropArea?.addEventListener('dragover', e => { 
        e.preventDefault(); 
        dropArea.classList.add('ring-2', 'ring-indigo-400'); 
    });
    
    dropArea?.addEventListener('dragleave', e => { 
        dropArea.classList.remove('ring-2', 'ring-indigo-400'); 
    });
    
    dropArea?.addEventListener('drop', e => {
        e.preventDefault();
        dropArea.classList.remove('ring-2', 'ring-indigo-400');
        input.files = e.dataTransfer.files;
        input.dispatchEvent(new Event('change'));
    });

    // AJAX upload with resizing
    form?.addEventListener('submit', async function (e) {
        e.preventDefault();
        const files = input.files;
        if (!files.length) return alert('Please select at least one image.');
        
        // Clear any previous error messages
        const errorContainer = document.getElementById('upload-error-container');
        if (errorContainer) {
            errorContainer.innerHTML = '';
            errorContainer.classList.add('hidden');
        }
        
        // Show progress indicator
        const progressBar = document.getElementById('gallery-upload-progress');
        progressBar.classList.remove('hidden');
        const progressInner = progressBar.querySelector('div');
        progressInner.style.width = '10%';
        
        try {
            // Create FormData object
            const formData = new FormData();
            
            // Process each file (resize if needed)
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                let fileToUpload = file;
                
                // Update progress
                progressInner.style.width = `${10 + (i / files.length) * 40}%`;
                
                // Resize large images
                if (file.type.startsWith('image/') && file.size > MAX_FILE_SIZE) {
                    try {
                        fileToUpload = await resizeImage(file);
                        console.log(`Resized ${file.name} from ${formatFileSize(file.size)} to ${formatFileSize(fileToUpload.size)}`);
                    } catch (error) {
                        console.error('Error resizing image:', error);
                        // If resize fails, use original but it may hit upload limit
                    }
                }
                
                formData.append('images[]', fileToUpload);
            }
            
            // Add CSRF token
            formData.append('_token', csrf);
            
            // Update progress
            progressInner.style.width = '50%';
            
            console.log('Uploading files to: ', `/projects/${projectId}/galleries`);
            
            // Send the request
            const response = await fetch(`/projects/${projectId}/galleries`, {
                method: 'POST',
                credentials: 'same-origin',
                body: formData
            });
            
            // Update progress
            progressInner.style.width = '90%';
            
            console.log('Response status:', response.status);
            
            if (!response.ok) {
                const text = await response.text();
                console.error('Error response:', text);
                
                let errorMessage = `Upload failed (${response.status})`;
                
                try {
                    const errorJson = JSON.parse(text);
                    if (errorJson.message) {
                        errorMessage = errorJson.message;
                    }
                    
                    // Display detailed validation errors if available
                    if (errorJson.errors) {
                        let errorHtml = '<ul class="list-disc pl-5 mt-1">';
                        Object.keys(errorJson.errors).forEach(key => {
                            errorJson.errors[key].forEach(error => {
                                errorHtml += `<li>${error}</li>`;
                            });
                        });
                        errorHtml += '</ul>';
                        
                        if (errorContainer) {
                            errorContainer.innerHTML = errorHtml;
                            errorContainer.classList.remove('hidden');
                        }
                    }
                } catch (e) {
                    console.error('Error parsing JSON response:', e);
                }
                
                throw new Error(errorMessage);
            }
            
            const data = await response.json();
            
            // Update progress
            progressInner.style.width = '100%';
            
            console.log('Success response:', data);
            
            if (data.success) {
                // Clear error messages
                if (errorContainer) {
                    errorContainer.innerHTML = '';
                    errorContainer.classList.add('hidden');
                }
                
                updateGalleryGrid(data.galleries);
                modal.classList.add('hidden');
                form.reset();
                preview.innerHTML = '';
            } else {
                alert('Upload failed: ' + (data.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Upload error:', error);
            
            if (errorContainer) {
                errorContainer.innerHTML = `<p class="font-semibold">Upload failed:</p><p>${error.message}</p>`;
                errorContainer.classList.remove('hidden');
            } else {
                alert('Upload failed. Please try again. Error: ' + error.message);
            }
        } finally {
            // Hide progress indicator
            progressBar.classList.add('hidden');
            progressInner.style.width = '0%';
        }
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
        if (!galleryGrid) return;
        
        galleries.forEach(gallery => {
            const div = document.createElement('div');
            div.className = 'relative group bg-gray-50 rounded-lg overflow-hidden border border-gray-100 shadow-sm';
            div.innerHTML = `
                <img src="/storage/${gallery.image_path}" alt="Gallery Image" 
                     class="w-full h-16 object-cover rounded-t-lg">
                <button class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition delete-photo-btn" 
                        data-id="${gallery.id}" title="Delete">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;
            galleryGrid.appendChild(div);
        });
    }
    
    // Helper function to resize images
    async function resizeImage(file) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            img.onload = () => {
                // Calculate new dimensions
                let width = img.width;
                let height = img.height;
                
                if (width > MAX_WIDTH) {
                    height = Math.round(height * (MAX_WIDTH / width));
                    width = MAX_WIDTH;
                }
                
                if (height > MAX_HEIGHT) {
                    width = Math.round(width * (MAX_HEIGHT / height));
                    height = MAX_HEIGHT;
                }
                
                // Create canvas for resizing
                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                
                // Draw image on canvas
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);
                
                // Get resized image as blob
                canvas.toBlob((blob) => {
                    if (!blob) {
                        reject(new Error('Canvas to Blob conversion failed'));
                        return;
                    }
                    
                    // Create new file from blob
                    const resizedFile = new File([blob], file.name, {
                        type: file.type,
                        lastModified: Date.now()
                    });
                    
                    resolve(resizedFile);
                }, file.type, QUALITY);
            };
            
            img.onerror = () => reject(new Error('Failed to load image'));
            
            // Load image from file
            const reader = new FileReader();
            reader.onload = (e) => img.src = e.target.result;
            reader.onerror = () => reject(new Error('Failed to read file'));
            reader.readAsDataURL(file);
        });
    }
    
    // Helper function to format file size
    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + 'B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + 'KB';
        return (bytes / 1048576).toFixed(1) + 'MB';
    }
}); 