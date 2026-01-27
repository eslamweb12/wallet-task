<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference',
        'balance',
    ];

    protected $attributes = [
        'balance' => 0, // default balance
    ];

    // توليد reference تلقائي عند إنشاء wallet


    // علاقة بالمستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة بالمعاملات
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
