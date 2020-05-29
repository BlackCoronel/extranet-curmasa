<?php


namespace App\Http\Controllers\Amazon;


use App\Http\Controllers\Controller;
use App\Http\Traits\EstadosPedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidosPospuestosController extends Controller
{
    public function index() {
        return view('amazon.pedidos-pospuestos');
    }

    public function search()
    {
        $pedidos = DB::table('pedido')
            ->where('estado', '=', EstadosPedido::$pospuesto)
            ->get();

        if ($pedidos->count() === 0) {
            $pedidosTabla = [
                'id' => null,
                'referencia' => null,
                'fecha' => null,
                'comprador' => null,
                'producto' => null,
                'direccion' => null,
                'c_postal' => null,
                'telefono' => null
            ];
        } else {

            $pedidosTabla = $pedidos->map(function ($pedido) {
                $pedidoFormateado = collect($pedido)->toArray();
                return [
                    'id' => $pedidoFormateado['id'],
                    'referencia' => $pedidoFormateado['order-id'],
                    'fecha' => date('d/m/Y', strtotime($pedidoFormateado['purchase-date'])),
                    'comprador' => $pedidoFormateado['recipient-name'],
                    'producto' => $pedidoFormateado['product-name'],
                    'direccion' => $pedidoFormateado['ship-address-1'],
                    'c_postal' => $pedidoFormateado['ship-postal-code'],
                    'telefono' => $pedidoFormateado['buyer-phone-number'],
                    'hora' => $pedidoFormateado['purchase-hour'],
                    'time' => ( strtotime($pedidoFormateado['purchase-date']) + strtotime($pedidoFormateado['purchase-hour']))
                ];
            });

            $pedidosTabla = $pedidosTabla->sortBy('time')->values();
        }


        return response()->json(['data' => $pedidosTabla]);
    }

    public function enviarAPendientes(Request $request)
    {
        $pedidos = collect($request->input('pedidos'));

        foreach ($pedidos as $pedidoId) {
            DB::table('pedido')->where('id', $pedidoId)
                ->update(['estado' => EstadosPedido::$pendiente]);
        }
    }

    public function cancelarPedido(Request $request)
    {
        $pedidos = collect($request->input('pedidos'));

        foreach ($pedidos as $pedidoId) {
            DB::table('pedido')->where('id', $pedidoId)
                ->update(['estado' => EstadosPedido::$cancelado]);
        }
    }
}
