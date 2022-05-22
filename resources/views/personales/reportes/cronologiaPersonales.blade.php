@extends('layouts.app', ['activePage' => 'personales', 'titlePage' => 'Personales'])

@section('css')
@endsection
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Cronologia de {{$user->name}} {{$user->apellido}}</h1>

    </div>
    <div class="section-body" id="experience">
        <div class="container">
            <div class="card">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-timeline">
                            @foreach ($data as $item )
                            <div class="timeline">
                                <div class="timeline-icon"><span class="year">{{ $item['nombre_mes'] }}</span></div>
                                <div class="timeline-content">
                                    <h3 class="title">Cronologia del Mes de {{ $item['nombre_mes'] }} </h3>

                                    @if ($item['sanciones']===0)
                                    <p class="description">
                                        Sin Sanciones
                                    </p>
                                    @else
                                    <p class="description">
                                        Nro de Sanciones Asignados {{$item['sanciones'];}}  <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modalSancion"> Ver</a>
                                    </p>

                                    @endif
                                    @if ($item['bonos']===0)
                                    <p class="description">
                                        Sin Bonos
                                    </p>
                                    @else
                                    <p class="description">
                                        Nro de Bonos Asignados {{ $item['bonos'];}}  <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modalBono"> Ver</a>
                                    </p>
                                    @endif
                                    @if ($item['descuentos']===0)
                                    <p class="description">
                                        Sin Descuentos
                                    </p>
                                    @else
                                    <p class="description">
                                        Nro de Descuentos Asignados {{$item['descuentos'];}}  <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modalGarante"> Ver</a>
                                    </p>
                                    @endif
                                    @if ($item['vacaciones']===0)
                                    <p class="description">
                                        Sin Vacaciones
                                    </p>
                                    @else
                                    <p class="description">
                                        Nro de Vacaciones Asignados {{$item['vacaciones'];}}  <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modalGarante"> Ver</a>
                                    </p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Modal Bonos -->
<div class="modal fade " id="modalBono" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLongTitle"> Bonos asignados al funcionario: {{ $user->name }} {{ $user->apellido}} </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <thead class="thead">
                        <tr>
                            <th scope="col" style="text-align: center;">Fecha</th>
                            <th scope="col" style="text-align: center;">Monto</th>
                            <th scope="col" style="text-align: center;">Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>

                        @foreach ($user->bonos as $bono)
                                    @php
                                   /*  echo($item['nombre_mes']); */

                                  /*   $fecha_mes = $item['nombre_mes'];
                                    $fecha_convertida = new DateTime($fecha_mes); */
                                 /*    $fecha_inicio = $fecha_mes->format('m'); */

                                    $fecha= $bono->fecha;
                                    $fecha_com = new DateTime($fecha);
                                    $fecha_fin = $fecha_com->format('m');
                                  /*   echo($fecha_inicio); */

                                    @endphp
                        @if ($fecha_fin == 5)

                        <tr>
                            <td class="text-center table-light"> {{$bono->fecha}} </td>
                            <td class="text-center">{{ $bono->monto }}</td>
                            <td class="text-center">{{ $bono->motivo }}</td>
                        </tr>

                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar </button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_css')

<link href="{{ asset('assets/css/personales/reportes/cronologias.css') }}" rel="stylesheet" type="text/css" />

@endsection
