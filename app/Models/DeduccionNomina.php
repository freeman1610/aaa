<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeduccionNomina extends Model
{
    use HasFactory;

    protected $table = 'deduccion_nomina';
    protected $primaryKey = 'id_deduccion';
}
