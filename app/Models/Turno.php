<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;
    protected $table= 'turnos';
    protected $fillable = ['turno','hora_inicio','hora_fin','usuario_id'];
}
