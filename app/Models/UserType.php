<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    const ADMIN = 1;
    const SALES = 2;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
