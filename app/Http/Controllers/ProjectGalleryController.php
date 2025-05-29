<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
        $this->authorize('update', $project);
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);
        $uploaded = [];
        foreach ($request->file('images', []) as $file) {
            $path = $file->store('project_galleries', 'public');
            $gallery = $project->galleries()->create([
                'image_path' => $path,
                'sort_order' => $project->galleries()->count(),
            ]);
            $uploaded[] = $gallery;
        }
        return response()->json(['success' => true, 'galleries' => $uploaded]);
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