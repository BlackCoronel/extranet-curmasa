<?php


namespace App;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;


class PedidosConfirmadosEnviadosExport implements FromView,WithCustomCsvSettings
{
    use Exportable;
    /**
     * @var array
     */
    private $pedidos;

    /**
     * PedidosConfirmadosEnviadosExport constructor.
     * @param array $pedidos
     */
    public function __construct(array $pedidos)
    {
        $this->pedidos = $pedidos;
    }

    public function view(): View
    {
        $pedidos = $this->pedidos;
        return view('exports.confirmaciones-amazon', compact('pedidos'));
    }

    public function getCsvSettings(): array
    {
        return [
          'delimiter' => "\t"
        ];
    }
}
