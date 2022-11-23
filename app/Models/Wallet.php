<?php

namespace App\Models;

use App\Casts\NumberFormatNoZeroes;
use App\Helpers\Helper;
use App\Models\Scopes\UserIdScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'initial_balance', 'balance',
        'is_main', 'user_id',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new UserIdScope);
    }

    protected function balanceFormat(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Helper::numberFormatNoZeroes($this->balance)
        );
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::Class);
    }
}
