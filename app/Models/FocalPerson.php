<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FocalPerson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'designation',
    ];

    protected $table = 'focal_persons';

    public function ngos()
    {
        return $this->belongsToMany(Ngo::class, 'ngo_has_focal_person');
    }
}