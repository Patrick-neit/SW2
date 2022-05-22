<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class User extends Authenticatable
{
    use HasRoles;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

            'email',
            'foto',
            'name',
            'apellido',
            'fecha_nacimiento',
            'ci',
            'celular_personal',
            'celular_referencia',
            'domicilio',
            'zona',
            'codigo',
            'password',
            'estado',
            'tipo_usuario_id',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function username()
    {
        return 'email';
    }

    public function tipo_usuarios(){
        return $this->belongsTo(TipoUsuario::class);
    }

    public function sucursals(){
        return $this->belongsToMany(Sucursal::class);
    }

    public function sanciones(){
        return $this->hasMany(Sanciones::class);
    }

    public function turnos(){
        return $this->hasMany(Turno::class);
    }

    public function detalleContratos(){
        return $this->hasMany(DetalleContrato::class);
    }
    public function bonos(){
        return $this->hasMany(Bono::class);
    }

    public function descuentos(){
        return $this->hasMany(Descuento::class);
    }

    public function cargosucursals(){
        return $this->belongsToMany(CargoSucursal::class);
    }

    public function tareas(){
        return $this->belongsToMany(Tarea::class)->withTimestamps()->withPivot('created_at');
    }

    public function horarios(){
        return $this->hasMany(Horario::class);
    }

    public function habilidades(){
        return $this->hasMany(Habilidad::class);
    }

    public function experiencias_laborales(){
        return $this->hasMany(ExperienciaLaboral::class);
    }

    public function salidas(){
        return $this->hasMany(Salida::class);
    }

    public function compras(){
        return $this->hasMany(Compra::class);
    }
    
    public function vacaciones(){
        return $this->hasMany(Vacacion::class);
    }

    public function detalles_vacaciones(){
        return $this->hasMany(DetalleVacacion::class);
    }

    public function observaciones(){
        return $this->hasMany(Observacion::class);
    }

    public function detalles_observaciones(){
        return $this->hasMany(DetalleObservacion::class);
    }

    public function cronologias(){
        return $this->hasMany(Cronologia::class);
    }

    public function detalles_cronologias(){
        return $this->hasMany(DetalleCronologia::class);
    }

    public function detalleSanciones(){
        return $this->hasMany(DetalleSancion::class);
    }

    public function garante(){
        return $this->hasOne(Garante::class);
    }
    
    public function retrasofalta(){
        return $this->hasMany(RetrasoFalta::class);
    }


    public function educaciones(){
        return  $this->hasMany(Educacion::class);
    }

    public function registro_tareas(){
        return $this->hasMany(RegistroTarea::class);
    }

   public function pagos(){
       return $this->hasMany(Pago::class);
   }
    

}
