<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'category', 'branch', 'description', 'quantity', 'sale_price'];

    public static $branchOptions = [
        'Sucursal A',
        'Sucursal B',
        'Sucursal C'
    ];
}
