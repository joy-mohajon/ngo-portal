<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ngo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'logo',
        'name',
        'short_name',
        'description',
        'registration_id',
        'email',
        'website',
        'location',
        'focus_area',
        'focus_activities',
        'certificate_path',
        'established_year',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
        'focus_activities' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function focusAreas()
    {
        return $this->belongsToMany(FocusArea::class, 'ngo_has_focus_area');
    }

    public function focalPersons()
    {
        return $this->belongsToMany(FocalPerson::class, 'ngo_has_focal_person')
                    ->withTimestamps();
    }                                                                                                                                                                       

    /**
     * Get the status label for display
     */
    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }
}