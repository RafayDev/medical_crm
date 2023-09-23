<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    function subtypes()
    {
        return $this->hasMany(SubType::class, 'type_id', 'id');
    }
}
