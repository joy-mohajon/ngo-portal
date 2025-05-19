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
        'description',
        'focus_area',
        'registration_id',
        'email',
        'website',
        'location',
        'certificate_path',
        'established_year',
        'status',
        'focus_activities',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function focusAreas()
    {
        return $this->belongsToMany(FocusArea::class, 'ngo_has_focus_area');
    }

    /**
     * Get the status label for display
     */
    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }
}