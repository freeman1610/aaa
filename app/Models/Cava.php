<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cava extends Model
{
    use HasFactory;
    protected $table = 'cavas';
    protected $primaryKey = 'cava_id';
}
