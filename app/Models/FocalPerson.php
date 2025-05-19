<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FocalPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'designation'
    ];

    /**
     * The NGOs that belong to this focal person
     */
    public function ngos()
    {
        return $this->belongsToMany(Ngo::class)
            ->withTimestamps(); // if you want to track when relationships were created
    }

    /**
     * The projects that belong to this focal person
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class)
            ->withTimestamps(); // if you want to track when relationships were created
    }

    /**
     * Helper method to get all organizations this person is associated with
     */
    public function getAllOrganizations()
    {
        return $this->ngos->merge($this->projects->map->holder);
    }

    /**
     * Helper method to check if person is associated with given NGO
     */
    public function isAssociatedWithNgo($ngoId)
    {
        return $this->ngos()->where('ngos.id', $ngoId)->exists();
    }

    /**
     * Helper method to check if person is associated with given project
     */
    public function isAssociatedWithProject($projectId)
    {
        return $this->projects()->where('projects.id', $projectId)->exists();
    }
}
