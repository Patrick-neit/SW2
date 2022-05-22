<?php

namespace App\Http\Controllers;

use App\Models\Bono;
use App\Models\Cargo;
use App\Models\CategoriaSancion;
use App\Models\CargoSucursal;
use App\Models\Categoria;
use App\Models\Contrato;
use App\Models\Descuento;
use App\Models\DetalleContrato;
use App\Models\Educacion;
use App\Models\ExperienciaLaboral;
use App\Models\Habilidad;
use App\Models\RegistroTarea;
use App\Models\Sucursal;
use App\Models\Sanciones;
use App\Models\Tarea;
use App\Models\TareaUser;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserTarea;
use App\Models\Vacacion;
use COM;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use LaraIzitoast\Toaster;
use LaraIzitoast\LaraIzitoastServiceProvider;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{


    public function index()
    {
        $personales = User::all();

        return view('personales.index', compact('personales'));
    }

    public function create()
    {
        $correo = 'donesco@gmail.com';
        $user_cod = rand(10000, 99999);
        $sucursales = Sucursal::all();
        $contratos = Contrato::all();
        return view('personales.create', compact('sucursales', 'contratos', 'user_cod', 'correo'));
    }
    public function showDetalleContrato($id)
    {
        $user = User::find($id);
        $detalleContratos = DetalleContrato::where('user_id', $id)->get();

        return view('personales.show', compact('user', 'detalleContratos'));
    }




    public function contratar(Request $request)
    {
        /* dd($request); */
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'fecha_nacimiento' => 'required',
            'carnet_identidad' => 'required',
            'domicilio' => 'required',
            'zona' => 'required',
            'nro_celular_personal' => 'required',
            'fecha_inicio_contrato' => 'required',
            'fecha_fin_contrato' => 'required',
            'codigo' => 'unique:users|max:5',
        ]);

        $contratar_personal = new User();
        $contratar_personal->email = $request->get('email');
        $contratar_personal->name = $request->get('nombre');
        $contratar_personal->apellido = $request->get('apellido');
        $contratar_personal->fecha_nacimiento = $request->get('fecha_nacimiento');
        $contratar_personal->ci = $request->get('carnet_identidad');
        $contratar_personal->domicilio = $request->get('domicilio');
        $contratar_personal->zona = $request->get('zona');
        $contratar_personal->celular_personal = $request->get('nro_celular_personal');
        $contratar_personal->celular_referencia = $request->get('nro_celular_referencia');
        $contratar_personal->password = '12345678';
        $contratar_personal->estado = 1;
        $contratar_personal->codigo =  $request->get('codigo');
        $contratar_personal->tipo_usuario_id =  2;
        if ($request->hasFile("foto")) {
            $file = $request->file('foto');
            $destinationPath = 'img/contratos/';
            $filename = time() . '-' . $file->getClientOriginalName();
            $uploadSuccess = $request->file('foto')->move($destinationPath, $filename);
            $contratar_personal->foto = $destinationPath . $filename;
        }
        $contratar_personal->save();


        if ($contratar_personal->save()) {
            for ($i = 0; $i < sizeof($request->habilidades); $i++) {
                if ($request->habilidades[$i] != "") {
                    Habilidad::create([
                        'habilidad' => $request->habilidades[$i],
                        'user_id' => $contratar_personal->id,
                    ]);
                }
            }
            for ($j = 0; $j < sizeof($request->nombre_empresas); $j++) {
                if ($request->cargos[$j] != "" && $request->nombre_empresas[$j] != "") {
                    ExperienciaLaboral::create([
                        'cargo' => $request->cargos[$j],
                        'nombre_empresa' => $request->nombre_empresas[$j],
                        'descripcion' => $request->descripciones[$j],
                        'user_id' => $contratar_personal->id,
                    ]);
                }
            }
            for ($j = 0; $j < sizeof($request->instituciones); $j++) {
                if ($request->instituciones[$j] != "" && $request->carreras[$j] != "" && $request->fecha_inicio_educacion[$j] != "" && $request->fecha_fin_educacion[$j] != "") {
                    Educacion::create([
                        'nombre_institucion' => $request->instituciones[$j],
                        'nombre_carrera' => $request->carreras[$j],
                        'fecha_inicio_educacion' => $request->fecha_inicio_educacion[$j],
                        'fecha_fin_educacion' => $request->fecha_fin_educacion[$j],
                        'user_id' => $contratar_personal->id,
                    ]);
                }
            }

            DetalleContrato::create([
                'fecha_inicio_contrato' => $request->fecha_inicio_contrato,
                'fecha_fin_contrato' => $request->fecha_fin_contrato,
                'disponibilidad' => $request->disponibilidad,
                'contrato_id' => $request->contrato_id,
                'user_id' =>  $contratar_personal->id,
            ]);
        }
        return redirect()->route('personales.index')->with('contratar', 'ok');
    }

    public function actualizarContratoUser(Request $request)
    {
        $request->validate([
            'fecha_inicio_contrato' => 'required',
            'fecha_fin_contrato' => 'required',
        ]);
        $detalleContrato = new DetalleContrato();
        $detalleContrato->fecha_inicio_contrato = $request->get('fecha_inicio_contrato');
        $detalleContrato->fecha_fin_contrato = $request->get('fecha_fin_contrato');
        $detalleContrato->disponibilidad = $request->get('disponibilidad');
        $detalleContrato->contrato_id = $request->get('contrato_id');
        $detalleContrato->user_id = $request->get('usuario_id');

        $detalleContrato->save();

        if ($detalleContrato->save()) {
            return redirect()->route('personales.showDetalleContrato', $detalleContrato->user_id);
        }
    }

    public function editContratoUser($id)
    {
        $contratos = Contrato::all();
        $usuario = User::find($id);
        $detalleContratos = DetalleContrato::where('user_id', $id)->get();
        return view('personales.contratos.editContratoUser', compact('contratos', 'usuario'));
    }

    public function editBonoUser($id)
    {
        $usuario = User::find($id);
        $bono = Bono::where('user_id', $id)->get();
        return view('personales.bonos.editBonoUser', compact('bono', 'usuario'));
    }

    public function editDescountUser($id)
    {
        $usuario = User::find($id);
        $descuento = Descuento::where('user_id', $id)->get();
        return view('personales.descuentos.editDescountUser', compact('usuario', 'descuento'));
    }

    public function editSanctionsUser($id)
    {
        $user = User::find($id);
        $categoria = Categoria::all();
        $users = User::all();
        $sucursales = Sucursal::all();
        $sanciones = CategoriaSancion::all();

        $sancion = Sanciones::where('user_id', $id)->get();

        return view('personales.sanciones.editSanctionsUser', compact('user', 'categoria', 'sancion', 'users', 'sucursales', 'sanciones'));
    }


    public function editDatosBasicos($id)
    {
        $roles = Role::all();
        $cargos = CargoSucursal::all();
        $usuario = User::find($id);
        return view('personales.datos_basicos.editDatosBasicos', compact('usuario', 'roles', 'cargos'));
    }

    public function actualizarDatosBasicos($id, Request $request)
    {


        $user = User::find($id);
        $user->roles()->sync($request->roles);
        $user->cargosucursals()->sync($request->cargosucursals);
        $user->name = $request->get('nombre');
        $user->apellido = $request->get('apellido');
        $user->domicilio = $request->get('domicilio');
        $user->zona = $request->get('zona');
        $user->celular_personal = $request->get('celular_personal');
        $user->celular_referencia = $request->get('celular_referencia');
        $user->email = $request->get('email');
        $user->ci = $request->get('ci');
        $user->estado = $request->get('estado');
        /* $mi_imagen = public_path() . '/imgages/products/mi_imagen.jpg'; */
        if ($request->hasFile("foto")) {
            if (@getimagesize($user->foto)) {
                unlink($user->foto);
                $file = $request->file('foto');
                $destinationPath = 'img/contratos/';
                $filename = time() . '-' . $file->getClientOriginalName();
                $uploadSuccess = $request->file('foto')->move($destinationPath, $filename);
                $user->foto = $destinationPath . $filename;
            } else {
                $file = $request->file('foto');
                $destinationPath = 'img/contratos/';
                $filename = time() . '-' . $file->getClientOriginalName();
                $uploadSuccess = $request->file('foto')->move($destinationPath, $filename);
                $user->foto = $destinationPath . $filename;
            }
        }
        $user->save();

        return redirect()->route('personales.showDetalleContrato', $user->id)->with('actualizado', 'ok');
    }

    public function vencimientoContratos()
    {
        $detalleContratos = DetalleContrato::all();
        foreach ($detalleContratos as $detalleContrato) {
          echo $detalleContrato->user;
        }
        dd($detalleContratos);
        return view('personales.reportes.vencimientoContratos', compact('detalleContratos'));
    }

    public function filtrarContratos(Request $request)
    {
        $fecha_inicial = $request->get('fecha_inicial');
        $fecha_final = $request->get('fecha_final');

        $detalleContratos = DetalleContrato::where('fecha_fin_contrato', '>=', $fecha_inicial)->where('fecha_fin_contrato', '<=', $fecha_final)->get();
        return view('personales.vencimientoContratos', compact('detalleContratos'));
    }
    public function rolesPersonales($id)
    {
        $roles = Role::all();
        $usuario = User::find($id);
        return redirect()->route('personales.rolesPersonales', compact('usuario', 'roles'));
    }

    public function retiroForm($id)
    {
        $user = User::find($id);
        return view('personales.contratos.retiroForm', compact('user'));
    }

    public function retiroFormSave(Request $request)
    {
        dd($request);
    }

    public function asignarSucursal($id)
    {
        $user = User::find($id);
        $sucursales = Sucursal::all();
        return view('personales.datos_basicos.asignarSucursal', compact('user', 'sucursales'));
    }

    public function saveasignarSucursal($id, Request $request)
    {

        $user = User::find($id);
        $user->sucursals()->sync($request->sucursals);
        $user->save();

        return redirect()->route('personales.index');
    }

    /*View para Asignar un cargo a un User */
    public function asignarCargo($id)
    {
        $user = User::find($id);
        $cargos = CargoSucursal::all();

        return view('personales.datos_basicos.asignarCargo', compact('user', 'cargos'));
    }

    /*Guardar cargos */
    public function saveAsignarCargo($id, Request $request)
    {
        $user = User::find($id);
        $user->cargosucursals()->sync($request->cargosucursals);


        return redirect()->route('personales.index');
    }

    public function cronologiaPersonales($id)
    {
        $user = User::find($id);
        $data = [];
        for ($i = 4; $i >= 0; $i--) {
            $fecha = Carbon::now()->locale('es')->subMonth($i);
            /* echo $fecha->monthName . "<br>"; */
            $sanciones = Sanciones::where('user_id', $user->id)->whereBetween('fecha', [$fecha->startOfMonth()->format('Y-m-d'), $fecha->endOfMonth()->format('Y-m-d')])->count();
            $bonos = Bono::where('user_id', $user->id)->whereBetween('fecha', [$fecha->startOfMonth()->format('Y-m-d'), $fecha->endOfMonth()->format('Y-m-d')])->count();
            $descuentos = Descuento::where('user_id', $user->id)->whereBetween('fecha', [$fecha->startOfMonth()->format('Y-m-d'), $fecha->endOfMonth()->format('Y-m-d')])->count();
            $vacaciones = Vacacion::where('user_id', $user->id)->whereBetween('fecha_inicio', [$fecha->startOfMonth()->format('Y-m-d'), $fecha->endOfMonth()->format('Y-m-d')])->count();

            $totales = [
                'nombre_mes' => ucfirst($fecha->monthName),
                'sanciones' => $sanciones,
                'bonos' => $bonos,
                'descuentos' => $descuentos,
                'vacaciones' => $vacaciones,
            ];

            array_push($data, $totales);
        }

        return view('personales.reportes.cronologiaPersonales', compact('user', 'data'));
    }

    public function listaTareas()
    {
        $user_login = Auth::id();
        $user = User::find($user_login);

        if (isset($user->cargosucursales[0])) {
            $cargo_id = $user->cargosucursals[0]->id;
        }
        $cargo_id = $user->cargosucursals[0]->id;
        $tareas = Tarea::where('cargo_id', '=', $cargo_id)->get();
        $fecha_actual = Carbon::now()->format('Y-m-d');
        $pivot = TareaUser::where('user_id', $user_login)->whereDate('created_at', $fecha_actual)->get();

        if (isset($pivot[0])) {
            $pivote = $pivot;
        } else {
            $pivote = 0;
        }

        /* dd($pivote);  */

        return view('personales.tareas.tarea', compact('tareas', 'user', 'pivote', 'fecha_actual'));
    }

    public function saveTareas($id, Request $request)
    {
        // dd($request);
        $user = User::find($id);
        $fecha_actual = Carbon::now()->format('Y-m-d');

        $tareas = Tarea::all();
        $user->tareas()->attach($request->tareas);
        $pivot = TareaUser::where('user_id', $user->id)->whereDate('created_at', $fecha_actual)->get();

        if (isset($pivot[0])) {
            $pivote = $pivot;
        } else {
            $pivote = 0;
        }
        

        /* dd($pivote); */

        return redirect()->route('personales.listaTareas', compact('user', 'pivot', 'tareas'));
    }

    public function reporteTareas()
    {
        $usuarios = User::all();


        return view('personales.tareas.reporteTareas',  compact('usuarios'));
    }

    public function actividadesUsuario($id)
    {
        $user = User::find($id);
        $tareas = Tarea::all();
        $fecha = Carbon::now()->endOfDay();
        $tarea_user = TareaUser::whereBetween('created_at', [$fecha->startOfDay()->format('Y-m-d H:i:s'), $fecha->endOfDay()->format('Y-m-d H:i:s')])->get();


        return view('personales.tareas.actividadesUsuario', compact('user', 'fecha', 'tareas', 'tarea_user'));
    }
}
