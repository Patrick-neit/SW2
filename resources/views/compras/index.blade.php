@extends('layouts.app', ['activePage' => 'compras', 'titlePage' => 'Compras'])
@section('content')
@section('css')
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}" />
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Compras Registradas</h3>
    </div>
    <div class="section-body">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-outline-info" href="{{route('compras.create')}}">Nueva Compra</a>
                    <button class="btn btn-dark float-right" data-toggle="modal" data-target="#exampleModal2">Filtrar Compras</button>
                    <button class="btn btn-primary float-right mr-3" data-toggle="modal" data-target="#exampleModal1">Pagar</button>
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-striped mt-15 " id="table" style="width:100%">
                            <thead style="background-color: #6777ef;">
                                <tr>
                                    <th style="color: #fff;text-align: center;">Seleccionar</th>
                                    <th style="color: #fff;text-align: center;">Fecha Compra</th>
                                    <th style="color: #fff;text-align: center;">Sucursal </th>
                                    <th style="color: #fff;text-align: center;"> Proveedor</th>
                                    <th style="color: #fff;text-align: center;">Total Valor Compra</th>
                                    <th style="color: #fff;text-align: center;">Total Deuda</th>
                                    <th style="color: #fff;text-align: center;">Estado</th>
                                    <th style="color: #fff;text-align: center;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $total_compras = 0;
                                $total_deudas = 0;
                                $total_pagados= 0;
                                $longitud_compras = count($compras);
                                @endphp
                                <input type="hidden" id="compras_length" value="{{$longitud_compras}}">
                                <input type="hidden" id="compras" value="{{$compras}}">
                                @foreach($compras as $compra)
                                <tr>
                                    <td class="p-2 text-center col-auto">
                                        <div class="custom-checkbox">
                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control checkboxs" id="checkbox-{{$compra->id}}" value="{{$compra->id}}">
                                            <label for="checkbox-{{$compra->id}}" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    @php $fecha_formateada = date('d-m-Y', strtotime($compra->fecha_compra)); @endphp
                                    <td style="text-align: center;">{{$fecha_formateada}}</td>
                                    <td style="text-align: center;">{{$compra->sucursal->nombre}}</td>
                                    <td style="text-align: center;">
                                        @if (isset($compra->proveedor->nombre))
                                        {{$compra->proveedor->nombre}}
                                        @else
                                        Sin Proveedor
                                        @endif
                                    </td>
                                    <td style="text-align: center;">{{$compra->total}} Bs</td>
                                    <td style="text-align: center;">
                                        @php
                                        if($compra->estado=='P'){
                                        $deuda=0;
                                        }else{
                                        $deuda=$compra->total;
                                        }
                                        @endphp
                                        {{$deuda}} Bs
                                    </td>
                                    <input type="hidden" id="input-number-{{$compra->id}}" value="{{$deuda}}" class="form-control input-numbers" style="text-align: center;" readonly>
                                    <td style="text-align: center;">
                                        @if($compra->estado=='N')
                                        <div class="badge badge-pill badge-danger ">Sin Pagar</div>
                                        @endif
                                        @if($compra->estado=='P')
                                        <div class="badge badge-pill badge-success">Pagado</div>
                                        @endif
                                        @if($compra->estado=='D')
                                        <div class="badge badge-pill badge-warning">En Deuda</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown" style="position: absolute;">
                                            <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item " href="{{ route('compras.show', $compra->id) }}">Ver Detalle</a></li>

                                            </ul>
                                        </div>
                                    </td>
                                    @php
                                    $total_compras += $compra->total;
                                    $total_deudas += $deuda;
                                    @endphp
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <th class="table-primary"> Total Compras:</th>
                            <td class="table-primary">{{ number_format($total_compras,4)}} Bs</td>
                            <th class="table-success"> Total Pagado:</th>
                            <td class="table-success">{{ number_format($total_compras-$total_deudas,4)}} Bs</td>
                            <th class="table-danger"> Total Adeudado:</th>
                            <td class="table-danger">{{ number_format($total_deudas,4) }} Bs</td>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>
<div class="modal hide fade in" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese los datos</h5>
                <button type="button" class="close" id="cerrar_modal1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pagos.store') }}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="banco" class="col-form-label">Banco</label>
                                <input type="text" class="form-control" id="banco" name="banco" placeholder="Banco...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nro_cuenta" class="col-form-label">Nro de Cuenta</label>
                                <input type="number" class="form-control" id="nro_cuenta" name="nro_cuenta" placeholder="Nro de Cuenta...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nro_comprobante" class="col-form-label">Nro de Comprobante</label>
                                <input type="number" class="form-control" id="nro_comprobante" name="nro_comprobante" placeholder="Nro de Comprobante...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nro_cheque" class="col-form-label">Nro de Cheque</label>
                                <input type="number" class="form-control" id="nro_cheque" name="nro_chenque" placeholder="Nro de Cheque...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_pago">Tipo de Pago*</label>
                                <select name="tipo_pago" class="form-select" id="tipo_pago" readonly>
                                    <option value="cheque">Cheque</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" id="pagar">Registrar Pago</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal hide fade in" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModal2Label">Ingrese los datos</h5>
                <button type="button" class="close" id="cerrar_modal2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('compras.filtrarCompras')}}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="datepicker">Seleccione las Fechas</label>
                            <div class=" input-group" id="datepicker">
                                <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                                <span class="input-group-addon">A</span>
                                <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="">
                            <div class="form-group">
                                <label for="proveedor">Seleccione el Proveedor</label>
                                <select name="proveedor_id" id="proveedor_id" class="form-control" style="width: 100%;">
                                    <option value="">Seleccionar Proveedor</option>
                                    @foreach ($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="sucursal">Seleccione la Sucursal</label>
                                <select name="sucursal_id" id="sucursal_id" class="form-select" style="width: 100%;">
                                    <option value=""> Seleccionar Sucursal</option>
                                    @foreach ($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="filtrar_compras">Filtrar Compras</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<script type="text/javascript" src="{{ URL::asset('assets/js/compras/index.js') }}"></script>
<script>
    let ruta_filtrarCompras = "{{ route('compras.filtrarCompras') }}";
</script>

@if(session('compra_realizada')=='ok')
@php
session()->forget('compra_realizada')
@endphp
<script>
    iziToast.success({
        title: 'SUCCESS',
        message: "Compra realizada exitosamente",
        position: 'topRight',
    });
</script>

@endif

<script>
    let _compras = document.getElementById("compras").value;
    let Json_compras = JSON.parse(_compras);

    /* let compras_marcadas1 = []
    let compras_indices = []
    for (let i in chekboxs) {
        chekboxs[i].addEventListener("click", (e) => {

            if (chekboxs[i].checked == true) {
                compras_marcadas1.push(parseInt(i));
                compras_indices.push(Json_compras[i].id);
            } else {
                let index_compras = compras_marcadas1.indexOf(parseInt(i));
                let index_compras2 = compras_indices.indexOf(parseInt(i));
                compras_marcadas1.splice(index_compras, 1);
                compras_indices.splice(index_compras2, 1);
            }
        })
    } */
</script>

<script>


</script>

<script>
    let chekboxs = document.getElementsByClassName("custom-control checkboxs");
    let inputs_numbers = document.getElementsByClassName("input-numbers");

    console.log(inputs_numbers);

    let pagar = document.getElementById("pagar");
    pagar.addEventListener("click", (e) => {
        let input_pagos = [];
        let comprasid = [];
        let input_pagos1 = [];

        for (let i in chekboxs) {
            console.log(chekboxs[i])
            if (chekboxs[i].checked == true) {
                comprasid.push(parseInt(chekboxs[i].value));
                input_pagos1.push(inputs_numbers[i].value)
            }
        }
        console.log(comprasid)

        let ruta_pago = "{{ route('pagos.store') }}";
        fetch(ruta_pago, {
                method: "POST",
                body: JSON.stringify({
                    banco: $("#banco").val(),
                    nro_cuenta: $("#nro_cuenta").val(),
                    nro_comprobante: $("#nro_comprobante").val(),
                    nro_cheque: $("#nro_cheque").val(),
                    tipo_pago: $("#tipo_pago").val(),
                    compras_id: comprasid,
                    pagos: input_pagos1,
                }),
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": csrfToken,
                },
            })
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                if (data.success == true) {
                    window.location.href = "{{ route('compras.index') }}";
                }

            })
            .catch((error) => console.error(error));
        input_pagos = [];
    });
</script>
<script>
    $(document).ready(function() {
        $('#proveedor_id').select2({
            width: 'resolve',
            dropdownParent: $("#exampleModal2")
        });
        $('#sucursal_id').select2({
            width: 'resolve',
            dropdownParent: $("#exampleModal2")
        });
    });
</script>
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
        columnDefs: [{
            orderable: false,
            targets: 7
        }]
    });
</script>


@endsection
@section('css')
<style>
    .table {
        width: 100%;
    }

    [data-bs-toggle="collapse"] .fa:before {

        content: "\f13a";
    }

    [data-bs-toggle="collapse"].collapsed .fa:before {
        content: "\f139";
    }
</style>
@endsection