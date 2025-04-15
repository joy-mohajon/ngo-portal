<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ngo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'registration_id',
        'phone_number',
        'email',
        'location',
        'focus_area',
        'certificate_path',
        'image_path',
        'status'
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the status label for display
     */
    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }
}