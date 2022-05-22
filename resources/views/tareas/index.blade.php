@extends('layouts.app', ['activePage' => 'tareas', 'titlePage' => 'Tareas'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Actividades Diarias</h3>

    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                @role('Super Admin') 
                        <a class="btn btn-info  float-right" href="{{ route('personales.reporteTareas') }}">Ver Actividades de Funcionarios</a>
                         @endrole 
                    <div class="card-body">
                        @role('Super Admin')
                        <a class="btn btn-outline-info" href="{{route('tareas.create')}}">Nueva Tarea</a><br><br>
                        @endrole
                        
                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;" class="text-center">#</th>
                                    <th style="color: #fff;" class="text-center">Nombre</th>
                                    <th style="color: #fff;" class="text-center">Cargo Tarea</th>
                                    <th style="color: #fff;" class="text-center">Turno</th>
                                    <th style="color: #fff;" class="text-center">Hora Inicio</th>
                                    <th style="color: #fff;" class="text-center">Hora Fin</th>
                                   
                                    
                                    <th style="color: #fff;"></th>
                                    <th style="color: #fff;"></th>


                                    <!-- <th style="color: #fff;">Acciones</th> -->
                                </thead>
                                <tbody>
                                    @foreach ($tareas as $tarea)
                                    <tr>
                                        <td class="text-center">{{$tarea->id}}</td>
                                        
                                        <td class="text-center">{{$tarea->nombre}}</td>
                                        <td class="text-center">{{$tarea->cargo->nombre_cargo}}</td>
                                        <td class="text-center">{{$tarea->turno}}</td>
                                        <td class="text-center">{{$tarea->hora_inicio}}</td>
                                        <td class="text-center">{{$tarea->hora_fin}}</td>
                                        <td></td>
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                                    <li>
                                                        <form action="{{route('tareas.destroy',$tarea->id)}}" id="formulario-eliminar2" class="formulario-eliminar" method="POST">
                                                            @csrf
                                                            @method('Delete')
                                                            <a class="dropdown-item" href="javascript:;" onclick="document.getElementById('formulario-eliminar2').submit()" id="enlace">Eliminar</a>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
@if(session('eliminar')=='ok')
<script>
    Swal.fire(
        'Eliminado!',
        'Tu registro ha sido eliminado.',
        'success'
    )
</script>
@endif
<script>
    $('.formulario-eliminar').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Estas Seguro(a)?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Eliminarlo!'
        }).then((result) => {
            if (result.value) {
                /*  Swal.fire(
                     'Deleted!',
                     'Your file has been deleted.',
                     'success'
                 ) */
                console.log(this);
                this.submit();
            }
        })
    });
</script>
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
        columnDefs: [{
                orderable: false,
                targets: 0
            },
            {
                orderable: false,
                targets: 6
            }
           
        ]
    });
</script>
@endsection
@endsection

@section('css')
.titulo{
font-size: 50px;
background-color: red;

}
@endsection