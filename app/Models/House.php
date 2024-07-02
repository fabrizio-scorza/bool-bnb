<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class House extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

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
        'price_per_night',
        'latitude',
        'longitude'
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
