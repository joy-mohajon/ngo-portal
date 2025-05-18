<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ngo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'Description',
        'registration_id',
        'phone_number',
        'email',
        'location',
        'certificate_path',
        'logo',
        'website',
        'status',
        'established_year'
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