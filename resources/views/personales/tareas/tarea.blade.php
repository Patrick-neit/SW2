@extends('layouts.app', ['activePage' => 'tareas', 'titlePage' => 'Tareas'])

@section('content')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">

@endsection
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Actividades de: {{$user->name}} {{$user->apellido}} </h3>
    </div>
    <div class="section-body">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center p-0 mt-3 mb-2">
                                <div class=" px-0 pt-4 pb-0 mt-3 mb-3">
                                    <h2 id="heading"> Mis tareas diarias </h2><br>
                                    <form action="{{ route('personales.saveTareas',$user->id)}}" method="POST" class="form-horizontal">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" class="form-control" id="pivot" name="pivot[]" value="{{$pivote}}">
                                        <!-- progressbar -->
                                        <ul id="progressbar">
                                            <li class="active" id="account"><strong>Ingreso</strong></li>
                                            <li id="personal"><strong>Preturno</strong></li>
                                            @role('Almacen')
                                            <li id="almacen"><strong>Despacho</strong></li>
                                            @endrole('Almacen')
                                            <li id="payment"><strong>Turno</strong></li>
                                            <li id="confirm"><strong>PosTurno</strong></li>
                                        </ul>
                                        <!-- <div class="progress">
                                            <div class="progress-bar bg-primary  progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div> -->
                                        <br>
                                        <!-- fieldsets -->
                                        <fieldset>
                                            <div class="form-card">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Tareas de Ingreso:</h2> 
                                                    </div>
                                                    <div class="col-5">
                                                        @php
                                                        $porcen=0;
                                                        $_registros = [ ];
                                                        if(isset($pivote[0]->tarea)){
                                                        foreach ($pivote as $pivot ){
                                                        if ($pivot->tarea->turno === "Ingreso" ) {
                                                        array_push($_registros,$pivot->tarea->turno);
                                                        }
                                                        }
                                                        }

                                                        $_cantidad_ingreso=0;
                                                        foreach($tareas as $tarea){
                                                        if($tarea->turno==="Ingreso"){
                                                        $_cantidad_ingreso++;
                                                        }
                                                        }
                                                        $cantidad_cumplimiento = sizeof($_registros);

                                                        if($_cantidad_ingreso===0){
                                                        $porcen=0;
                                                        }else{
                                                        $porcen= number_format($cantidad_cumplimiento*100/$_cantidad_ingreso,0);
                                                        }
                                                        @endphp
                                                        
                                                        @if($porcen < 20) 
                                                            <p class="porcentaje" style="color:red;"> Cumplimiento: {{$porcen}} % </p>
                                                        @elseif($porcen < 70) 
                                                            <p class="porcentaje"> Cumplimiento: {{$porcen}} % </p>
                                                        @elseif($porcen = 100)
                                                            <p class="porcentaje" style="color:green;"> Cumplimiento: {{$porcen}} % </p>
                                                        @endif <br>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="table-responsive-md ">
                                                        <table class="table table-striped ">
                                                            <thead>
                                                                <th class="text-center"> Hora asignada</th>
                                                                <th class="text-center"> Actividad</th>
                                                                <th class="text-center"> Estado</th>
                                                            </thead>
                                                            @foreach ($tareas as $tarea)
                                                            @php $hora_formateada = date('H:i', strtotime($tarea->hora_inicio)); @endphp
                                                            @php $hora_formateada_fin = date('H:i', strtotime($tarea->hora_fin)); @endphp
                                                            @if($tarea->turno==="Ingreso")
                                                            <tbody>
                                                            {!! Form::model($user ,['route' => ['personales.saveTareas',$user], 'method' => 'post']) !!}
                                                                <td class="text-center">  {{$hora_formateada}} a: {{$hora_formateada_fin}} </td>
                                                                <td class="text-center"> {{ $tarea->nombre }}</td>    
                                                                <td class="text-center">  {!! Form::checkbox('tareas[]', $tarea->id, null, ['class' => 'form-check-control ']) !!}</td>                      
                                                            </tbody>
                                                            @endif  
                                                            @endforeach 
                                                        </table>
                                                    </div>
                                                </div>


                                            </div>
                                            <input type="button" name="next" class="next action-button" value="Siguiente" />
                                            <input type="submit" name="next" class="previous action-button-submit" value="Guardar" />
                                        </fieldset>
                                        <fieldset style=" display: none;">
                                            <div class="form-card">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Tareas de Pre Turno:</h2>
                                                    </div>
                                                    <div class="col-5">
                                                        @php
                                                        $_registros = [ ];
                                                        $porcen=0;

                                                        if(isset($pivote[0]->tarea)){
                                                        foreach ($pivote as $pivot ){
                                                        if ($pivot->tarea->turno === "Pre Turno" ) {
                                                        array_push($_registros,$pivot->tarea->turno);
                                                        }
                                                        }
                                                        }

                                                        $_cantidad_ingreso=0;
                                                        foreach($tareas as $tarea){
                                                        if($tarea->turno==="Pre Turno"){
                                                        $_cantidad_ingreso++;
                                                        }
                                                        }
                                                        $cantidad_cumplimiento = sizeof($_registros);
                                                        if($_cantidad_ingreso===0){
                                                        $porcen=0;
                                                        }else{
                                                        $porcen= number_format($cantidad_cumplimiento*100/$_cantidad_ingreso,0);
                                                        }
                                                        @endphp
                                                        @if($porcen < 20) <h6 class="steps" style="color:red;"> Cumplimiento: {{$porcen}} % </h6>
                                                            @elseif($porcen < 70) <h6 class="steps"> Cumplimiento: {{$porcen}} % </h6>
                                                                @elseif($porcen = 100)
                                                                <h6 class="steps" style="color:green;"> Cumplimiento: {{$porcen}} % </h6>
                                                                @endif <br>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="table-responsive-md ">
                                                        <table class="table table-striped ">
                                                            <thead>
                                                                <th class="text-center"> Hora asignada</th>
                                                                <th class="text-center"> Actividad</th>
                                                                <th class="text-center"> Estado</th>
                                                            </thead>
                                                            @foreach ($tareas as $tarea)
                                                            @php $hora_formateada = date('H:i', strtotime($tarea->hora_inicio)); @endphp
                                                            @php $hora_formateada_fin = date('H:i', strtotime($tarea->hora_fin)); @endphp
                                                            @if($tarea->turno==="Pre Turno")
                                                            <tbody>
                                                            {!! Form::model($user ,['route' => ['personales.saveTareas',$user], 'method' => 'post']) !!}
                                                                <td class="text-center">  {{$hora_formateada}} a: {{$hora_formateada_fin}} </td>
                                                                <td class="text-center"> {{ $tarea->nombre }}</td>    
                                                                <td class="text-center">  {!! Form::checkbox('tareas[]', $tarea->id, null, ['class' => 'form-check-control ']) !!}</td>                      
                                                            </tbody>
                                                            @endif  
                                                            @endforeach 
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                            
                                            <input type="button" name="next" class="next action-button" value="Siguiente" />
                                            <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                                            <input type="submit" name="next" class="action-button-submit" value="Guardar" />
                                        </fieldset>
                                        @role('Almacen')
                                        <fieldset style=" display: none;">
                                            <div class="form-card">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Tareas de Despacho:</h2>
                                                    </div>
                                                    <div class="col-5">
                                                        @php
                                                        $_registros = [ ];
                                                        $porcen=0;

                                                        if(isset($pivote[0]->tarea)){
                                                        foreach ($pivote as $pivot ){
                                                        if ($pivot->tarea->turno === "Despacho" ) {
                                                        array_push($_registros,$pivot->tarea->turno);
                                                        }
                                                        }
                                                        }

                                                        $_cantidad_ingreso=0;
                                                        foreach($tareas as $tarea){
                                                        if($tarea->turno==="Despacho"){
                                                        $_cantidad_ingreso++;
                                                        }
                                                        }
                                                        $cantidad_cumplimiento = sizeof($_registros);
                                                        if($_cantidad_ingreso===0){
                                                        $porcen=0;
                                                        }else{
                                                        $porcen= number_format($cantidad_cumplimiento*100/$_cantidad_ingreso,0);
                                                        }
                                                        @endphp
                                                        @if($porcen < 20) <h6 class="steps" style="color:red;"> Cumplimiento: {{$porcen}} % </h6>
                                                            @elseif($porcen < 70) <h6 class="steps"> Cumplimiento: {{$porcen}} % </h6>
                                                                @elseif($porcen = 100)
                                                                <h6 class="steps" style="color:green;"> Cumplimiento: {{$porcen}} % </h6>
                                                                @endif <br>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="table-responsive-md ">
                                                        <table class="table table-striped ">
                                                            <thead>
                                                                <th class="text-center"> Hora asignada</th>
                                                                <th class="text-center"> Actividad</th>
                                                                <th class="text-center"> Estado</th>
                                                            </thead>
                                                            @foreach ($tareas as $tarea)
                                                            @php $hora_formateada = date('H:i', strtotime($tarea->hora_inicio)); @endphp
                                                            @php $hora_formateada_fin = date('H:i', strtotime($tarea->hora_fin)); @endphp
                                                            @if($tarea->turno==="Despacho")
                                                            <tbody>
                                                            {!! Form::model($user ,['route' => ['personales.saveTareas',$user], 'method' => 'post']) !!}
                                                                <td class="text-center">  {{$hora_formateada}} a: {{$hora_formateada_fin}} </td>
                                                                <td class="text-center"> {{ $tarea->nombre }}</td>    
                                                                <td class="text-center">  {!! Form::checkbox('tareas[]', $tarea->id, null, ['class' => 'form-check-control ']) !!}</td>                      
                                                            </tbody>
                                                            @endif  
                                                            @endforeach 
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                            
                                            <input type="button" name="next" class="next action-button" value="Siguiente" />
                                            <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                                            <input type="submit" name="next" class="action-button-submit" value="Guardar" />
                                        </fieldset>
                                        @endrole                  
                                        <fieldset style="display: none;">
                                            <div class="form-card">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Tareas de Turno:</h2>
                                                    </div>
                                                    <div class="col-5">
                                                        @php
                                                        $_registros = [ ];
                                                        $porcen=0;

                                                        if(isset($pivote[0]->tarea)){
                                                        foreach ($pivote as $pivot ){
                                                        if ($pivot->tarea->turno === "Turno" ) {
                                                        array_push($_registros,$pivot->tarea->turno);
                                                        }
                                                        }
                                                        }

                                                        $_cantidad_ingreso=0;
                                                        foreach($tareas as $tarea){
                                                        if($tarea->turno==="Turno"){
                                                        $_cantidad_ingreso++;
                                                        }
                                                        }
                                                        $cantidad_cumplimiento = sizeof($_registros);
                                                        if($_cantidad_ingreso===0){
                                                        $porcen=0;
                                                        }else{
                                                        $porcen= number_format($cantidad_cumplimiento*100/$_cantidad_ingreso,0);
                                                        }
                                                        @endphp
                                                        @if($porcen < 20) <h6 class="steps" style="color:red;"> Cumplimiento: {{$porcen}} % </h6>
                                                            @elseif($porcen < 70) <h6 class="steps"> Cumplimiento: {{$porcen}} % </h6>
                                                                @elseif($porcen = 100)
                                                                <h6 class="steps" style="color:green;"> Cumplimiento: {{$porcen}} % </h6>
                                                                @endif <br>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="table-responsive-md ">
                                                        <table class="table table-striped ">
                                                            <thead>
                                                                <th class="text-center"> Hora asignada</th>
                                                                <th class="text-center"> Actividad</th>
                                                                <th class="text-center"> Estado</th>
                                                            </thead>
                                                            @foreach ($tareas as $tarea)
                                                            @php $hora_formateada = date('H:i', strtotime($tarea->hora_inicio)); @endphp
                                                            @php $hora_formateada_fin = date('H:i', strtotime($tarea->hora_fin)); @endphp
                                                            @if($tarea->turno==="Turno")
      
                                                            <tbody>
                                                            {!! Form::model($user ,['route' => ['personales.saveTareas',$user], 'method' => 'post']) !!}
                                                                <td class="text-center">  {{$hora_formateada}} a: {{$hora_formateada_fin}} </td>
                                                                <td class="text-center"> {{ $tarea->nombre }}</td>    
                                                                <td class="text-center">  {!! Form::checkbox('tareas[]', $tarea->id, null, ['class' => 'form-check-control ']) !!}</td>                      
                                                            </tbody>
                                                            @endif  
                                                            @endforeach 
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="button" name="next" class="next action-button" value="Siguiente" />
                                            <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                                            <input type="submit" name="next" class="next action-button-submit" value="Guardar" />
                                        </fieldset>
                                        <fieldset style="display: none;">
                                            <div class="form-card">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Tareas de PosTurno:</h2>
                                                    </div>
                                                    <div class="col-5">
                                                        @php
                                                        $_registros = [ ];

                                                        if(isset($pivote[0]->tarea)){
                                                        foreach ($pivote as $pivot ){
                                                        if ($pivot->tarea->turno === "Post Turno" ) {
                                                        array_push($_registros,$pivot->tarea->turno);
                                                        }
                                                        }
                                                        }

                                                        $_cantidad_ingreso=0;
                                                        foreach($tareas as $tarea){
                                                        if($tarea->turno==="Post Turno"){
                                                        $_cantidad_ingreso++;
                                                        }
                                                        }
                                                        $cantidad_cumplimiento = sizeof($_registros);
                                                        if($_cantidad_ingreso===0){
                                                        $porcen=0;
                                                        }else{
                                                        $porcen= number_format($cantidad_cumplimiento*100/$_cantidad_ingreso,0);
                                                        }
                                                        @endphp
                                                        @if($porcen < 20) <h6 class="steps" style="color:red;"> Cumplimiento: {{$porcen}} % </h6>
                                                            @elseif($porcen < 70) <h6 class="steps"> Cumplimiento: {{$porcen}} % </h6>
                                                                @elseif($porcen = 100)
                                                                <h6 class="steps" style="color:green;"> Cumplimiento: {{$porcen}} % </h6>
                                                                @endif <br>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="table-responsive-md ">
                                                        <table class="table table-striped ">
                                                            <thead>
                                                                <th class="text-center"> Hora asignada</th>
                                                                <th class="text-center"> Actividad</th>
                                                                <th class="text-center"> Estado</th>
                                                            </thead>
                                                            @foreach ($tareas as $tarea)
                                                            @php $hora_formateada = date('H:i', strtotime($tarea->hora_inicio)); @endphp
                                                            @php $hora_formateada_fin = date('H:i', strtotime($tarea->hora_fin)); @endphp
                                                            @if($tarea->turno==="Post Turno")
                                                            <tbody>
                                                            {!! Form::model($user ,['route' => ['personales.saveTareas',$user], 'method' => 'post']) !!}
                                                                <td class="text-center">  {{$hora_formateada}} a: {{$hora_formateada_fin}} </td>
                                                                <td class="text-center"> {{ $tarea->nombre }}</td>    
                                                                <td class="text-center">  {!! Form::checkbox('tareas[]', $tarea->id, null, ['class' => 'form-check-control ']) !!}</td>                      
                                                            </tbody>
                                                            @endif  
                                                            @endforeach 
                                                        </table>
                                                    </div>
                                                        
                                                    </div>
                                                </div>
                                                <input type="submit" name="next" class="next action-button-submit" value="Guardar" />
                                                <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                                                <br><br>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection
@section('scripts')

<script>
    let checkbox = document.getElementsByClassName("form-check-control");
    let pivot = $('#pivot').val();
    let Json_pivot = JSON.parse(pivot);
    console.log(Json_pivot)
    arrayCheckBox = []
    arrayIndex = []

    $(".form-check-control").attr('checked', false);
    $(".form-check-control").attr('disabled', false);

    if (Json_pivot === 0) {
        $(".form-check-control").attr('checked', false);
        $(".form-check-control").attr('disabled', false);
    }
    for (let i in checkbox) {
        if (checkbox[i].value != undefined) {
            arrayCheckBox.push(checkbox[i].value)
            arrayIndex.push(i)
        }
    }
    //console.log(arrayCheckBox)
    for (let j in Json_pivot) {
        for (let i in arrayCheckBox) {
            if (arrayCheckBox[i] == Json_pivot[j].tarea_id) {
                console.log(checkbox[i].value)
                checkbox[i].checked = true;
                checkbox[i].disabled = true;
            }
        }
    }
</script>
<script>
    $(document).ready(function() {

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        var current = 1;
        var steps = $("fieldset").length;

        setProgressBar(current);

        $(".next").click(function() {

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
            setProgressBar(++current);
        });

        $(".previous").click(function() {

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
            setProgressBar(--current);
        });

        function setProgressBar(curStep) {
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar")
                .css("width", percent + "%")
        }

        $(".submit").click(function() {
            return false;
        })

    });
</script>

@endsection
@section('page_css')
<style>

    input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.1); /* IE */
  -moz-transform: scale(1.1); /* FF */
  -webkit-transform: scale(1.1); /* Safari and Chrome */
  -o-transform: scale(1.1); /* Opera */
  padding: 10px;
}

 .cumplimiento {
        background-color: lightgray;
        border-radius: 1.25em;
        width: 300px;
        height: 16px;
        width: 50vw;
    }

    .cumplimiento>span {
        display: flex;
    }

    .progress-value {
        background-color: #6777ef;
        transition: 0.3s all linear;
        border-radius: 1.25em;
        height: 16px;
        width: 50vw;
        animation: progress-color 1s linear forwards;
        -webkit-animation: progress-color 1s linear forwards;
    }

    /* animation */
    @keyframes progress-color {
        0% {
            width: 0;
        }

        50% {
            width: 70%;
            background: purple;
        }

        100% {
            width: 100%;
            background: green;
        }
    }

    .mensaje {
        font-size: 85%;
    }


    * {
        margin: 0;
        padding: 0;
    }

    html {
        height: 100%;
    }

    p {
        color: grey;
    }

    #heading {
        text-transform: uppercase;
        color: #6777ef;
        font-weight: normal;
    }

    #msform {
        text-align: center;
        position: relative;
        margin-top: 20px;
    }

    #msform fieldset {
        background: white;
        border: 0 none;
        border-radius: 0.5rem;
        box-sizing: border-box;
        width: 100%;
        margin: 0;
        padding-bottom: 20px;

        /*stacking fieldsets above each other*/
        position: relative;
    }

    .form-card {
        text-align: left;
    }

    /*Hide all except first fieldset*/
    #msform fieldset:not(:first-of-type) {
        display: none;
    }

    #input,
    #textarea {
        padding: 8px 15px 8px 15px;
        border: 1px solid #ccc;
        border-radius: 0px;
        margin-bottom: 25px;
        margin-top: 2px;
        width: 100%;
        box-sizing: border-box;
        font-family: montserrat;
        color: #2C3E50;
        background-color: #ECEFF1;
        font-size: 16px;
        letter-spacing: 1px;
    }

    .input:focus,
    .textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: 1px solid #673AB7;
        outline-width: 0;
    }

    /*Next Buttons*/
    .action-button {
        width: 100px;
        background: #6777ef;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 0px 10px 5px;
        float: right;
    }

    .action-button:hover,
    .action-button:focus {
        background-color: #311B92;
    }

    /*Previous Buttons*/
    .action-button-previous {
        width: 100px;
        background: #616161;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px 10px 0px;
        float: right;
    }
    .action-button-previous:hover,
    .action-button-previous:focus {
        background-color: #000000;
    }

    .action-button-submit {
        width: 100px;
        background: green;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px 10px 0px;
        float: right;
    }

    .action-button-submit:hover,
    .action-button-submit:focus {
        background-color: #2E9F1A;
    }

    /*The background card*/
    .card {
        z-index: 0;
        border: none;
        position: relative;
    }

    /*FieldSet headings*/
    .fs-title {
        font-size: 25px;
       
        margin-bottom: 15px;
        font-weight: normal;
        text-align: left;
    }

    .purple-text {
        color:  #6777ef;
        font-weight: normal;
    }

    /*Step Count*/
    .steps {
        font-size: 20px;
        color: gray;
        margin-bottom: 10px;
        font-weight: normal;
        text-align: right;
    }
    .porcentaje{
        font-size: 20px;
        color: gray;
        margin-bottom: 10px;
        font-weight: normal;
        text-align: right;

    }

    /*Field names*/
    .fieldlabels {
        color: gray;
        text-align: left;
    }

    /*Icon progressbar*/
    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: lightgrey;
    }

    #progressbar .active {
        color: #6777ef;
        
    }

    #progressbar li {
        list-style-type: none;
        font-size: 15px;
        width: 20%;
        float: left;
        position: relative;
        font-weight: 400;
    }

    /*Icons in the ProgressBar*/
    #progressbar #account:before {
        font-family: FontAwesome;
        content: "\f0c2";
    }

    #progressbar #personal:before {
        font-family: FontAwesome;
        content: "\f0a1";
      
    }
    #progressbar #almacen:before {
        font-family: FontAwesome;
        content: "\f0b1";
      
    }

    #progressbar #payment:before {
        font-family: FontAwesome;
        content: "\f185";
    }

    #progressbar #confirm:before {
        font-family: FontAwesome;
        content: "\f0ee";  
    }

    /*Icon ProgressBar before any progress*/
    #progressbar li:before {
        width: 50px;
        height: 50px;
        line-height: 45px;
        display: block;
        font-size: 20px;
        color: #ffffff;
        background: lightgray;
        border-radius: 50%;
        margin: 0 auto 10px auto;
        padding: 2px;
    }

    /*ProgressBar connectors*/
    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: lightgray;
        position: absolute;
        left: 0;
        top: 25px;
        z-index: -1;
    }

    /*Color number of the step and the connector before it*/
    #progressbar li.active:before{
        background: linear-gradient(to right, #96c93d, #00b09b);
        
    }

    #progressbar li.active:after {
       /*  background: #6777ef; */
       background: #00b09b;

    }

    /*Animated Progress Bar*/
    .progress {
        height: 20px;
    }

    .progress-bar {
        background-color: #6777ef;
    }

    /*Fit image in bootstrap div*/
    .fit-image {
        width: 100%;
        object-fit: cover;
    }
</style>
@endsection