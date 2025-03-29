<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;
    protected $table = 'suppliers'; // Nombre de la tabla
    protected $fillable = [
        'name',
        'ruc',
        'address',
        'state',
    ];
}
