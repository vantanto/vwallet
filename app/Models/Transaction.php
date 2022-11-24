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

    public static $Type = ["in", "out", "transfer"];

    protected $fillable = [
        'wallet_id', 'date', 'category_id', 
        'type', 'nominal', 'description',
        'designated_wallet_id', 'designated_transaction_id',
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

    protected function typeInOut(): Attribute
    {
        $typeInOut = $this->type;
        if ($typeInOut == "transfer") $typeInOut = $this->designated_wallet_id ? "in" : "out";
        return Attribute::make(
            get: fn($value) => $typeInOut
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function designatedTransactionChild()
    {
        return $this->hasOne(Transaction::class, 'designated_transaction_id');
    }

    public function designatedWalletChild()
    {
        return $this->hasOneThrough(Wallet::class, Transaction::class,'designated_transaction_id', 'id', 'id', 'wallet_id');
    }

    public function designatedTransaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function designatedWallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Transaction::class);
    }
}
