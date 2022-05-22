<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\DetallePago;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Proveedor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pagos = Pago::all();
        $proveedores = Proveedor::all();
        return view('pagos.index', compact('pagos', 'proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $compras = Compra::all();
        return view('pagos.create', compact('compras', $compras));
    }
    public function filtrarPagos(Request $request)
    {
        $fecha_inicial = $request->fecha_inicial;
        $fecha_fin = $request->fecha_final;
        $proveedor_id = $request->proveedor_id;

        $proveedor_id = $request->proveedor_id;
        if (isset($proveedor_id) && isset($sucursal_id)) {
            $pagos = Pago::whereBetween('fecha', [$fecha_inicial, $fecha_fin])
                ->where([
                    ['proveedor_id', '=', $proveedor_id],
                ])->get();
        } else {
            $pagos = Pago::whereBetween('fecha', [$fecha_inicial, $fecha_fin])->get();
        }
        $sucursales = Sucursal::all();
        $proveedores = Proveedor::all();
        return view('pagos.index', compact('pagos', 'proveedores', 'sucursales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $sucursal_id = $user->sucursals[0]->id;
        $request->validate([
            'banco' => 'required',
            'nro_cuenta' => 'required',

        ]);

        try {
            $pago = new Pago();
            $pago->fecha = Carbon::now()->toDateString();
            $pago->banco = $request->get('banco');
            $pago->nro_cuenta = $request->get('nro_cuenta');
            $pago->tipo_pago = $request->get('tipo_pago');
            $pago->nro_comprobante = $request->get('nro_comprobante');
            $pago->nro_cheque = $request->get('nro_cheque');
            $pago->user_id =  $user_id;
            $pago->sucursal_id = $sucursal_id;
            $pago->save();

            $pago_proveedor = 0;
            $total_pago = 0;
            for ($i = 0; $i < sizeof($request->compras_id); $i++) {
                $compra = Compra::find($request->compras_id[$i]);
                $compra->estado = 'P';
                $compra->save();

                $detalle_pago = new DetallePago();
                $detalle_pago->pago_id = $pago->id;
                $detalle_pago->compra_id = $compra->id;
                $detalle_pago->save();

                $pago_proveedor = $compra->proveedor_id;
                $total_pago += $compra->total;
            }
            $pago->update(['proveedor_id' => $pago_proveedor, 'total' => $total_pago]);
        } catch (Exception $e) {
            return $e->getMessage();
        }


        return response()->json(
            [
                'success' => true
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pago = Pago::find($id);
        $detalle_compra = DetalleCompra::where('compra_id', $id)->get();
        return view('pagos.show', ['pago' => $pago], ['detalle_compra' => $detalle_compra]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function downloadPDF($id)
    {
        $pago = Pago::find($id);

        view()->share('pagos.detalleCompra-PDF', $pago);

        $pdf = PDF::loadView('pagos.detallePago-PDF', ['pago' => $pago])
            ->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);

        return $pdf->stream('Detalle-Pago-' . $pago->id . '.pdf', ['Attachment' => false]);
    }

    public function reporteProveedores()
    {
        $proveedores = Proveedor::all();

        $fecha_actual = Carbon::now();

        $compras_por_proveedor = Compra::whereBetween('fecha_compra', [$fecha_actual->startOfMonth()->format('Y-m-d'), $fecha_actual->endOfMonth()->format('Y-m-d')])
            ->groupBy(['proveedor_id'])
            ->selectRaw(' proveedor_id, sum(total) totalPagado')
            ->get();

        $pagos_por_proveedor = Pago::whereBetween('fecha', [$fecha_actual->startOfMonth()->format('Y-m-d'), $fecha_actual->endOfMonth()->format('Y-m-d')])
            ->groupBy(['proveedor_id'])
            ->selectRaw('proveedor_id, sum(total) totalPagado')
            ->get();


        $collection = collect();
        foreach ($compras_por_proveedor as $index => $compra) {
            foreach ($pagos_por_proveedor as $index => $pago) {
                if ($compra->proveedor_id == $pago->proveedor_id) {
                    $totalPorPagar = (float)($compra->totalPagado) - (float)($pago->totalPagado);
                    $collection->push([
                        'proveedor_id' => $compra->proveedor->id,
                        'proveedor_nombre' => $compra->proveedor->nombre,
                        'total_compras' => (float)$compra->totalPagado,
                        'total_pagos' => (float)$pago->totalPagado,
                        'total_por_pagar' => $totalPorPagar,
                    ]);
                }
            }
        }

        return view('contabilidad.reportes.reporteProveedores', compact('collection'));
    }

    public function filtrarComprasyPagos(Request $request)
    {
        $fecha_inicial = $request->get('fecha_inicial');
        $fecha_final = $request->get('fecha_final');

        $compras_por_proveedor = Compra::whereBetween('fecha_compra', [$fecha_inicial, $fecha_final])
            ->groupBy(['proveedor_id'])
            ->selectRaw(' proveedor_id, sum(total) totalPagado')
            ->get();

        $pagos_por_proveedor = Pago::whereBetween('fecha', [$fecha_inicial, $fecha_final])
            ->groupBy(['proveedor_id'])
            ->selectRaw('proveedor_id, sum(total) totalPagado')
            ->get();

        $collection = collect();
        foreach ($compras_por_proveedor as $index => $compra) {
            foreach ($pagos_por_proveedor as $index => $pago) {
                if (isset($compra->proveedor->nombre)) {
                    if ($compra->proveedor_id == $pago->proveedor_id) {
                       /*  echo strtoupper($compra->proveedor->nombre) . "<br>"; */
                        
                        $totalPorPagar = (float)($compra->totalPagado) - (float)($pago->totalPagado);
                        $collection->push([
                            'proveedor_id' => $compra->proveedor->id,
                            'proveedor_nombre' => $compra->proveedor->nombre,
                            'total_compras' => (float)$compra->totalPagado,
                            'total_pagos' => (float)$pago->totalPagado,
                            'total_por_pagar' => $totalPorPagar,
                        ]);
                    } else {
                        echo strtoupper($compra->proveedor->nombre) . "<br>";
                    }
                }
            }
        }

        dd($collection);

        return view('contabilidad.reportes.reporteProveedores', compact('collection'));
    }
}
