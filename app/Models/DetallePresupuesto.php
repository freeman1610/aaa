<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePresupuesto extends Model
{
    use HasFactory;
    protected $table = 'detalle_presupuesto';
    protected $primaryKey = 'id';
}
