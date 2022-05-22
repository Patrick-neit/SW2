<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;
    protected $table='sucursals';
    protected $fillable=['nombre','direccion','correo','nro_fiscal'];

    public function productos_proveedores(){
        return $this->hasMany(Producto_Proveedor::class); 
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function horarios(){
        return $this->hasMany(Horario::class);
    }

    public function cargos_sucursales(){
        return $this->hasMany(Cargos_sucursales::class);
    }

    public function Horario(){
        return $this->hasMany(Horario::class);
    }

    public function compras(){
        return $this->hasMany(Compra::class);
    }

    public function usuario_sucursal(){
        return $this->hasMany(UsuarioSucursal::class);
    }

    public function pagos(){
        return $this->hasMany(Pago::class);
    }
   
   
}
