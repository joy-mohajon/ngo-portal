<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'budget',
        'focus_area',
        'major_activities',
        'holder_id',
        'runner_id',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
        'major_activities' => 'array',
    ];

    public function holder(): BelongsTo
    {
        return $this->belongsTo(Ngo::class, 'holder_id');
    }

    public function runner(): BelongsTo
    {
        return $this->belongsTo(Ngo::class, 'runner_id');
    }

    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)
            ->withPivot(['enrollment_date', 'completion_date', 'status', 'notes'])
            ->withTimestamps();
    }
}