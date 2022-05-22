@extends('layouts.app', ['activePage' => 'contabilidad', 'titlePage' => 'Productos_Proveedores'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Reporte de Compras y Pagos Por Proveedor</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Seleccione las Fechas</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x: hidden">
                            <form action="{{ route('contabilidad.filtrarComprasyPagos') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="input-daterange input-group" id="datepicker">
                                            <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                            <input type="date" id="fechaini" class="input-sm form-control" name="fecha_inicial" value="" />
                                            <span class="input-group-addon">A</span>
                                            <input type="date" id="fechamax" class="input-sm form-control" name="fecha_final" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control btn btn-primary" type="submit" value="Filtrar Compras y Pagos" id="filtrar" name="filtrar">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="table">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;" class="table-primary">PROVEEDORES</th>
                                        <th style="text-align: center;" class="table-primary">TOTAL COMPRAS</th>
                                        <th style="text-align: center;" class="table-primary">TOTAL PAGOS</th>
                                        <th style="text-align: center;" class="table-primary">TOTAL POR PAGAR</th>
                                    </tr>
                                </thead>
                                @php $totalPagos=0; $totalCompras=0; $totalPorPagar=0; @endphp
                                @foreach ($collection as $item )
                                @php
                                $MayusculasProveedor= strtoupper($item['proveedor_nombre']);
                                $totalCompras+=$item['total_compras'];
                                $totalPagos+=$item['total_pagos'];
                                $totalPorPagar+=$item['total_por_pagar'];
                                @endphp
                                <tr>
                                    <th style="text-align: center;" class="table-success">{{$MayusculasProveedor}}</th>
                                    <td style="text-align: center;" class="table-warning">{{$item['total_compras']}} Bs</td>
                                    <td style="text-align: center;" class="table-warning">{{$item['total_pagos']}} Bs</td>
                                    <td style="text-align: center;" class="table-warning">{{$item['total_por_pagar']}} Bs</td>
                                </tr>
                                @endforeach
                                <tfoot>
                                    <th style="text-align: center;" class="table-info">TOTALES</th>
                                    <th style="text-align: center;" class="table-danger">{{$totalCompras}} Bs</th>
                                    <th style="text-align: center;" class="table-danger">{{$totalPagos}} Bs</th>
                                    <th style="text-align: center;" class="table-danger">{{$totalPorPagar}} Bs</th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
@if (session('registrado') == 'ok')
<script>
    iziToast.success({
        title: 'SUCCESS',
        message: "Registro agregado exitosamente",
        position: 'topRight',
    });
</script>
@endif



@section('page_js')
<script>
    $('#table').DataTable({

        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningun dato disponible en esta tabla",
            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Ãšltimo",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            oAria: {
                sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                sSortDescending: ": Activar para ordenar la columna de manera descendente"
            }
        },
        columnDefs: [

        ]
    });
</script>
@endsection
@endsection