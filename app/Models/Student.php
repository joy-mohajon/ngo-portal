<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'photo',
        'national_id',
        'national_id_file',
        'birth_certificate_number', 
        'birth_certificate_file',
        'date_of_birth',
        'gender',
        'guardian_name',
        'guardian_phone',
        'guardian_address',
        'enrollment_date',
        'education_level',
        'education_institution',
        'status',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'enrollment_date' => 'date',
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)
            ->withPivot(['enrollment_date', 'completion_date', 'status', 'notes'])
            ->withTimestamps();
    }
}