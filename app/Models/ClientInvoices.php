<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientInvoices extends Model
{
    use HasFactory;
    function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    function client_invoice_products(){
        return $this->hasMany(ClientInvoiceProduct::class, 'client_invoice_id', 'id');
    }
}
