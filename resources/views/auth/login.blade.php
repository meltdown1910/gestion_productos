<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión | Gestión de Productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-sm-10 col-md-7 col-lg-5">

                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h3 class="mb-1">Gestión de Productos</h3>
                        <p class="mb-0">Iniciar sesión</p>
                    </div>

                    <div class="card-body p-4">

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Correo electrónico
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control"
                                    value="{{ old('email') }}"
                                    placeholder="correo@ejemplo.com"
                                    required
                                    autofocus
                                >
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    Contraseña
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control"
                                    placeholder="Ingresa tu contraseña"
                                    required
                                >
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Iniciar sesión
                            </button>
                        </form>

                    </div>

                    <div class="card-footer text-center text-muted py-3">
                        Sistema de gestión de productos
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
