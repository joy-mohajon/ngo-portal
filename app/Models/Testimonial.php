<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'file_path',
        'submitted_by',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function submitter()
    {
        return $this->belongsTo(Ngo::class, 'submitted_by');
    }
}
