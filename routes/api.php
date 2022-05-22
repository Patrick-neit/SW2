<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompraController;
use App\Models\Compra;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/compras',[CompraController::class, 'getCompras']);

Route::get('/get_compras',function(Request $request){
    
    $compras = new Compra();
    $compras_registradas = $compras->getCompras();
    $respuesta = [
        'success'=>true,
        'compras'=>$compras_registradas
    ];
    return response($respuesta, 200)->header('Content-Type', 'application/json');
});


