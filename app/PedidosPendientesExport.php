<?php


namespace App;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PedidosPendientesExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $pedidos = Pedido::where('estado', '=', 1)->get();

        return view('exports.gls', compact('pedidos'));
    }
}
