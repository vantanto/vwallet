<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'icon', 
        'category_id', 'user_id',
    ];

    protected function icon(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value 
                ?? ($this->category_id ? $this->category->icon : "ti ti-receipt-2")
        );
    }

    public function scopeUserId($query, $alias = 'categories')
    {
        return $query->where($alias.'.user_id', Auth::user()->id);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
