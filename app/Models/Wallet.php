<?php

namespace App\Models;

use App\Casts\NumberFormatNoZeroes;
use App\Models\Scopes\UserIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'initial_balance', 'balance',
    ];

    protected $casts = [
        'balance' => NumberFormatNoZeroes::class,
    ];

    protected static function booted()
    {
        static::addGlobalScope(new UserIdScope);
    }
}
