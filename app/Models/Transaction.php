<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    public static $Type = ["in", "out"];

    protected $fillable = [
        'wallet_id', 'date', 'category_id', 
        'type', 'nominal', 'description',
    ];

    protected function nominalFormat(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Helper::numberFormatNoZeroes($this->nominal)
        );
    }

    protected function dateShort(): Attribute
    {
        return Attribute::make(
            get: fn($value) => date('M d', strtotime($this->date))
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Transaction::class);
    }
}
