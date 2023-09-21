<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubType extends Model
{
    use HasFactory;
    function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }
}
