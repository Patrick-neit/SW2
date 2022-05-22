<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\ComprobanteFactura;
use App\Models\ComprobanteRecibo;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Producto_Proveedor;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use \Yajra\Datatables\Datatables;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;



class CompraController extends Controller
{

    public function downloadPDF($id){
        $compra = Compra::find($id);
        $detalle_compra = DetalleCompra::where('compra_id', $id)->get();

        view()->share('compras.detalleCompra-PDF',$compra);
        view()->share('compras.detalleCompra-PDF',$detalle_compra);

        $pdf = PDF::loadView('compras.detalleCompra-PDF',['compra'=>$compra,'detalle_compra'=>$detalle_compra])->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);

        return $pdf->stream('Detalle-Compra-'.$compra->id.'.pdf',['Attachment' => false]);
    }

    public function index()
    {
        //dd($compras);  
        $proveedores = Proveedor::all();
        $sucursales = Sucursal::all();
        $compras = Compra::all();
        return view('compras.index', compact('compras', 'proveedores', 'sucursales'));
    }

    public function filtrarCompras(Request $request)
    {
        $fecha_inicial = $request->fecha_inicial;
        $fecha_fin = $request->fecha_final;
        $proveedor_id = $request->proveedor_id;
        $sucursal_id = $request->sucursal_id;
        if( isset($proveedor_id) && isset($sucursal_id) ){
            $compras = Compra::whereBetween('fecha_compra', [$fecha_inicial, $fecha_fin])
            ->where([
                ['proveedor_id', '=', $proveedor_id],
                ['sucursal_id', '=', $sucursal_id]
                ])->get();
        }elseif( isset($proveedor_id)){
            $compras = Compra::whereBetween('fecha_compra', [$fecha_inicial, $fecha_fin])
            ->where([
                ['proveedor_id', '=', $proveedor_id]
                ])->get();
        }elseif(isset($sucursal_id)){
            $compras = Compra::whereBetween('fecha_compra', [$fecha_inicial, $fecha_fin])
            ->where([
                ['sucursal_id', '=', $sucursal_id]
                ])->get();
        }else{  
            $compras = Compra::whereBetween('fecha_compra', [$fecha_inicial, $fecha_fin])->get();              
        }
        
        $sucursales = Sucursal::all();
        $proveedores = Proveedor::all();
        //return redirect()->route('compras.index')->with('compras', $compras); 
        return view('compras.index', compact('compras', 'proveedores', 'sucursales'));
    }


    public function create()
    {
        $fecha_actual = Carbon::now()->toDateString();
        $proveedores = Proveedor::all();
        return view('compras.create', compact("proveedores", "fecha_actual"));
    }


    public function obtenerProductos(Request $request)
    {

        if (isset($request->proveedor_id)) {
            $productos = Producto_Proveedor::where('proveedor_id', $request->proveedor_id)
                ->join('productos', 'productos.id', '=', 'producto_proveedor.producto_id')->get();
            //dd($productos);
            return response()->json(
                [
                    'lista' => $productos,
                    'success' => true
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }
    public function obtenerPrecios(Request $request)
    {
        //dd($request);
        if (isset($request->producto_id)) {
            $precio = Producto_Proveedor::select('precio')->where('producto_id', $request->producto_id)->where('proveedor_id',$request->proveedor_id)->get();
            //dd($precio);
            return response()->json(
                [
                    'precio' => $precio,
                    'success' => true
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }
    public function guardarDetalle(Request $request)
    {
        $producto_nombre = Producto::find($request->detalleCompra["producto_id"]);
        $detalle_compra = [
            "producto_id" => $request->detalleCompra['producto_id'],
            "producto_nombre" => $producto_nombre,
            "precio" => $request->detalleCompra['precio'],
            "cantidad" => $request->detalleCompra['cantidad'],
            "subtotal" => $request->detalleCompra['subtotal'],
        ];

        session()->get('lista_compra');
        session()->push('lista_compra', $detalle_compra);

        return response()->json([
            'lista_compra' => session()->get('lista_compra'),
            'success' => true
        ]);
    }
    public function eliminarDetalle(Request $request)
    {
        $detalle_compra = session('lista_compra');
        unset($detalle_compra[$request->data]);
        session()->put('lista_compra', $detalle_compra);
        return response()->json(
            [
                'lista_compra' => session()->get('lista_compra'),
                'success' => true
            ]
        );
    }
    public function registrarCompra(Request $request)
    {
        /*  dd($request); */
        $compra = new Compra();
        $compra->total = $request->compra_total;
        $compra->fecha_compra = Carbon::now()->toDateString();
        $compra->user_id = Auth::id();
        $compra->sucursal_id = 2;
        $compra->proveedor_id = $request->proveedor_id;
        $compra->tipo_comprobante = $request->t_comprobante;
        $compra->estado = 'N';
        $compra->save();

        if ($request->t_comprobante === "R") {
            $comprobante_recibo = new ComprobanteRecibo();
            $comprobante_recibo->nro_recibo = $request->recibo;
            $comprobante_recibo->compra_id = $compra->id;
            $comprobante_recibo->save();
        }

        if ($request->t_comprobante === "F") {
            $comprobante_factura = new ComprobanteFactura();
            $comprobante_factura->numero_factura = $request->factura;
            $comprobante_factura->numero_autorizacion = $request->autorizacion;
            $comprobante_factura->codigo_control = $request->control;
            $comprobante_factura->compra_id = $compra->id;
            $comprobante_factura->save();
        }

        foreach (session('lista_compra') as $id => $item) {
            $detalle_compra = new DetalleCompra();
            $detalle_compra->cantidad = $item['cantidad'];
            $detalle_compra->precio_compra = $item['precio'];
            $detalle_compra->subtotal = $item['subtotal'];
            $detalle_compra->compra_id = $compra->id;
            $detalle_compra->producto_id = $item['producto_id'];
            $detalle_compra->save();
        }
        session()->forget('lista_compra');

        session()->get('compra_realizada');
        session()->put('compra_realizada', 'ok');
        return response()->json(
            [
                'success' => true
            ]
        );
    }
    public function show($id)
    {
        $compra = Compra::find($id);
        $detalle_compra = DetalleCompra::where('compra_id', $id)->get();
        return view('compras.detalleCompra', ['compra' => $compra], ['detalle_compra' => $detalle_compra]);
    }

    public function getCompras(){
        $sql="Select * from compras";
        $compras = DB::select($sql);
        return $compras;
    }
}
