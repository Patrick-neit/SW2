<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table='productos';
    protected $fillable=['codigo','nombre','estado','categoria_id','unidad_medida_compra_id','unidad_medida_venta_id'];
    
    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function productos_proveedores(){
        return $this->hasMany(Producto_Proveedor::class); //No me reconoce el Model producto_proveedor
    }

    public function detalleCompra(){
        return $this->hasOne(DetalleCompra::class);
    }

    public function unidad_medida_compra(){
        return $this->belongsTo(UnidadMedidaCompra::class);
    }

    public function unidad_medida_venta(){
        return $this->belongsTo(UnidadMedidaVenta::class);
    }
}
