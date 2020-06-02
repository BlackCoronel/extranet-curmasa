<?php


namespace App\Http\Controllers\Amazon;


use App\Http\Controllers\Controller;
use App\Http\Traits\EstadosPedido;
use App\PedidosPendientesExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PedidosPendientesController extends Controller
{
    public function index()
    {
        return view('amazon.pedidos-pendientes');
    }

    public function search()
    {
        $pedidos = DB::table('pedido')
            ->where('estado', '=', EstadosPedido::$pendiente)
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

    public function importar(Request $request)
    {

        $file = $request->file('file');

        $data = array_map(function ($v) {
            return str_getcsv($v, "\t");
        }, file($file));

        unset($data[0]);

        foreach ($data as $pedidoPendiente) {
            $buscarPedido = DB::table('pedido')->where('order-id', $pedidoPendiente[0])->get();
            if ($buscarPedido->count() === 0) {
                $timestamp = str_replace('T', ' ', $pedidoPendiente[2]);
                DB::table('pedido')->insert([
                    'estado' => EstadosPedido::$pendiente,
                    'order-id' => $pedidoPendiente[0],
                    'order-item-id' => $pedidoPendiente[1],
                    'purchase-date' => Carbon::parse($timestamp)->setTimezone('EUROPE/MADRID')->format('Y-m-d'),
                    'payments-date' => date('Y-m-d', strtotime($pedidoPendiente[3])),
                    'reporting-date' => date('Y-m-d', strtotime($pedidoPendiente[4])),
                    'promise-date' => date('Y-m-d', strtotime($pedidoPendiente[5])),
                    'days-past-promise' => $pedidoPendiente[6],
                    'buyer-email' => $pedidoPendiente[7],
                    'buyer-name' => $pedidoPendiente[8],
                    'buyer-phone-number' => $pedidoPendiente[9],
                    'sku' => $pedidoPendiente[10],
                    'product-name' => $pedidoPendiente[11],
                    'quantity-purchased' => $pedidoPendiente[12],
                    'quantity-shipped' => $pedidoPendiente[13],
                    'quantity-to-ship' => $pedidoPendiente[14],
                    'ship-service-level' => $pedidoPendiente[15],
                    'recipient-name' => $pedidoPendiente[16],
                    'ship-address-1' => $pedidoPendiente[17],
                    'ship-address-2' => $pedidoPendiente[18],
                    'ship-address-3' => $pedidoPendiente[19],
                    'ship-city' => $pedidoPendiente[20],
                    'ship-state' => $pedidoPendiente[21],
                    'ship-postal-code' => $pedidoPendiente[22],
                    'ship-country' => $pedidoPendiente[23],
                    'sales-channel' => $pedidoPendiente[24],
                    'is-business-order' => $pedidoPendiente[25],
                    'purchase-order-number' => $pedidoPendiente[26],
                    'price-designation' => $pedidoPendiente[27],
                    'is-sold-by-ab' => $pedidoPendiente[28],
                    'purchase-hour' => Carbon::parse($timestamp)->setTimezone('EUROPE/MADRID')->format('H:i:s'),
                    'refc' =>  uniqid()
                ]);
            }
        }
    }

    public function exportacionGLS()
    {
        return Excel::download(new PedidosPendientesExport(), 'pedidos-gls-' . date('d-m-Y') . '.xlsx');
    }

    public function posponerEnvio(Request $request)
    {
        $pedidos = collect($request->input('pedidos'));

        foreach ($pedidos as $pedidoId) {
            DB::table('pedido')->where('id', $pedidoId)
                ->update(['estado' => EstadosPedido::$pospuesto]);
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
