<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

class ProjectGalleryController extends Controller
{
    use AuthorizesRequests;
    public function index(Project $project)
    {
        $this->authorize('view', $project);
        $galleries = $project->galleries()->get();
        return response()->json($galleries);
    }

    public function store(Request $request, Project $project)
    {
        Log::info('Project gallery upload request received', [
            'project_id' => $project->id,
            'has_files' => $request->hasFile('images'),
            'content_type' => $request->header('Content-Type')
        ]);
        
        $this->authorize('update', $project);
        
        try {
            try {
                $validator = Validator::make($request->all(), [
                    'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                ]);
                
                if ($validator->fails()) {
                    Log::warning('Validation failed', [
                        'errors' => $validator->errors()->toArray(),
                        'request_data' => $request->all(),
                    ]);
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors()->first(),
                        'errors' => $validator->errors()->toArray()
                    ], 422);
                }
                
                $validator->validate();
            } catch (\Illuminate\Validation\ValidationException $e) {
                Log::error('Validation exception', [
                    'errors' => $e->errors(),
                    'message' => $e->getMessage()
                ]);
                throw $e;
            }
            
            $uploaded = [];
            
            if (!$request->hasFile('images')) {
                Log::warning('No images in request', ['request' => $request->all()]);
                return response()->json([
                    'success' => false,
                    'message' => 'No images were uploaded'
                ], 400);
            }
            
            Log::info('Processing ' . count($request->file('images')) . ' files');
            
            foreach ($request->file('images', []) as $index => $file) {
                Log::info('Processing file', [
                    'index' => $index,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'error' => $file->getError()
                ]);
                
                if ($file->isValid()) {
                    $path = $file->store('project_galleries', 'public');
                    Log::info('File stored at: ' . $path);
                    
                    $gallery = $project->galleries()->create([
                        'image_path' => $path,
                        'sort_order' => $project->galleries()->count(),
                    ]);
                    $uploaded[] = $gallery;
                } else {
                    Log::error('Invalid file', [
                        'error' => $file->getError(),
                        'error_message' => $file->getErrorMessage()
                    ]);
                }
            }
            
            if (count($uploaded) > 0) {
                Log::info('Successfully uploaded ' . count($uploaded) . ' images');
                return response()->json([
                    'success' => true, 
                    'galleries' => $uploaded,
                    'message' => count($uploaded) . ' images uploaded successfully'
                ]);
            } else {
                Log::warning('No images were successfully uploaded');
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload images'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Exception during file upload: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Project $project, ProjectGallery $gallery)
    {
        $this->authorize('update', $project);
        if ($gallery->project_id !== $project->id) {
            abort(403);
        }
        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();
        return response()->json(['success' => true]);
    }
} 