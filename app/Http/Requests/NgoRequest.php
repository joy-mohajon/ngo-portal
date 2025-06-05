<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NgoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Change to your authorization logic if needed
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:20',
            'email' => 'required|email|unique:ngos',
            'website' => 'nullable|url',
            'location' => 'required|string|max:255',
            'focus_areas' => 'required|array',
            'focus_areas.*' => 'required|integer|exists:focus_areas,id',
            'focus_activities' => 'required|array',
            'focus_activities.*' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:min_width=100,min_height=100',
            'certificate_path' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'established_year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
        ];
    }

    /**
     * Custom validation error messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The organization name is required.',
            'name.max' => 'The organization name may not be longer than 255 characters.',
            
            'short_name.required' => 'The short name is required.',
            'short_name.max' => 'The short name may not be longer than 20 characters.',
            
            'email.required' => 'The email address is required.',
            'email.unique' => 'This email is already registered with another NGO.',
            
            'website.url' => 'Please enter a valid website URL.',
            
            'location.required' => 'The location field is required.',
            
            'focus_areas.required' => 'Please select at least one focus area.',
            'focus_areas.array' => 'Invalid focus areas selection.',
            'focus_areas.*.exists' => 'One or more selected focus areas are invalid.',
            
            'focus_activities.required' => 'Please add at least one focus activity.',
            'focus_activities.array' => 'Invalid focus activities format.',
            'focus_activities.*.max' => 'Each focus activity may not be longer than 255 characters.',
            
            'logo.required' => 'The NGO logo is required.',
            'logo.file' => 'The logo must be a valid file.',
            'logo.image' => 'The uploaded file must be an image.',
            'logo.mimes' => 'The logo must be a JPEG, PNG, JPG or GIF file.',
            'logo.max' => 'The logo may not be larger than 2MB.',
            'logo.dimensions' => 'The logo must be at least 100x100 pixels.',
            
            'certificate_path.required' => 'The registration certificate file is required.',
            'certificate_path.file' => 'The certificate must be a valid file.',
            'certificate_path.mimes' => 'The certificate must be a PDF, JPG, JPEG, or PNG file.',
            'certificate_path.max' => 'The certificate file may not be larger than 4MB.',
            
            'established_year.required' => 'The established year is required.',
            'established_year.digits' => 'The year must be a 4-digit number.',
            'established_year.min' => 'The year must be 1900 or later.',
            'established_year.max' => 'The year cannot be in the future.',
        ];
    }
}