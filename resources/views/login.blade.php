<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Amazon API Curmasa</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body class="img-fondo-login">
<div class="container">
    <form action="/login" method="POST">
        @csrf
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">
                            <img src="/img/logo-login.png" alt="" class="img-fluid w-25">
                        </h5>
                        <form class="form-signin">
                            <div class="form-label-group">
                                <label for="inputEmail">Email</label>
                                <input type="email" id="inputEmail" class="form-control" placeholder="ejemplo@ejemplo.com" name="email">
                            </div>
                            <div class="form-label-group">
                                <label for="inputPassword">Contraseña</label>
                                <input type="password" id="inputPassword" class="form-control" placeholder="Contraseña" name="password">
                            </div>
                            <button class="btn btn-lg btn-primary btn-block text-uppercase mt-3" type="submit">Inciar
                                sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>
