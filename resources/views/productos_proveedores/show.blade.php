@extends('layouts.app', ['activePage' => 'productos_proveedores', 'titlePage' => 'Productos_Proveedores'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
    <h3 class="page__heading">Vista detallada del Producto: {{ $producto_proveedor->producto->nombre }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <table class="table table-bordered table-striped ">
                        <tbody>
                        <tr>
                            <th>Proveedor Nombre</th>
                                <td><span class="badge badge-primary">{{$producto_proveedor->proveedor->nombre }}</span></td>
                            </tr>

                            <tr>
                                <th>Producto Nombre</th>
                                <td>{{ $producto_proveedor->producto->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Precio Producto</th>
                                <td>{{ $producto_proveedor->precio }} Bs</td>
                            </tr>
                            
                           
                            <tr>
                                <th>Fecha Asignado</th>
                                <td>{{ $producto_proveedor->fecha}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="button-container ">
                        <a href="{{ route('productos_proveedores.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
                       <!--  <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-info btn-twitter"> Editar </a> -->
                    </div>
                </div>
                <div>

                </div>
            </div>
        </div>
</section>




@endsection