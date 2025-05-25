<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'testimonial_file',
        'application_file',
        'requested_by',
        'date',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function requester()
    {
        return $this->belongsTo(Ngo::class, 'requested_by');
    }
}