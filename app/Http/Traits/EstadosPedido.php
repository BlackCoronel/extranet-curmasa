<?php


namespace App\Http\Traits;


trait EstadosPedido
{
    public static $pendiente = 1;
    public static $enviado = 2;
    public static $pospuesto = 3;
    public static $cancelado = 4;

    protected $estadosPedido = [
        [
            'id' => 1,
            'descripcion' => 'Pendiente'
        ],
        [
            'id' => 2,
            'descripcion' => 'Enviado'
        ],
        [
            'id' => 3,
            'descripcion' => 'Pospuesto'
        ],
        [
            'id' => 4,
            'descripcion' => 'Cancelado'
        ],
    ];
}
