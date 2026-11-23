<x-app-layout title="Detalles del producto">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Detalles del producto</h2>
            <p class="text-muted mb-0">
                Información completa del producto registrado.
            </p>
        </div>

        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            Volver al catálogo
        </a>
    </div>

    <div class="card shadow-sm">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $product->name }}</h5>

            @if ($product->status === 'available')
                <span class="badge bg-success">Disponible</span>
            @else
                <span class="badge bg-danger">Agotado</span>
            @endif
        </div>

        <div class="card-body p-4">

            <div class="row g-4">

                <div class="col-md-6">
                    <label class="form-label text-muted">ID del producto</label>
                    <p class="fw-semibold">{{ $product->id }}</p>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-muted">Nombre</label>
                    <p class="fw-semibold">{{ $product->name }}</p>
                </div>

                <div class="col-12">
                    <label class="form-label text-muted">Descripción</label>
                    <p>{{ $product->description }}</p>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-muted">Categoría</label>
                    <p class="fw-semibold">{{ $product->category->name }}</p>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-muted">Precio</label>
                    <p class="fw-semibold">
                        ${{ number_format((float) $product->price, 2) }}
                    </p>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-muted">Existencias</label>
                    <p class="fw-semibold">{{ $product->stock }}</p>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-muted">Estado</label>
                    <p>
                        @if ($product->status === 'available')
                            <span class="badge bg-success">Disponible</span>
                        @else
                            <span class="badge bg-danger">Agotado</span>
                        @endif
                    </p>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-muted">Fecha de registro</label>
                    <p class="fw-semibold">
                        {{ $product->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-muted">Última actualización</label>
                    <p class="fw-semibold">
                        {{ $product->updated_at->format('d/m/Y H:i') }}
                    </p>
                </div>

            </div>

            @if (auth()->user()->isAdmin())
                <hr class="my-4">

                <a
                    href="{{ route('products.edit', $product) }}"
                    class="btn btn-warning"
                >
                    Editar producto
                </a>
            @endif

        </div>
    </div>

</x-app-layout>
