<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;
    protected $table = 'tareas';
    protected $fillable = ['nombre', 'hora_inicio', 'hora_fin', 'turno', 'dia_semana'];

    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function cargo(){
        return $this->belongsTo(CargoSucursal::class);
    }
}
