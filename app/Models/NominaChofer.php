<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NominaChofer extends Model
{
    use HasFactory;
    protected $table = 'nomina_choferes';
    protected $primaryKey = 'id_nomina_chofer';
}
