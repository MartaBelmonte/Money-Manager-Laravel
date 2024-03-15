<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'description', 'amount', 'category', 'type', 'transfer_type'];

    protected $attributes = [
        'description' => 'Descripción predeterminada', 
    ];
    
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
