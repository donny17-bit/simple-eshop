<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleOrder extends Model
{
    use HasFactory;
    protected $table = 'sale_order';

    protected $fillable = [
        'id_product',
        'id_customer',
        'invoice_number',
        'quantity',
        'unit_price',
        'status'
    ];
}
