<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionNomina extends Model
{
    use HasFactory;

    protected $table = 'asignacion_nomina';
    protected $primaryKey = 'id_asignacion';
}
