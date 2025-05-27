<div id="uploadReportModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
            <button id="closeUploadReportModalBtn" type="button" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">&times;</button>
            <h2 class="text-lg font-semibold mb-4">Upload Report</h2>
            <form id="uploadReportForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Report Title</label>
                    <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">File</label>
                    <input type="file" name="file" class="w-full" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>