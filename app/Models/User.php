<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // Otros atributos y métodos de tu modelo User

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
