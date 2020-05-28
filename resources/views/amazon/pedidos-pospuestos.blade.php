@extends('amazon.index')

@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Pedidos Pospuestos</h1>
        </div>
        <div class="d-flex justify-content-end flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <button class="btn btn-link text-success" id="pedidos-pendientes">
                <span data-feather="arrow-up-right"></span> Enviar a pedidos pendientes
            </button>
            <button class="btn btn-link text-danger" id="cancelar-envio">
                <span data-feather="x-circle"></span> Cancelar pedido
            </button>
        </div>
        <div class="mt-3" style="width:100%;">
            <table class="table table-striped table-bordered" id="myTable" style="width:100%;">
                <thead>
                <tr>
                    <th>Ref. Amazon</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Producto</th>
                    <th>Comprador</th>
                    <th>Dirección</th>
                    <th>C. Postal</th>
                    <th>Teléfono</th>
                </tr>
                </thead>
            </table>
        </div>
    </main>
@endsection

