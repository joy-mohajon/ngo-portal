<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'organizer_id',
        'project_id',
        'start_date',
        'end_date',
        'capacity',
        'registration_deadline',
        'category',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'registration_deadline' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Ngo::class, 'organizer_id');
    }
}