<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chuto extends Model
{
    use HasFactory;
    protected $table = 'chutos';
    protected $primaryKey = 'chuto_id';
}
