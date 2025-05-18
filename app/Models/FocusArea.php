<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FocusArea extends Model
{
   use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public function ngos()
    {
        return $this->belongsToMany(Ngo::class, 'ngo_has_focus_area');
    }
}
