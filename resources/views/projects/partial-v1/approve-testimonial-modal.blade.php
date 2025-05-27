<div id="approveTestimonialModal" class="fixed inset-0 z-50 overflow-y-auto hidden" 
     x-data="{
         show: false,
         testimonialId: null,
         testimonialDate: '',
         testimonialFiles: [],
         init() {
             this.$watch('show', value => {
                 if (value) {
                     document.body.classList.add('overflow-hidden');
                 } else {
                     document.body.classList.remove('overflow-hidden');
                 }
             });
             
             this.$el.addEventListener('open-approve-modal', e => {
                 this.testimonialId = e.detail.testimonialId;
                 this.show = true;
             });
         },
         closeModal() {
             this.show = false;
             this.testimonialId = null;
             this.testimonialDate = '';
             this.testimonialFiles = [];
         },
         handleFileUpload(event) {
             this.testimonialFiles = Array.from(event.target.files);
         },
         removeFile(index) {
             this.testimonialFiles.splice(index, 1);
         },
         submitApproval() {
             if (!this.testimonialDate) {
                 alert('Please select a testimonial date');
                 return;
             }
             
             if (this.testimonialFiles.length === 0) {
                 alert('Please upload at least one testimonial document');
                 return;
             }
             
             // In a real app, you would submit the form here
             this.$dispatch('testimonial-approved', {
                 id: this.testimonialId,
                 date: this.testimonialDate,
                 files: this.testimonialFiles.map(file => ({
                     name: file.name,
                     size: file.size
                 }))
             });
             
             this.closeModal();
         },
         formatFileSize(bytes) {
             if (bytes < 1024) return bytes + ' bytes';
             else if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
             else return (bytes / 1048576).toFixed(1) + ' MB';
         }
     }" 
     x-show="show"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @keydown.escape="closeModal()">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
             x-show="show"
             @click="closeModal()"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
             x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Approve Testimonial
                        </h3>
                        <div class="mt-4">
                            <form id="approveTestimonialForm">
                                <div class="mb-4">
                                    <label for="testimonialDate" class="block text-sm font-medium text-gray-700">Testimonial Date</label>
                                    <input type="date" id="testimonialDate" x-model="testimonialDate" required
                                           class="mt-1 focus:ring-emerald-500 focus:border-emerald-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="mb-4">
                                    <label for="testimonialFileUpload" class="block text-sm font-medium text-gray-700">Testimonial Documents</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="testimonialFileUpload" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                                    <span>Upload files</span>
                                                    <input id="testimonialFileUpload" type="file" class="sr-only" multiple @change="handleFileUpload($event)">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">
                                                PDF, DOC, DOCX up to 10MB each
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-2 space-y-2" x-show="testimonialFiles.length > 0">
                                        <template x-for="(file, index) in testimonialFiles" :key="index">
                                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded-md">
                                                <div class="flex items-center">
                                                    <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    <span class="text-sm text-gray-700" x-text="file.name"></span>
                                                    <span class="text-xs text-gray-500 ml-2" x-text="formatFileSize(file.size)"></span>
                                                </div>
                                                <button type="button" @click="removeFile(index)" class="text-red-500 hover:text-red-700">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="button" @click="submitApproval()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Approve & Upload
                                    </button>
                                    <button type="button" @click="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>