<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Models\Project;
use App\Mail\TestimonialRequestSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TestimonialController extends Controller
{
    // NGO uploads testimonial supporting files
    public function store(Request $request, Project $project)
    {
        try {
            // Debug info
            Log::info('Testimonial request received', [
                'has_files' => $request->hasFile('application_file'),
                'all_files' => $request->allFiles(),
                'all_inputs' => $request->all()
            ]);
            
            // Check if the file was uploaded successfully first
            if (!$request->hasFile('application_file')) {
                Log::error('Testimonial file upload failed: No file in request');
                return back()->with('error', 'No file was uploaded. Please select a file and try again.');
            }
            
            if (!$request->file('application_file')->isValid()) {
                $uploadError = $request->file('application_file')->getError();
                Log::error('Testimonial file upload failed: File is invalid. Error code: ' . $uploadError);
                
                // Provide more specific error messages based on the error code
                $errorMessage = 'The file upload failed. ';
                switch ($uploadError) {
                    case UPLOAD_ERR_INI_SIZE:
                        $errorMessage .= 'The file is too large (maximum 2MB). Please reduce the file size and try again.';
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $errorMessage .= 'The file is too large. Please reduce the file size and try again.';
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $errorMessage .= 'The file was only partially uploaded. Please try again.';
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $errorMessage .= 'No file was uploaded. Please select a file and try again.';
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                    case UPLOAD_ERR_CANT_WRITE:
                    case UPLOAD_ERR_EXTENSION:
                        $errorMessage .= 'Server error occurred. Please try again later or contact support.';
                        break;
                    default:
                        $errorMessage .= 'It may be too large (maximum 2MB) or corrupted.';
                }
                
                return back()->with('error', $errorMessage);
            }
            
            // Check file size before validation
            $file = $request->file('application_file');
            $fileSize = $file->getSize() / 1024 / 1024; // Size in MB
            
            if ($fileSize > 2) {
                return back()->with('error', 'The file size exceeds the maximum limit of 2MB. Please reduce the file size and try again. You can compress PDF files or use a lower resolution for images.');
            }
            
            // Then validate the request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'application_file' => 'required|file|mimes:pdf,doc,docx|max:2048', // 2MB limit to match server config
            ]);
            
            // Check if the user has permission to add testimonials to this project
            $user = Auth::user();
            if (!$user || !$user->ngo || $project->runner_id != $user->ngo->id) {
                return back()->with('error', 'You do not have permission to add testimonials to this project.');
            }
            
            // Store the file with explicit disk specification
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('testimonials', $filename, 'public');
            
            if (!$filePath) {
                Log::error('Testimonial file storage failed: Could not save file');
                return back()->with('error', 'Could not save the application file. Please try again.');
            }
            
            // Ensure proper file permissions
            $fullPath = storage_path('app/public/' . $filePath);
            if (file_exists($fullPath)) {
                chmod($fullPath, 0644);
            }
            
            // Create the testimonial record
            $testimonial = $project->testimonials()->create([
                'title' => $request->title,
                'description' => $request->description,
                'application_file' => $filePath,
                'requested_by' => $user->ngo->id,
                'date' => now(),
                'status' => 'pending',
            ]);
            
            if (!$testimonial) {
                Log::error('Failed to create testimonial record in database');
                // If testimonial creation fails, delete the uploaded file
                Storage::disk('public')->delete($filePath);
                return back()->with('error', 'Failed to create testimonial record. Please try again.');
            }
            
            // Send email notification to authority and NGO
            try {
                // Send to authority email
                Mail::mailer('smtp')->to('dcgaibandha@mopa.gov.bd')
                    ->send(new TestimonialRequestSubmitted($testimonial));
                
                // Send to NGO's email if available
                if ($user->ngo->email) {
                    Mail::mailer('smtp')->to($user->ngo->email)
                        ->send(new TestimonialRequestSubmitted($testimonial));
                }
                
                Log::info('Testimonial request notification sent successfully');
            } catch (\Exception $e) {
                Log::error('Failed to send email notification: ' . $e->getMessage());
                // Continue execution even if email fails
            }
            
            return back()->with('success', 'Testimonial request submitted successfully.');
        } catch (\Exception $e) {
            Log::error('Error submitting testimonial: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return back()->with('error', 'There was a problem submitting your testimonial request: ' . $e->getMessage());
        }
    }

    // Authority approves testimonial by uploading testimonial file
    public function approve(Request $request, Testimonial $testimonial)
    {
        try {
            // Check if the file was uploaded successfully first
            if (!$request->hasFile('testimonial_file')) {
                return back()->with('error', 'No file was uploaded. Please select a file and try again.');
            }
            
            if (!$request->file('testimonial_file')->isValid()) {
                $uploadError = $request->file('testimonial_file')->getError();
                Log::error('Testimonial approval file upload failed: File is invalid. Error code: ' . $uploadError);
                return back()->with('error', 'The file upload failed. It may be too large (maximum 2MB) or corrupted.');
            }
            
            $validated = $request->validate([
                'testimonial_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // 2MB limit to match server config
            ]);
            
            // Check if the user has authority role
            $user = Auth::user();
            $hasAuthorityRole = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.model_id', $user->id)
                ->whereIn('roles.name', ['admin', 'authority'])
                ->exists();
                
            if (!$user || !$hasAuthorityRole) {
                return back()->with('error', 'You do not have permission to approve testimonials.');
            }
            
            // Store the file with explicit disk specification
            $file = $request->file('testimonial_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('testimonials', $filename, 'public');
            
            if (!$filePath) {
                return back()->with('error', 'Could not save the testimonial file. Please try again.');
            }
            
            // Ensure proper file permissions
            $fullPath = storage_path('app/public/' . $filePath);
            if (file_exists($fullPath)) {
                chmod($fullPath, 0644);
            }
            
            $testimonial->update([
                'testimonial_file' => $filePath,
                'status' => 'approved',
                'date' => now(),
            ]);
            
            return back()->with('success', 'Testimonial approved and file uploaded.');
        } catch (\Exception $e) {
            Log::error('Error approving testimonial: ' . $e->getMessage());
            return back()->with('error', 'There was a problem approving the testimonial: ' . $e->getMessage());
        }
    }

    // Authority rejects testimonial
    public function reject(Testimonial $testimonial)
    {
        try {
            // Check if the user has authority role
            $user = Auth::user();
            $hasAuthorityRole = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.model_id', $user->id)
                ->whereIn('roles.name', ['admin', 'authority'])
                ->exists();
                
            if (!$user || !$hasAuthorityRole) {
                return back()->with('error', 'You do not have permission to reject testimonials.');
            }
            
            $testimonial->update(['status' => 'rejected']);
            return back()->with('success', 'Testimonial rejected.');
        } catch (\Exception $e) {
            Log::error('Error rejecting testimonial: ' . $e->getMessage());
            return back()->with('error', 'There was a problem rejecting the testimonial: ' . $e->getMessage());
        }
    }

    // Authority or NGO can download application file
    public function downloadApplication(Testimonial $testimonial)
    {
        try {
            // Check if user has permission to download
            $user = Auth::user();
            if (!$user) {
                return back()->with('error', 'You need to be logged in to download files.');
            }
            
            // Check if user is admin/authority or the NGO that requested the testimonial
            $hasAuthorityRole = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.model_id', $user->id)
                ->whereIn('roles.name', ['admin', 'authority'])
                ->exists();
                
            $isRequestingNgo = $user->ngo && $user->ngo->id === $testimonial->requested_by;
            $isProjectRunner = $user->ngo && $testimonial->project && $testimonial->project->runner_id === $user->ngo->id;
            
            if (!$hasAuthorityRole && !$isRequestingNgo && !$isProjectRunner) {
                return back()->with('error', 'You do not have permission to download this file.');
            }
            
            if (!$testimonial->application_file || !Storage::disk('public')->exists($testimonial->application_file)) {
                return back()->with('error', 'Application file not found.');
            }
            
            $filePath = storage_path('app/public/' . $testimonial->application_file);
            return response()->download($filePath);
        } catch (\Exception $e) {
            Log::error('Error downloading application file: ' . $e->getMessage());
            return back()->with('error', 'There was a problem downloading the file: ' . $e->getMessage());
        }
    }

    public function downloadTestimonial(Testimonial $testimonial)
    {
        try {
            // Check if user has permission to download
            $user = Auth::user();
            if (!$user) {
                return back()->with('error', 'You need to be logged in to download files.');
            }
            
            // Check if user is admin/authority or the NGO that requested the testimonial
            $hasAuthorityRole = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.model_id', $user->id)
                ->whereIn('roles.name', ['admin', 'authority'])
                ->exists();
                
            $isRequestingNgo = $user->ngo && $user->ngo->id === $testimonial->requested_by;
            $isProjectRunner = $user->ngo && $testimonial->project && $testimonial->project->runner_id === $user->ngo->id;
            
            // Only approved testimonials can be downloaded
            if ($testimonial->status !== 'approved') {
                return back()->with('error', 'This testimonial is not approved yet.');
            }
            
            if (!$hasAuthorityRole && !$isRequestingNgo && !$isProjectRunner) {
                return back()->with('error', 'You do not have permission to download this file.');
            }
            
            if (!$testimonial->testimonial_file || !Storage::disk('public')->exists($testimonial->testimonial_file)) {
                return back()->with('error', 'Testimonial file not found.');
            }
            
            $filePath = storage_path('app/public/' . $testimonial->testimonial_file);
            return response()->download($filePath);
        } catch (\Exception $e) {
            Log::error('Error downloading testimonial file: ' . $e->getMessage());
            return back()->with('error', 'There was a problem downloading the file: ' . $e->getMessage());
        }
    }
} 