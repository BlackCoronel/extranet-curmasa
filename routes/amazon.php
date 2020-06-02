<?php

use Illuminate\Support\Facades\Route;

/*
 * Dashboard
 */
Route::get('/', 'AmazonController@index');
/*
 * Pedidos Pendientes
 */
Route::get('pedidos-pendientes', 'PedidosPendientesController@index');
Route::get('pedidos-pendientes/search', 'PedidosPendientesController@search');
Route::post('pedidos-pendientes/importar', 'PedidosPendientesController@importar');
Route::post('pedidos-pendientes/posponer', 'PedidosPendientesController@posponerEnvio');
Route::post('pedidos-pendientes/cancelar', 'PedidosPendientesController@cancelarPedido');
Route::get('pedidos-pendientes/exportar-gls', 'PedidosPendientesController@exportacionGLS');
/*
 * Pedidos Pospuestos
 */
Route::get('pedidos-pospuestos', 'PedidosPospuestosController@index');
Route::get('pedidos-pospuestos/search', 'PedidosPospuestosController@search');
Route::post('pedidos-pospuestos/pendientes', 'PedidosPospuestosController@enviarAPendientes');
Route::post('pedidos-pospuestos/cancelar', 'PedidosPendientesController@cancelarPedido');
/*
 * Pedidos Cancelados
 */
Route::get('pedidos-cancelados', 'PedidosCanceladosController@index');
Route::get('pedidos-cancelados/search', 'PedidosCanceladosController@search');
Route::post('pedidos-cancelados/pendientes', 'PedidosCanceladosController@enviarAPendientes');
Route::post('pedidos-cancelados/pospuestos', 'PedidosCanceladosController@enviarAPospuestos');
Route::post('pedidos-cancelados/delete', 'PedidosCanceladosController@deleteMultiple');
