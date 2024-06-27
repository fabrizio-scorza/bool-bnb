<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'rooms',
        'beds',
        'bathrooms',
        'square_mt',
        'address',
        'thumb',
        'available',
        'category_id',
        'user_id',
        'price_per_night'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
    public function plans()
    {
        return $this->belongsToMany(Plan::class)->withPivot('created_at', 'expires_at')->withTimestamps();
    }
}
