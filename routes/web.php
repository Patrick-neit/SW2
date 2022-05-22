<?php

use App\Http\Controllers\CompraController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VacacionController;
use App\Http\Controllers\CronologiaController;
use App\Http\Controllers\GaranteController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\RetrasoyFaltaController;
use App\Http\Controllers\TareaController;
use App\Models\Sucursal;
use App\Models\UsuarioSucursal;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $sucursales = Sucursal::all();
    return view('auth.login', compact('sucursales'));
});



Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('marcado_asistencia', function () {
    return view('marcado_asistencia');
});





/*Auth */
Route::post('/auth/find', [App\Http\Controllers\LoginManualController::class, 'authenticate'])->name('auth.find');

/*Rutas Proveedores */
Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad']], function () {
    Route::get('/proveedores', [App\Http\Controllers\ProveedorController::class, 'index'])->name('proveedores.index');
    Route::get('/proveedores/create', [App\Http\Controllers\ProveedorController::class, 'create'])->name('proveedores.create');
    Route::post('/proveedores', [App\Http\Controllers\ProveedorController::class, 'store'])->name('proveedores.store');
    Route::get('/proveedores/edit/{id}', [App\Http\Controllers\ProveedorController::class, 'edit'])->name('proveedores.edit');
    Route::put('/proveedores/{id}', [App\Http\Controllers\ProveedorController::class, 'update'])->name('proveedores.update');
    Route::delete('/proveedores/{id}', [\App\Http\Controllers\ProveedorController::class, 'destroy'])->name('proveedores.destroy');
    Route::get('/proveedores/show/{id}', [App\Http\Controllers\ProveedorController::class, 'show'])->name('proveedores.show');
});

/*Rutas Productos */
Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad']], function () {
    Route::get('/productos', [App\Http\Controllers\ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/create', [App\Http\Controllers\ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [App\Http\Controllers\ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/edit/{id}', [App\Http\Controllers\ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{id}', [App\Http\Controllers\ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{id}', [\App\Http\Controllers\ProductoController::class, 'destroy'])->name('productos.destroy');
    Route::get('/productos/show/{id}', [App\Http\Controllers\ProductoController::class, 'show'])->name('productos.show');
});
/* Rutas Sucursales*/
Route::group(['middleware' => ['auth', 'role:Super Admin']], function () {
    Route::get('/sucursales', [App\Http\Controllers\SucursalController::class, 'index'])->name('sucursales.index');
    Route::get('/sucursales/create', [App\Http\Controllers\SucursalController::class, 'create'])->name('sucursales.create');
    Route::post('/sucursales', [App\Http\Controllers\SucursalController::class, 'store'])->name('sucursales.store');
    Route::get('/sucursales/edit/{id}', [App\Http\Controllers\SucursalController::class, 'edit'])->name('sucursales.edit');
    Route::put('/sucursales/{id}', [App\Http\Controllers\SucursalController::class, 'update'])->name('sucursales.update');
    Route::get('/sucursales/show/{id}', [App\Http\Controllers\SucursalController::class, 'show'])->name('sucursales.show');
    Route::delete('/sucursales/{id}', [\App\Http\Controllers\SucursalController::class, 'destroy'])->name('sucursales.destroy');
});

/* Rutas Categorias*/
Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad']], function () {
    Route::get('/categorias', [App\Http\Controllers\CategoriaController::class, 'index'])->name('categorias.index');
    Route::get('/categorias/create', [App\Http\Controllers\CategoriaController::class, 'create'])->name('categorias.create');
    Route::post('/categorias', [App\Http\Controllers\CategoriaController::class, 'store'])->name('categorias.store');
    Route::get('/categorias/edit/{id}', [App\Http\Controllers\CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::put('/categorias/{id}', [App\Http\Controllers\CategoriaController::class, 'update'])->name('categorias.update');
    Route::get('/categorias/show/{id}', [App\Http\Controllers\CategoriaController::class, 'show'])->name('categorias.show');
    Route::delete('/categorias/{id}', [\App\Http\Controllers\CategoriaController::class, 'destroy'])->name('categorias.destroy');
});

/*Rutas Producto Proveedor */
Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad']], function () {
    Route::get('/productos_proveedores', [App\Http\Controllers\ProductoProveedorController::class, 'index'])->name('productos_proveedores.index');
    Route::get('/productos_proveedores/create', [App\Http\Controllers\ProductoProveedorController::class, 'create'])->name('productos_proveedores.create');
    Route::get('/productos_proveedores/edit/{id}', [App\Http\Controllers\ProductoProveedorController::class, 'edit'])->name('productos_proveedores.edit');
    Route::post('/productos_proveedores', [App\Http\Controllers\ProductoProveedorController::class, 'store'])->name('productos_proveedores.store');
    Route::put('/productos_proveedores/{id}', [App\Http\Controllers\ProductoProveedorController::class, 'update'])->name('productos_proveedores.update');

    Route::get('/productos_proveedores/show/{id}', [App\Http\Controllers\ProductoProveedorController::class, 'show'])->name('productos_proveedores.show');
    Route::post('productos_proveedores/enviarDetalle', [App\Http\Controllers\ProductoProveedorController::class, 'guardarDetalle'])->name('productos_proveedores.guardarDetalle');
    Route::post('productos_proveedores/eliminarDetalle', [App\Http\Controllers\ProductoProveedorController::class, 'eliminarDetalle'])->name('productos_proveedores.eliminarDetalle');
    Route::post('productos_proveedores/registrarPrecios', [App\Http\Controllers\ProductoProveedorController::class, 'store'])->name('productos_proveedores.registrarPrecios');
});

/*Rutas Inventario*/
Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad']], function () {
    Route::get('/inventarios', [App\Http\Controllers\InventarioController::class, 'index'])->name('inventarios.index');
    Route::get('/inventarios/create', [App\Http\Controllers\InventarioController::class, 'create'])->name('inventarios.create');
    Route::post('/inventarios', [App\Http\Controllers\InventarioController::class, 'store'])->name('inventarios.store');
});

/*Rutas Encargado*/

Route::get('/encargados', [App\Http\Controllers\EncargadoController::class, 'index'])->name('encargados.index');
Route::get('/encargados/create', [App\Http\Controllers\EncargadoController::class, 'create'])->name('encargados.create');
Route::post('/encargados', [App\Http\Controllers\EncargadoController::class, 'store'])->name('encargados.store');


/* Rutas Contratos*/
Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
    Route::get('/contratos', [App\Http\Controllers\ContratoController::class, 'index'])->name('contratos.index');
    Route::get('/contratos/create', [App\Http\Controllers\ContratoController::class, 'create'])->name('contratos.create');
    Route::post('/contratos', [App\Http\Controllers\ContratoController::class, 'store'])->name('contratos.store');
    Route::get('/contratos/edit/{id}', [App\Http\Controllers\ContratoController::class, 'edit'])->name('contratos.edit');
    Route::put('/contratos/{id}', [App\Http\Controllers\ContratoController::class, 'update'])->name('contratos.update');
    Route::get('/contratos/show/{id}', [App\Http\Controllers\ContratoController::class, 'show'])->name('contratos.show');
    Route::delete('/contratos/{id}', [\App\Http\Controllers\ContratoController::class, 'destroy'])->name('contratos.destroy');
});

/*Rutas Departamentos */
Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
    Route::get('/departamentos', [App\Http\Controllers\DepartamentoController::class, 'index'])->name('departamentos.index');
    Route::get('/departamentos/create', [App\Http\Controllers\DepartamentoController::class, 'create'])->name('departamentos.create');
    Route::post('/departamentos', [App\Http\Controllers\DepartamentoController::class, 'store'])->name('departamentos.store');
    Route::get('/departamentos/edit/{id}', [App\Http\Controllers\DepartamentoController::class, 'edit'])->name('departamentos.edit');
    Route::put('/departamentos/{id}', [App\Http\Controllers\DepartamentoController::class, 'update'])->name('departamentos.update');
    Route::delete('/departamentos/{id}', [\App\Http\Controllers\DepartamentoController::class, 'destroy'])->name('departamentos.destroy');
});

/*Rutas Contrato de Personal */
Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
    Route::get('/personales', [App\Http\Controllers\UserController::class, 'index'])->name('personales.index');
    Route::get('/personales/create', [App\Http\Controllers\UserController::class, 'create'])->name('personales.create');
    Route::post('/personales', [App\Http\Controllers\UserController::class, 'contratar'])->name('personales.contratar');
    Route::get('/personales/show/{id}', [App\Http\Controllers\UserController::class, 'showDetalleContrato'])->name('personales.showDetalleContrato');
    Route::delete('/personales/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('personales.destroy');
    Route::get('/personales/editContratoUser/{id}', [App\Http\Controllers\UserController::class, 'editContratoUser'])->name('personales.editContratoUser');
    Route::get('/personales/editDatosBasicos/{id}', [App\Http\Controllers\UserController::class, 'editDatosBasicos'])->name('personales.editDatosBasicos');
    Route::post('/personales/editContratoUser', [App\Http\Controllers\UserController::class, 'actualizarContratoUser'])->name('personales.actualizarContratoUser');
    Route::put('/personales/editDatosBasicos/{id}', [App\Http\Controllers\UserController::class, 'actualizarDatosBasicos'])->name('personales.actualizarDatosBasicos');
    Route::get('/personales/rolesPersonales/{id}', [App\Http\Controllers\UserController::class, 'rolesPersonales'])->name('personales.rolesPersonales');
    Route::get('/personales/retiroForm/{id}', [App\Http\Controllers\UserController::class, 'retiroForm'])->name('personales.retiroForm');
    Route::post('/personales/retiroForm', [App\Http\Controllers\UserController::class, 'retiroFormSave'])->name('personales.retiroFormSave');
    Route::get('/personales/asignarSucursal/{id}', [App\Http\Controllers\UserController::class, 'asignarSucursal'])->name('personales.asignarSucursal');
    Route::put('/personales/asignar_Sucursal/{id}', [App\Http\Controllers\UserController::class, 'saveasignarSucursal'])->name('personales.saveasignarSucursal');
    Route::get('/personales/editBonoUser/{id}', [App\Http\Controllers\UserController::class, 'editBonoUser'])->name('personales.editBonoUser');

    Route::get('/personales/reportes/vencimientoContratos', [App\Http\Controllers\UserController::class, 'vencimientoContratos'])->name('personales.vencimientoContratos');
    Route::post('/personales/vencimientoContratos', [App\Http\Controllers\UserController::class, 'filtrarContratos'])->name('personales.filtrarContratos');

    Route::get('/personales/reportes/cronologiaPersonales/{id}', [App\Http\Controllers\UserController::class, 'cronologiaPersonales'])->name('personales.cronologiaPersonales');

    Route::get('/personales/asignarCargo/{id}', [App\Http\Controllers\UserController::class, 'asignarCargo'])->name('personales.asignarCargo');
    Route::put('/personales/save_cargo/{id}', [App\Http\Controllers\UserController::class, 'saveAsignarCargo'])->name('personales.saveAsignarCargo');
});

Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
   Route::get('personales/contratos/editarContrato/{id}',[\App\Http\Controllers\DetalleContratoController::class,'edit'])->name('personales_contratos.edit');
   Route::put('personales/contratos/editarContrato/{id}',[\App\Http\Controllers\DetalleContratoController::class,'update'])->name('personales_contratos.update');
   Route::delete('personales/contratos/editarContrato/{id}', [\App\Http\Controllers\DetalleContratoController::class, 'eliminar'])->name('personales_contratos.eliminar');

   Route::get('personales/vacaciones/agregarVacacion/{id}',[\App\Http\Controllers\VacacionController::class,'agregarVacacion'])->name('personales_vacaciones.agregarVacacion');
   Route::post('personales/vacaciones/agregarVacacion/{id}',[\App\Http\Controllers\VacacionController::class,'guardarVacacion'])->name('personales_vacaciones.guardarVacacion');

   Route::get('/personales/editDescountUser/{id}', [App\Http\Controllers\UserController::class, 'editDescountUser'])->name('personales.editDescountUser');
   Route::get('/personales/editSanctionsUser/{id}', [App\Http\Controllers\UserController::class, 'editSanctionsUser'])->name('personales.editSanctionsUser');

   


});

    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH|Encargado|Almacen']], function () {
        Route::get('/personales/tareas/tarea',[App\Http\Controllers\UserController::class,'listaTareas'])->name('personales.listaTareas');
        Route::post('/personales/tareas/saveTareas/{id}',[App\Http\Controllers\UserController::class,'saveTareas'])->name('personales.saveTareas');
        Route::get('/personales/tareas/reporteTareas',[App\Http\Controllers\UserController::class,'reporteTareas'])->name('personales.reporteTareas');
        Route::get('/personales/tareas/actividadesUsuario/{id}',[App\Http\Controllers\UserController::class,'actividadesUsuario'])->name('personales.actividadesUsuario');
    });


/*Rutas Cargos  */
Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
    Route::get('/cargos', [App\Http\Controllers\CargoController::class, 'index'])->name('cargos.index');
    Route::get('/cargos/edit/{id}', [App\Http\Controllers\CargoController::class, 'edit'])->name('cargos.edit');
    Route::get('/cargos/create', [App\Http\Controllers\CargoController::class, 'create'])->name('cargos.create');
    Route::post('/cargos', [App\Http\Controllers\CargoController::class, 'store'])->name('cargos.store');
    Route::delete('/cargos/{id}', [\App\Http\Controllers\CargoController::class, 'destroy'])->name('cargos.destroy');
});

/*Rutas Sanciones  */
Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
    Route::get('/sanciones', [App\Http\Controllers\SancionesController::class, 'index'])->name('sanciones.index');
    Route::get('/sanciones/create', [App\Http\Controllers\SancionesController::class, 'create'])->name('sanciones.create');
    Route::post('/sanciones', [App\Http\Controllers\SancionesController::class, 'store'])->name('sanciones.store');
    Route::get('/sanciones/show/{id}', [App\Http\Controllers\SancionesController::class, 'show'])->name('sanciones.show');
    Route::get('/sanciones/edit/{id}', [App\Http\Controllers\SancionesController::class, 'edit'])->name('sanciones.edit');
    Route::post('/sanciones/{id}', [App\Http\Controllers\SancionesController::class, 'update'])->name('sanciones.update');
    Route::delete('/sanciones/{id}', [\App\Http\Controllers\SancionesController::class, 'destroy'])->name('sanciones.destroy');
});
/*Ruta Horarios */
Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
    Route::get('/horarios', [App\Http\Controllers\HorarioController::class, 'index'])->name('horarios.index');
    Route::get('/horarios/create', [App\Http\Controllers\HorarioController::class, 'create'])->name('horarios.create');
    Route::post('/horarios', [App\Http\Controllers\HorarioController::class, 'store'])->name('horarios.store');
    Route::post('/horarios/create', [App\Http\Controllers\HorarioController::class, 'obtenerSucursal'])->name('horarios.obtenerSucursal');
    Route::post('/funcionarios', [App\Http\Controllers\HorarioController::class, 'funcionarios'])->name('sucursal.funcionarios');

    Route::get('horarios/reporteHorario', [App\Http\Controllers\HorarioController::class, 'reporteHorario'])->name('horarios.reporteHorario');
    Route::get('/planillaHorarios', [App\Http\Controllers\HorarioController::class, 'planillaHorarios'])->name('horarios.planillaHorarios');
    /*  Route::post('/planillaHorarios',[App\Http\Controllers\HorarioController::class, 'cargarHorarios'])->name('horarios.cargarHorarios'); */
    Route::post('/planillaHorarios', [App\Http\Controllers\HorarioController::class, 'obtenerFuncionarios'])->name('horarios.obtenerFuncionarios');
});
/*Rutas Bonos */
Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
    Route::get('/bonos', [App\Http\Controllers\BonoController::class, 'index'])->name('bonos.index');
    Route::get('/bonos/create', [App\Http\Controllers\BonoController::class, 'create'])->name('bonos.create');
    Route::post('/bonos', [App\Http\Controllers\BonoController::class, 'store'])->name('bonos.store');
    Route::get('/bonos/show/{id}', [App\Http\Controllers\BonoController::class, 'show'])->name('bonos.show');
    Route::delete('/bonos/{id}', [\App\Http\Controllers\BonoController::class, 'destroy'])->name('bonos.destroy');
});

/*Rutas descuentos */
Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
    Route::get('/descuentos', [App\Http\Controllers\DescuentoController::class, 'index'])->name('descuentos.index');
    Route::get('/descuentos/create', [App\Http\Controllers\DescuentoController::class, 'create'])->name('descuentos.create');
    Route::post('/descuentos', [App\Http\Controllers\DescuentoController::class, 'store'])->name('descuentos.store');
    Route::get('/descuentos/show/{id}', [App\Http\Controllers\DescuentoController::class, 'show'])->name('descuentos.show');
    Route::delete('/descuentos/{id}', [\App\Http\Controllers\DescuentoController::class, 'destroy'])->name('descuentos.destroy');
});
/*Rutas vacaciones */

Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
    Route::resource('vacaciones', VacacionController::class);
});

/*Rutas Roles */

Route::group(['middleware' => ['auth', 'role:Super Admin']], function () {

    Route::resource('roles', RoleController::class);
});

Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad']], function () {
    Route::resource('compras', CompraController::class);
    Route::post('compras/registrarComprar', [CompraController::class, 'registrarCompra'])->name('compras.registrarCompra');
    Route::post('compras/create', [CompraController::class, 'obtenerProductos'])->name('compras.obtenerproductos');
    Route::post('compras/obtener', [CompraController::class, 'obtenerPrecios'])->name('compras.obtenerprecios');
    Route::post('compras/enviarDetalle', [CompraController::class, 'guardarDetalle'])->name('compras.guardarDetalle');
    Route::post('compras/eliminarDetalle', [CompraController::class, 'eliminarDetalle'])->name('compras.eliminarDetalle');
    Route::post('compras/filtrarCompras', [CompraController::class, 'filtrarCompras'])->name('compras.filtrarCompras');
    Route::get('compras/download-pdf/{id}', [CompraController::class, 'downloadPdf'])->name('compras.download-pdf');
});

Route::group(['middleware' => ['auth, role:Super Admin|RRHH']], function () {
    Route::resource('cronologias', CronologiaController::class);
});

Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH' ]], function () {
    Route::resource('observaciones', ObservacionController::class);
});


Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad']], function () {
    Route::resource('pagos', PagoController::class);
    Route::post('compras/filtrarPagos', [PagoController::class, 'filtrarPagos'])->name('pagos.filtrarPagos');
    Route::get('pagos/download-pdf/{id}', [PagoController::class, 'downloadPdf'])->name('pagos.download-pdf');
    Route::get('contabilidad/reportes/reporteProveedores',[PagoController::class, 'reporteProveedores'])->name('contabilidad.reporteProveedores');
    Route::post('contabilidad/reportes/reporteProveedores',[PagoController::class, 'filtrarComprasyPagos'])->name('contabilidad.filtrarComprasyPagos');
});

Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
    Route::resource('garantes', GaranteController::class);
});

Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH|Encargado']], function () {
    Route::resource('retrasosFaltas', RetrasoyFaltaController::class);
});

Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
    Route::resource('tareas', TareaController::class);
});





/* Route::post('/login', function () {
    $credentials = request()->only('codigo');
    dd($credentials);
    if(Auth::attempt($credentials)){
        return "Estas logeado";
    }
    return "No estas logeado";

})->name('login.prueba'); */
