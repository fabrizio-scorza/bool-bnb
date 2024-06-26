<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    public function houses()
    {
        return $this->belongsToMany(House::class)->withPivot('created_at', 'expires_at')->withTimestamps();
    }
}
