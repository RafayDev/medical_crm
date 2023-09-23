<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{
    use HasFactory;
    function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    function type(){
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }
    function product(){
        return $this->belongsTo(Product::class, 'sub_type_id', 'sub_type_id');
    }
}
