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
                                        Nro de Bonos Asignados {{ $item['bonos'];}}  <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modalGarante"> Ver</a>
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
@endsection
@section('page_css')

<link href="{{ asset('assets/css/personales/reportes/cronologias.css') }}" rel="stylesheet" type="text/css" />

@endsection