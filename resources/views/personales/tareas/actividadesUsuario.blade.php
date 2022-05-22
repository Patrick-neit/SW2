@extends('layouts.app',['activePage' => 'home', 'titlePage' => 'Home'])

@section('content')
    <section class="section">
       
        <div class="section-body">
            <div class="row">
              <div class="wizard">
                <div class="wizard-inner">
                  <div class="active-line"></div>
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active stepactive1">
                      <div class="connecting-line border-right"></div>
                      <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Ingreso">
                        <span class="round-tab">
                          <i class="fas fa-cloud-sun fa-lg"></i>
                        </span>
                        <p> INGRESO</p>
                      </a>
                    </li>
                    {{-- @role('Almacen')
                    <li role="presentation" class="disabled stepactive2">
                      <div class="connecting-line border-right border-left"></div>
                      <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Almacen">
                        <span class="round-tab">
                          <i class="fas fa-car-crash  fa-lg"></i>
                        </span>
                        <p>Despacho</p>
                      </a>
                    </li>
                    @endrole --}}
                    <li role="presentation" class="disabled stepactive2">
                      <div class="connecting-line border-right border-left"></div>
                      <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Pre Turno">
                        <span class="round-tab">
                          <i class="fas fa-sun"></i>
                        </span>
                        <p> PRE TURNO</p>
                      </a>
                    </li>
                    <li role="presentation" class="disabled stepactive3">
                      <div class="connecting-line border-right border-left"></div>
                      <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Turno">
                        <span class="round-tab">
                          <i class="fas fa-cloud-moon"></i>
                        </span>
                        <p>TURNO</p>
                      </a>
                    </li>
                    <li role="presentation" class="disabled stepactive4">
                      <div class="connecting-line"></div>
                      <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Post Turno">
                        <span class="round-tab">
                          <i class="fas fa-moon"></i>
                        </span>
                        <p>POST TURNO</p>
                      </a>
                      
                    </li>
                  </ul>
                </div>
                <form role="form">
                  <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                      <h3>Ingreso</h3>
                      <p>Actividades de  {{$user->name}},
                        @if(isset($user->tareas[0]))
                        {{$user->tareas[0]->cargo->nombre_cargo}}
                        @else
                        Sin cargo
                        @endif
                      </p>
                      <div class="section-body">
                        <h2 class="section-title"> {{$fecha}}</h2>
                    
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="activities">
                              @foreach ($user->tareas as $user_tarea)
                              @if ($user_tarea->turno === "Ingreso")
                    
                              <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                  <i class="fas fa-cloud-sun fa-lg"></i>
                                </div>
                    
                                <div class="activity-detail">
                                  <div class="mb-2">
                                    <span class="text-job text-success">Turno: {{$user_tarea->turno}}</span><br>
                                    <span class="text-job text-primary">Tarea: {{$user_tarea->nombre}}</span>
                                    <span class="bullet"></span>
                                    <a class="text-job" href="#">View</a>
                                    <div class="float-right dropdown">
                                      <a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                                      <div class="dropdown-menu">
                                        <div class="dropdown-title">Options</div>
                                        <a href="#" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                                        <a href="#" class="dropdown-item has-icon"><i class="fas fa-list"></i> Detail</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item has-icon text-danger trigger--fire-modal-1" data-confirm="Wait, wait, wait...|This action can't be undone. Want to take risks?" data-confirm-text-yes="Yes, IDC"><i class="fas fa-trash-alt"></i> Archive</a>
                                      </div>
                                    </div>
                                  </div>
                                  <p>Hora Asignada: {{$user_tarea->hora_inicio}} a: {{$user_tarea->hora_fin}}  <a href="#"> </a>".</p>
                                  <p>Hora realizada: {{$user_tarea->pivot->created_at->format('H:i:s')}} <a href="#"> </a>".</p>
                    
                                  @php
                    
                                  $diferencia = new DateTime();
                    
                                  $hora_asignada_inicio= $user_tarea->hora_inicio ;
                                  $hora_asignada_fin= $user_tarea->hora_fin ;
                    
                                  $hora_realizada = $user_tarea->created_at->format('H:i:s');
                    
                                  $fecha1 = new DateTime($hora_asignada_inicio);
                                  $fecha2 = new DateTime($hora_realizada);
                    
                                  $diferencia = date_diff($fecha1,$fecha2);
                                  @endphp
                    
                                  <p>Diferencia de Tiempo:<a href="#"> {{$diferencia->format('%H horas %i minutos ');}}</a>".</p>
                    
                                  @if($hora_realizada >= $hora_asignada_inicio && $hora_realizada <= $hora_asignada_inicio )
                                  <p style="color:green"> Dentro del rango</p>
                                  @else
                                  <p style="color:red">Fuera de horario</p>
                                  @endif
                    
                                </div>
                              </div>
                              @endif
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
    
                    </div>
                   {{--  @role('Almacen')
    
                    <div class="tab-pane active" role="tabpanel" id="step1">
                      <h3>Almacen</h3>
                      <p>Actividades de  {{$user->name}},
                        @if(isset($user->tareas[0]))
                        {{$user->tareas[0]->cargo->nombre_cargo}}
                        @else
                        Sin cargo
                        @endif
                      </p>
                      <div class="section-body">
                        <h2 class="section-title"> {{$fecha}}</h2>
                    
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="activities">
                              @foreach ($user->tareas as $user_tarea)
                              @if ($user_tarea->turno === "Ingreso")
                    
                              <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                  <i class="fas fa-cloud-sun fa-lg"></i>
                                </div>
                    
                                <div class="activity-detail">
                                  <div class="mb-2">
                                    <span class="text-job text-success">Turno: {{$user_tarea->turno}}</span><br>
                                    <span class="text-job text-primary">Tarea: {{$user_tarea->nombre}}</span>
                                    <span class="bullet"></span>
                                    <a class="text-job" href="#">View</a>
                                    <div class="float-right dropdown">
                                      <a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                                      <div class="dropdown-menu">
                                        <div class="dropdown-title">Options</div>
                                        <a href="#" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                                        <a href="#" class="dropdown-item has-icon"><i class="fas fa-list"></i> Detail</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item has-icon text-danger trigger--fire-modal-1" data-confirm="Wait, wait, wait...|This action can't be undone. Want to take risks?" data-confirm-text-yes="Yes, IDC"><i class="fas fa-trash-alt"></i> Archive</a>
                                      </div>
                                    </div>
                                  </div>
                                  <p>Hora Asignada: {{$user_tarea->hora_inicio}} a: {{$user_tarea->hora_fin}}  <a href="#"> </a>".</p>
                                  <p>Hora realizada: {{$user_tarea->pivot->created_at->format('H:i:s')}} <a href="#"> </a>".</p>
                    
                                  @php
                    
                                  $diferencia = new DateTime();
                    
                                  $hora_asignada_inicio= $user_tarea->hora_inicio ;
                                  $hora_asignada_fin= $user_tarea->hora_fin ;
                    
                                  $hora_realizada = $user_tarea->created_at->format('H:i:s');
                    
                                  $fecha1 = new DateTime($hora_asignada_inicio);
                                  $fecha2 = new DateTime($hora_realizada);
                    
                                  $diferencia = date_diff($fecha1,$fecha2);
                                  @endphp
                    
                                  <p>Diferencia de Tiempo:<a href="#"> {{$diferencia->format('%H horas %i minutos ');}}</a>".</p>
                    
                                  @if($hora_realizada >= $hora_asignada_inicio && $hora_realizada <= $hora_asignada_inicio )
                                  <p style="color:green"> Dentro del rango</p>
                                  @else
                                  <p style="color:red">Fuera de horario</p>
                                  @endif
                    
                                </div>
                              </div>
                              @endif
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
    
                    </div>
                    @endrole
     --}}
    
    
                    <div class="tab-pane" role="tabpanel" id="step2">
                      <h3>Pre Turno</h3>
                      
                      <p>Actividades de  {{$user->name}},
                        @if(isset($user->tareas[0]))
                        {{$user->tareas[0]->cargo->nombre_cargo}}
                        @else
                        Sin cargo
                        @endif
                      </p>
                      <div class="section-body">
                        <h2 class="section-title"> {{$fecha}}</h2>
                    
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="activities">
                              @foreach ($user->tareas as $user_tarea)
                              @if ($user_tarea->turno === "Pre Turno")
                    
                              <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                  <i class="fas fa-cloud-sun fa-lg"></i>
                                </div>
                    
                                <div class="activity-detail">
                                  <div class="mb-2">
                                    <span class="text-job text-success">Turno: {{$user_tarea->turno}}</span><br>
                                    <span class="text-job text-primary">Tarea: {{$user_tarea->nombre}}</span>
                                    <span class="bullet"></span>
                                    <a class="text-job" href="#">View</a>
                                    <div class="float-right dropdown">
                                      <a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                                      <div class="dropdown-menu">
                                        <div class="dropdown-title">Options</div>
                                        <a href="#" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                                        <a href="#" class="dropdown-item has-icon"><i class="fas fa-list"></i> Detail</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item has-icon text-danger trigger--fire-modal-1" data-confirm="Wait, wait, wait...|This action can't be undone. Want to take risks?" data-confirm-text-yes="Yes, IDC"><i class="fas fa-trash-alt"></i> Archive</a>
                                      </div>
                                    </div>
                                  </div>
                                  <p>Hora Asignada: {{$user_tarea->hora_inicio}} a: {{$user_tarea->hora_fin}}  <a href="#"> </a>".</p>
                                  <p>Hora realizada: {{$user_tarea->pivot->created_at->format('H:i:s')}} <a href="#"> </a>".</p>
                    
                                  @php
                    
                                  $diferencia = new DateTime();
                    
                                  $hora_asignada_inicio= $user_tarea->hora_inicio ;
                                  $hora_asignada_fin= $user_tarea->hora_fin ;
                    
                                  $hora_realizada = $user_tarea->created_at->format('H:i:s');
                    
                                  $fecha1 = new DateTime($hora_asignada_inicio);
                                  $fecha2 = new DateTime($hora_realizada);
                    
                                  $diferencia = date_diff($fecha1,$fecha2);
                                  @endphp
                    
                                  <p>Diferencia de Tiempo:<a href="#"> {{$diferencia->format('%H horas %i minutos ');}}</a>".</p>
                    
                                  @if($hora_realizada >= $hora_asignada_inicio && $hora_realizada <= $hora_asignada_inicio )
                                  <p style="color:green"> Dentro del rango</p>
                                  @else
                                  <p style="color:red">Fuera de horario</p>
                                  @endif
                    
                                </div>
                              </div>
                              @endif
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step3">
                      <h3>Turno</h3>
                      <p>Actividades de  {{$user->name}},
                        @if(isset($user->tareas[0]))
                        {{$user->tareas[0]->cargo->nombre_cargo}}
                        @else
                        Sin cargo
                        @endif
                      </p>
                      <div class="section-body">
                        <h2 class="section-title"> {{$fecha}}</h2>
                    
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="activities">
                              @foreach ($user->tareas as $user_tarea)
                              @if ($user_tarea->turno === "Turno")
                    
                              <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                  <i class="fas fa-cloud-sun fa-lg"></i>
                                </div>
                    
                                <div class="activity-detail">
                                  <div class="mb-2">
                                    <span class="text-job text-success">Turno: {{$user_tarea->turno}}</span><br>
                                    <span class="text-job text-primary">Tarea: {{$user_tarea->nombre}}</span>
                                    <span class="bullet"></span>
                                    <a class="text-job" href="#">View</a>
                                    <div class="float-right dropdown">
                                      <a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                                      <div class="dropdown-menu">
                                        <div class="dropdown-title">Options</div>
                                        <a href="#" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                                        <a href="#" class="dropdown-item has-icon"><i class="fas fa-list"></i> Detail</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item has-icon text-danger trigger--fire-modal-1" data-confirm="Wait, wait, wait...|This action can't be undone. Want to take risks?" data-confirm-text-yes="Yes, IDC"><i class="fas fa-trash-alt"></i> Archive</a>
                                      </div>
                                    </div>
                                  </div>
                                  <p>Hora Asignada: {{$user_tarea->hora_inicio}} a: {{$user_tarea->hora_fin}}  <a href="#"> </a>".</p>
                                  <p>Hora realizada: {{$user_tarea->pivot->created_at->format('H:i:s')}} <a href="#"> </a>".</p>
                    
                                  @php
                    
                                  $diferencia = new DateTime();
                    
                                  $hora_asignada_inicio= $user_tarea->hora_inicio ;
                                  $hora_asignada_fin= $user_tarea->hora_fin ;
                    
                                  $hora_realizada = $user_tarea->created_at->format('H:i:s');
                    
                                  $fecha1 = new DateTime($hora_asignada_inicio);
                                  $fecha2 = new DateTime($hora_realizada);
                    
                                  $diferencia = date_diff($fecha1,$fecha2);
                                  @endphp
                    
                                  <p>Diferencia de Tiempo:<a href="#"> {{$diferencia->format('%H horas %i minutos ');}}</a>".</p>
                    
                                  @if($hora_realizada >= $hora_asignada_inicio && $hora_realizada <= $hora_asignada_inicio )
                                  <p style="color:green"> Dentro del rango</p>
                                  @else
                                  <p style="color:red">Fuera de horario</p>
                                  @endif
                    
                                </div>
                              </div>
                              @endif
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    </div>
                    <div class="tab-pane" role="tabpanel" id="complete">
                      <h3>Post Turno</h3>
                      <p>Actividades de  {{$user->name}},
                        @if(isset($user->tareas[0]))
                        {{$user->tareas[0]->cargo->nombre_cargo}}
                        @else
                        Sin cargo
                        @endif
                      </p>
                      <div class="section-body">
                        <h2 class="section-title"> {{$fecha}}</h2>
                    
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="activities">
                              @foreach ($user->tareas as $user_tarea)
                              @if ($user_tarea->turno === "Post Turno")
                    
                              <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                  <i class="fas fa-cloud-sun fa-lg"></i>
                                </div>
                    
                                <div class="activity-detail">
                                  <div class="mb-2">
                                    <span class="text-job text-success">Turno: {{$user_tarea->turno}}</span><br>
                                    <span class="text-job text-primary">Tarea: {{$user_tarea->nombre}}</span>
                                    <span class="bullet"></span>
                                    <a class="text-job" href="#">View</a>
                                    <div class="float-right dropdown">
                                      <a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                                      <div class="dropdown-menu">
                                        <div class="dropdown-title">Options</div>
                                        <a href="#" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                                        <a href="#" class="dropdown-item has-icon"><i class="fas fa-list"></i> Detail</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item has-icon text-danger trigger--fire-modal-1" data-confirm="Wait, wait, wait...|This action can't be undone. Want to take risks?" data-confirm-text-yes="Yes, IDC"><i class="fas fa-trash-alt"></i> Archive</a>
                                      </div>
                                    </div>
                                  </div>
                                  <p>Hora Asignada: {{$user_tarea->hora_inicio}} a: {{$user_tarea->hora_fin}}  <a href="#"> </a>".</p>
                                  <p>Hora realizada: {{$user_tarea->pivot->created_at->format('H:i:s')}} <a href="#"> </a>".</p>
                                
                    
                                  @php
                    
                                  $diferencia = new DateTime();
                    
                                  $hora_asignada_inicio= $user_tarea->hora_inicio ;
                                  $hora_asignada_fin= $user_tarea->hora_fin ;
                    
                                  $hora_realizada = $user_tarea->pivot->created_at->format('H:i:s');
                    
                                  $fecha1 = new DateTime($hora_asignada_inicio);
                                  $fecha2 = new DateTime($hora_realizada);
                                 

                                  $diferencia = date_diff($fecha1,$fecha2);
                                  @endphp
                    
                                  <p>Diferencia de Tiempo:<a href="#"> {{$diferencia->format('%H horas %i minutos %s segundos ');}}</a>".</p>
                    
                                  @if($hora_realizada >= $hora_asignada_inicio && $hora_realizada <= $hora_asignada_fin )
                                  <p style="color:green"> Dentro del rango  <i class="fa fa-thumbs-o-up"></i> </p>
                                  @else
                                  <p style="color:red">Fuera de horario <i class="	fa fa-thumbs-down"></i>  </p>  
                                  @endif
                    
                                </div>
                              </div>
                              @endif
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>

                      <ul class="list-inline">
                        <li><button type="button" class="btn prev-step"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button></li>
                        <li><button type="button" class="btn btn-info-full next-step">Save and Submit</button></li>
                      </ul>
                     
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </form>
              </div>
                

            </div>
        </div>
    </section>
    @endsection

    @section('scripts')
    
    
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="custom.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
      $(document).ready(function () {
    $('.nav-tabs > li a[title]').tooltip();
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
    var $target = $(e.target);
    if ($target.parent().hasClass('disabled')) {
    return false;
    }
    });
    $(".next-step").click(function (e) {
    var $active = $('.wizard .nav-tabs li.active');
    $active.next().removeClass('disabled');
    nextTab($active);
    $('.wizard .nav-tabs li.active .connecting-line').css({"border-bottom-left-radius": 0, "border-top-left-radius": 0});
    });
    $(".prev-step").click(function (e) {
    var $active = $('.wizard .nav-tabs li.active');
    prevTab($active);
    });
    });
    function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
    }
    function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
    }
    </script>

@endsection



@section('page_css')
  <style>
    .wizard {
      background: #f1f1f1;
      padding: 30px;
    }

    .wizard .nav-tabs {
      position: relative;
      border: 0px;
    }

    .wizard>div.wizard-inner {
      position: relative;
    }

    .connecting-line {
      height: 15px;
      background: #e0e0e0;
      position: absolute;
      width: 99.5%;
      margin: 0 auto;
      left: 0;
      right: 0;
      top: 44%;
      z-index: 1;
      border-radius: 15px;
    }

    .active-line {
      height: 15px;
      background: #e0e0e0;
      position: absolute;
      width: 99.5%;
      margin: 0 auto;
      left: 0;
      right: 0;
      top: 44%;
      z-index: 1;
      border-radius: 15px !important;
    }

    .active .connecting-line {
      background-color: #2ED4E0;
    }

    .border-right {
      border-radius: 15px 0 0 15px;
    }

    .border-left {
      border-radius: 0;
    }

    .wizard .nav-tabs>li.active>a,
    .wizard .nav-tabs>li.active>a:hover,
    .wizard .nav-tabs>li.active>a:focus {
      cursor: default;
      border: 0;
      color: #2ED4E0;
      border-bottom-color: transparent;
    }

    .nav-tabs li p {
      padding-top: 70px;
      font-size: 16px;
      text-align: center;
    }

    .list-inline {
      text-align: center;
    }

    span.round-tab {
      width: 70px;
      height: 70px;
      line-height: 70px;
      display: inline-block;
      border-radius: 100px;
      background: #DFE3E4;
      border: 2px solid #fff;
      z-index: 1;
      position: absolute;
      text-align: center;
      font-size: 25px;
    }

    .wizard li.active span.round-tab {
      background: #2ED4E0;
      color: white;
      border: 2px solid #fff;
    }

    span.round-tab:hover {
      color: white;
      border: 2px solid #fff;
      background-color: #2ED4E0;
    }

    .wizard .nav-tabs>li {
      width: 25%;
    }

    .wizard .nav-tabs>li a {
      width: 70px;
      height: 70px;
      margin: 20px auto;
      border-radius: 100%;
      padding: 0;
      color: #777;
    }

    .wizard .tab-pane {
      position: relative;
      padding-top: 15px;
      border-top: 1px solid #fff;
      margin-top: 50px;
    }

    .next-step:hover,
    .next-step,
    .prev-step:hover,
    .prev-step {
      position: relative;
      background-color: #2ED4E0;
      font-size: 16px;
      color: #FFFFFF;
    }

    @media(min-width : 320px) and (max-width : 360px) {
      .wizard {
        width: 90%;
        height: auto !important;
      }

      span.round-tab {
        font-size: 16px;
        width: 50px;
        height: 50px;
        line-height: 50px;
      }

      .wizard .nav-tabs>li a {
        width: 50px;
        height: 50px;
      }

      .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 35%;
      }

      .next-step {
        margin-top: 10px;
      }

      .nav-tabs li p {
        padding-top: 60px;
        font-size: 16px;
        text-align: center;
      }

      .connecting-line,
      .active-line {
        top: 43%;
      }
    }
  </style>
@endsection

