<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    function invoice_products()
    {
        return $this->hasMany(InvoiceProduct::class, 'invoice_id', 'id');
    }
}
