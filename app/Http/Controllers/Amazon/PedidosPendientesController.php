<?php


namespace App\Http\Controllers\Amazon;

use App\Http\Controllers\Controller;
use App\Http\Traits\EstadosPedido;
use App\PedidosConfirmadosEnviadosExport;
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
                    'time' => (strtotime($pedidoFormateado['purchase-date']) + strtotime($pedidoFormateado['purchase-hour']))
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
                if(substr($pedidoPendiente[22], 0, 2) !== '07' && substr($pedidoPendiente[22], 0, 2) !== '07') {
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
                        'refc' => uniqid()
                    ]);
                }
            }
        }
    }

    public function confirmarEnvios(Request $request)
    {
        $file = $request->file('file');

        $data = array_map(function ($v) {
            return $v;
        }, file($file));

        $cantidadPedidos = collect($data)->count();

        unset($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[$cantidadPedidos - 3], $data[$cantidadPedidos - 2], $data[$cantidadPedidos - 1]);

        $pedidosGLS = collect($data);

        $pedidosGLS->map(function ($pedido, $key) use ($pedidosGLS) {
            if ($pedido === "\t\t</tr><tr>\r\n") {
                $pedidosGLS->forget($key);
            }
        });

        $pedidosFormateados = $pedidosGLS->map(function ($pedido) {
            $pedidoReplaced = str_replace("\t\t\t<td>", '', $pedido);
            $pedidoReplaced = str_replace('</td><td>', '###', $pedidoReplaced);
            $pedidoReplaced = str_replace("</td>\r\n", '', $pedidoReplaced);
            return explode('###', $pedidoReplaced);
        });

        $pedidosEnviadosConfirmados = [];

        $pedidosFormateados->map(function ($pedido) use (&$pedidosEnviadosConfirmados) {
            $buscarPedido = DB::table('pedido')
                ->where('refc', '=', $pedido[16])
                ->where('numero_seguimiento', '=', null)
                ->get();
            if ($buscarPedido->count() === 1) {
                DB::table('pedido')->where('id', $buscarPedido[0]->id)->update([
                    'numero_seguimiento' => $pedido[22],
                    'estado' => EstadosPedido::$enviado
                ]);
                $pedidoActualizado = DB::table('pedido')->where('id', '=', $buscarPedido[0]->id)->get();
                $buscarPedidoFormateado = collect($pedidoActualizado[0])->toArray();
                $pedidosEnviadosConfirmados[] = [
                    'order-id' => $buscarPedidoFormateado['order-id'],
                    'order-item-id' => $buscarPedidoFormateado['order-item-id'],
                    'numero_seguimiento' => $buscarPedidoFormateado['numero_seguimiento'],
                    'quantity-to-ship' => $buscarPedidoFormateado['quantity-to-ship']
                ];
            }
        });

        return Excel::download(new PedidosConfirmadosEnviadosExport($pedidosEnviadosConfirmados), 'confirmacion-envios-amazon' . date('d-m-Y') . '.tsv', \Maatwebsite\Excel\Excel::TSV);

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
