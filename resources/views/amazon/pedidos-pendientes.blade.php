@extends('amazon.index')

@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Pedidos pendientes</h1>
        </div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <div class="pl-4">
                <input type="checkbox" class="form-check-input" id="seleccionar-todos">
                <label class="form-check-label text-primary" for="seleccionar-todos">Seleccionar todos</label>
            </div>
            <div>
                <button class="btn btn-link text-primary" id="importar-pedidos-buttton">
                    <span data-feather="file-plus"></span> Importar pedidos
                </button>
                <button class="btn btn-link text-warning" id="posponer-envio">
                    <span data-feather="clock"></span> Posponer envío
                </button>
                <button class="btn btn-link text-danger" id="cancelar-envio">
                    <span data-feather="x-circle"></span> Cancelar pedido
                </button>
                <a href="/amazon/pedidos-pendientes/exportar-gls" class="btn btn-link text-secondary">
                    <span data-feather="file-text"></span> Exportar pedidos GLS
                </a>
                <button class="btn btn-link text-success" id="Confirmar envíos">
                    <span data-feather="check"></span> Confirmar envíos
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
        <div class="modal" tabindex="-1" role="dialog" id="importar-pedidos">
            <form enctype="multipart/form-data" id="pedidosPendientesForm" method="post">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Importar pedidos Pendientes</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="adjunto">Documento pedidos pendientes</label>
                                <input type="file" id="adjunto" name="adjunto">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="importar">Importar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection
