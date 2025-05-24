<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Authority extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'address',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
