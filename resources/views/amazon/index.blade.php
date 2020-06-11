<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/dt-1.10.21/r-2.2.5/sl-1.3.1/datatables.min.css"/>
    <link rel="stylesheet" href="/css/style.css">

    @yield('scripts')

    <title>Dashboard</title>
</head>

<body>
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">API AMAZON Curmasa</a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="#">Cerrar sesión</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link @if(Request::path() === 'amazon') active @endif" href="/amazon">
                            <span data-feather="home"></span>
                            Dashboard <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::path() === 'amazon/pedidos-pendientes') active @endif "
                           href="/amazon/pedidos-pendientes">
                            <span data-feather="file"></span>
                            Pedidos pendientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::path() === 'amazon/pedidos-pospuestos') active @endif "
                           href="/amazon/pedidos-pospuestos">
                            <span data-feather="clock"></span>
                            Pedidos pospuestos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" a
                           class="nav-link @if(Request::path() === 'amazon/pedidos-enviados') active @endif "
                           href="/amazon/pedidos-enviados">
                            <span data-feather="truck"></span>
                            Pedidos enviados
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" a
                           class="nav-link @if(Request::path() === 'amazon/pedidos-cancelados') active @endif "
                           href="/amazon/pedidos-cancelados">
                            <span data-feather="x-circle"></span>
                            Pedidos cancelados
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        @if(Request::path() === 'amazon')
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>
                <div class="row mt-3">
                    <div class="col-3 col-sm-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h5 class="card-title pb-2">
                                    <i class="fe fe-calendar mr-2"></i>
                                    Pedidos pendientes
                                </h5>
                                <h1 class="icon-xl mb-0">231</h1>
                            </div>
                            <div class="card-footer border-0 bg-success pt-0 d-flex justify-content-end">
                                <button class="btn btn-link text-white">
                                    ver todos <span data-feather="chevron-right"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 col-sm-3">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <h5 class="card-title pb-2">
                                    <i class="fas fa-car pr-2"></i>
                                    Pedidos enviados
                                </h5>
                                <h1 class="icon-xl mb-0">4987</h1>
                            </div>
                            <div class="card-footer border-0 bg-info pt-0 d-flex justify-content-end">
                                <button class="btn btn-link text-white">
                                    ver todos <span data-feather="chevron-right"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 col-sm-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body text-center">
                                <h5 class="card-title pb-2">
                                    <i class="fe fe-sliders mr-2"></i>
                                    Pedidos erróneos
                                </h5>
                                <h1 class="icon-xl mb-0">15</h1>
                            </div>
                            <div class="card-footer border-0 bg-danger pt-0 d-flex justify-content-end">
                                <button class="btn btn-link text-white">
                                    ver todos <span data-feather="chevron-right"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        @else
            @yield('content')
        @endif
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/dt-1.10.21/r-2.2.5/sl-1.3.1/datatables.min.js"></script>
@if(Request::path() === 'amazon/pedidos-pendientes')
    <script>
        $(document).ready(function () {

            const csrf_token = $('meta[name="csrf-token"]').attr('content');

            $('#importar-pedidos-buttton').click(function () {
                $('#importar-pedidos').modal('show');
                $($('#pedidosPendientesForm')).submit(function (e) {
                    e.preventDefault();
                    var fd = new FormData();
                    var files = $('#adjunto')[0].files[0];
                    fd.append('file', files);
                    $.ajax({
                        url: 'https://extranet.curmasa.info/amazon/pedidos-pendientes/importar',
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': csrf_token},
                        contentType: false,
                        processData: false,
                        data: fd,
                        success: function (result) {
                            $('#importar-pedidos').modal('hide');
                            window.location.href = 'https://extranet.curmasa.info/amazon/pedidos-pendientes';
                        }
                    })
                });
            });

            $('#confirmar-pedidos-button').click(function () {
                $('#confirmar-pedidos').modal('show');
                $($('#confirmarPedidosForm')).submit(function (e) {
                    e.preventDefault();
                    var fd = new FormData();
                    var files = $('#adjunto-gls')[0].files[0];
                    fd.append('file', files);
                    $.ajax({
                        url: 'https://extranet.curmasa.info/amazon/pedidos-pendientes/confirmar',
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': csrf_token},
                        xhrFields: {responseType: 'blob'},
                        contentType: false,
                        processData: false,
                        data: fd,
                        success: function (result) {
                            var a = document.createElement('a');
                            var url = window.URL.createObjectURL(result);
                            a.href = url;
                            a.download = 'confirmacion-pedidos-amazon' + Date.now() + '.tsv';
                            document.body.append(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(url);
                            $('#confirmar-pedidos').modal('hide');
                            window.location.href = 'https://extranet.curmasa.info/amazon/pedidos-pendientes';
                        }
                    })
                });
            });

            let table = $('#myTable').DataTable({
                responsive: true,
                processing: true,
                ajax: "https://extranet.curmasa.info/amazon/pedidos-pendientes/search",
                searching: false,
                ordering: true,
                paginate: false,
                columns: [
                    {data: "referencia"},
                    {data: "fecha"},
                    {data: "hora"},
                    {data: "producto"},
                    {data: "comprador"},
                    {data: "direccion"},
                    {data: "c_postal"},
                    {data: "telefono"},
                ],
                order: [[1, "asc"]],
                columnDefs: [
                    {
                        targets: 0,
                        checkboxes: {
                            selectRow: true
                        }
                    }
                ],
                select: {
                    style: 'multi'
                },
                retrieve: true,
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                }
            });

            $('#seleccionar-todos').change(function () {
                let checked = $(this).prop('checked');
                switch (checked) {
                    case true:
                        table.rows().select();
                        break;
                    case false:
                        table.rows().deselect();
                        break;
                }
            });

            $('#posponer-envio').click(function () {

                let selectedRows = table.rows({selected: true});

                let pedidosIds = [];

                $.map(selectedRows.data(), function (item) {
                    pedidosIds.push(item.id)
                });

                $.ajax({
                    url: 'https://extranet.curmasa.info/amazon/pedidos-pendientes/posponer',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': csrf_token},
                    data: {
                        pedidos: pedidosIds
                    },
                    success: function (result) {
                        window.location.href = 'https://extranet.curmasa.info/amazon/pedidos-pendientes';
                    }
                });
            });

            $('#cancelar-envio').click(function () {

                let selectedRows = table.rows({selected: true});

                let pedidosIds = [];

                $.map(selectedRows.data(), function (item) {
                    pedidosIds.push(item.id)
                });

                $.ajax({
                    url: 'https://extranet.curmasa.info/amazon/pedidos-pendientes/cancelar',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': csrf_token},
                    data: {
                        pedidos: pedidosIds
                    },
                    success: function (result) {
                        window.location.href = 'https://extranet.curmasa.info/amazon/pedidos-pendientes';
                    }
                });
            });
        });
    </script>
@elseif(Request::path() === 'amazon/pedidos-pospuestos')
    <script>
        $(document).ready(function () {
            const csrf_token = $('meta[name="csrf-token"]').attr('content');

            let table = $('#myTable').DataTable({
                responsive: true,
                processing: true,
                ajax: "https://extranet.curmasa.info/amazon/pedidos-pospuestos/search",
                searching: false,
                ordering: true,
                paginate: false,
                columns: [
                    {data: "referencia"},
                    {data: "fecha"},
                    {data: "hora"},
                    {data: "producto"},
                    {data: "comprador"},
                    {data: "direccion"},
                    {data: "c_postal"},
                    {data: "telefono"},
                ],
                order: [[1, "asc"]],
                columnDefs: [
                    {
                        targets: 0,
                        checkboxes: {
                            selectRow: true
                        }
                    }
                ],
                select: {
                    style: 'multi'
                },
                retrieve: true,
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                }
            });

            $('#seleccionar-todos').change(function () {
                let checked = $(this).prop('checked');
                switch (checked) {
                    case true:
                        table.rows().select();
                        break;
                    case false:
                        table.rows().deselect();
                        break;
                }
            });

            $('#pedidos-pendientes').click(function () {

                let selectedRows = table.rows({selected: true});

                let pedidosIds = [];

                $.map(selectedRows.data(), function (item) {
                    pedidosIds.push(item.id)
                });

                $.ajax({
                    url: 'https://extranet.curmasa.info/amazon/pedidos-pospuestos/pendientes',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': csrf_token},
                    data: {
                        pedidos: pedidosIds
                    },
                    success: function (result) {
                        window.location.href = 'https://extranet.curmasa.info/amazon/pedidos-pospuestos';
                    }
                });
            });

            $('#cancelar-envio').click(function () {

                let selectedRows = table.rows({selected: true});

                let pedidosIds = [];

                $.map(selectedRows.data(), function (item) {
                    pedidosIds.push(item.id)
                });

                $.ajax({
                    url: 'https://extranet.curmasa.info/amazon/pedidos-pospuestos/cancelar',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': csrf_token},
                    data: {
                        pedidos: pedidosIds
                    },
                    success: function (result) {
                        window.location.href = 'https://extranet.curmasa.info/amazon/pedidos-pospuestos';
                    }
                });
            });
        });
    </script>
    @endi
@elseif(Request::path() === 'amazon/pedidos-cancelados')
    <script>
        $(document).ready(function () {
            const csrf_token = $('meta[name="csrf-token"]').attr('content');

            let table = $('#myTable').DataTable({
                responsive: true,
                processing: true,
                ajax: "https://extranet.curmasa.info/amazon/pedidos-cancelados/search",
                searching: false,
                ordering: true,
                paginate: false,
                columns: [
                    {data: "referencia"},
                    {data: "fecha"},
                    {data: "hora"},
                    {data: "producto"},
                    {data: "comprador"},
                    {data: "direccion"},
                    {data: "c_postal"},
                    {data: "telefono"},
                ],
                order: [[1, "asc"]],
                columnDefs: [
                    {
                        targets: 0,
                        checkboxes: {
                            selectRow: true
                        }
                    }
                ],
                select: {
                    style: 'multi'
                },
                retrieve: true,
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                }
            });

            $('#seleccionar-todos').change(function () {
                let checked = $(this).prop('checked');
                switch (checked) {
                    case true:
                        table.rows().select();
                        break;
                    case false:
                        table.rows().deselect();
                        break;
                }
            });

            $('#pedidos-pendientes').click(function () {

                let selectedRows = table.rows({selected: true});

                let pedidosIds = [];

                $.map(selectedRows.data(), function (item) {
                    pedidosIds.push(item.id)
                });

                $.ajax({
                    url: 'https://extranet.curmasa.info/amazon/pedidos-cancelados/pendientes',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': csrf_token},
                    data: {
                        pedidos: pedidosIds
                    },
                    success: function (result) {
                        window.location.href = 'https://extranet.curmasa.info/amazon/pedidos-cancelados';
                    }
                });
            });

            $('#pedidos-pospuestos').click(function () {

                let selectedRows = table.rows({selected: true});

                let pedidosIds = [];

                $.map(selectedRows.data(), function (item) {
                    pedidosIds.push(item.id)
                });

                $.ajax({
                    url: 'https://extranet.curmasa.info/amazon/pedidos-cancelados/pospuestos',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': csrf_token},
                    data: {
                        pedidos: pedidosIds
                    },
                    success: function (result) {
                        window.location.href = 'https://extranet.curmasa.info/amazon/pedidos-cancelados';
                    }
                });
            });

            $('#eliminar-pedidos').click(function () {

                let selectedRows = table.rows({selected: true});

                let pedidosIds = [];

                $.map(selectedRows.data(), function (item) {
                    pedidosIds.push(item.id)
                });

                $.ajax({
                    url: 'https://extranet.curmasa.info/amazon/pedidos-cancelados/delete',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': csrf_token},
                    data: {
                        pedidos: pedidosIds
                    },
                    success: function (result) {
                        window.location.href = 'https://extranet.curmasa.info/amazon/pedidos-cancelados';
                    }
                });
            });
        });
    </script>
@endif
<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>
</body>
</html>


