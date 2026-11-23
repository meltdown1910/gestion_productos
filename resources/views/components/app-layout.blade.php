@props(['title' => 'Gestión de Productos'])

@php
    $isAdmin = auth()->check() && auth()->user()->isAdmin();

    $theme = $isAdmin ? 'primary' : 'success';

    $roleName = $isAdmin ? 'Administrador' : 'Empleado';
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }} | Gestión de Productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-{{ $theme }} shadow">
        <div class="container">

            <a class="navbar-brand fw-bold" href="{{ route('products.index') }}">
                Gestión de Productos
            </a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">

                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">
                            Catálogo
                        </a>
                    </li>

                    @if ($isAdmin)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.create') }}">
                                Registrar producto
                            </a>
                        </li>
                    @endif
                </ul>

                <div class="d-flex align-items-center gap-3 text-white">
                    <div class="text-end">
                        <div class="fw-semibold">
                            {{ auth()->user()->name }}
                        </div>
                        <small>{{ $roleName }}</small>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">
                            Cerrar sesión
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    <main class="container py-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}

                <button type="button" class="btn-close"
                        data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}

                <button type="button" class="btn-close"
                        data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{ $slot }}

    </main>

    <footer class="text-center text-muted py-3">
        <small>Sistema de Gestión de Productos</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
