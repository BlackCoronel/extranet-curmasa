@extends('amazon.index')

@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Pedidos Cancelados</h1>
        </div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <div class="pl-4">
                <input type="checkbox" class="form-check-input" id="seleccionar-todos">
                <label class="form-check-label text-primary" for="seleccionar-todos">Seleccionar todos</label>
            </div>
            <div>
                <button class="btn btn-link text-success" id="pedidos-pendientes">
                    <span data-feather="arrow-up-right"></span> Enviar a pedidos pendientes
                </button>    <button class="btn btn-link text-warning" id="pedidos-pospuestos">
                    <span data-feather="clock"></span> Enviar a pedidos pospuestos
                </button>
                <button class="btn btn-link text-danger" id="eliminar-pedidos">
                    <span data-feather="trash"></span> Eliminar pedidos
                </button>
            </div>
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
