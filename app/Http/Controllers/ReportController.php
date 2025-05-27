<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use \ZipArchive;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::with(['project', 'submitter'])->latest()->paginate(10);
        return view('reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        return view('reports.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'month' => 'required|string',
            'files.*' => 'required|file|max:10240', // 10MB max per file
        ]);

        $files = $request->file('files');
        $reports = [];
        $projectId = $request->project_id;

        foreach ($files as $file) {
            $filePath = $file->store('reports', 'public');
            
            $report = new Report([
                'project_id' => $projectId,
                'submitted_by' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
                'month' => $request->month,
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_type' => $file->getClientMimeType(),
                'status' => 'submitted'
            ]);
            
            $report->save();
            $reports[] = $report;
        }

        // Check if this is an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => count($reports) . ' reports uploaded successfully',
                'reports' => $reports
            ]);
        }
        
        // For regular form submissions, redirect back with success message
        return back()->with('success', count($reports) . ' reports uploaded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        // Delete the file from storage
        if (Storage::disk('public')->exists($report->file_path)) {
            Storage::disk('public')->delete($report->file_path);
        }
        
        $report->delete();
        
        return redirect()->back()->with('success', 'Report deleted successfully');
    }
    
    /**
     * Download all reports for a project as a ZIP file
     */
    public function downloadProjectReports(Project $project, Request $request)
    {
        $reportsQuery = $project->reports();
        $from = $request->query('from_date');
        $to = $request->query('to_date');
        if ($from) {
            $reportsQuery->where('month', '>=', $from);
        }
        if ($to) {
            $reportsQuery->where('month', '<=', $to);
        }
        $reports = $reportsQuery->get();
        if ($reports->isEmpty()) {
            return redirect()->back()->with('error', 'No reports available for this project in the selected date range');
        }
        
        // Create a temporary file to serve as the ZIP
        $zipFileName = 'project_' . $project->id . '_reports.zip';
        $zipFilePath = storage_path('app/temp/' . $zipFileName);
        
        // Ensure the temp directory exists
        if (!File::exists(storage_path('app/temp'))) {
            File::makeDirectory(storage_path('app/temp'), 0755, true);
        }
        
        // Create the ZIP file
        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($reports as $report) {
                $filePath = storage_path('app/public/' . $report->file_path);
                if (File::exists($filePath)) {
                    // Add file to the ZIP with a suitable name to avoid conflicts
                    $zip->addFile($filePath, $report->month . '_' . $report->file_name);
                }
            }
            $zip->close();
            
            // Serve the ZIP file for download
            return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
        }
        
        return redirect()->back()->with('error', 'Could not create ZIP file');
    }
}