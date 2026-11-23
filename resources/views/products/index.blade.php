
<x-app-layout title="Catálogo de productos">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Catálogo de productos</h2>
            <p class="text-muted mb-0">Consulta y administra los productos registrados.</p>
        </div>

        @if (auth()->user()->isAdmin())
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                + Nuevo producto
            </a>
        @endif
    </div>

    {{-- Filtros y ordenamiento --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Filtros y búsqueda</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('products.index') }}" method="GET">

                <div class="row g-3">

                    <div class="col-md-4">
                        <label for="search" class="form-label">Nombre</label>
                        <input
                            type="text"
                            name="search"
                            id="search"
                            class="form-control"
                            placeholder="Buscar producto..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="col-md-4">
                        <label for="category_id" class="form-label">Categoría</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">Todas las categorías</option>

                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @selected(request('category_id') == $category->id)
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="status" class="form-label">Estado</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Todos los estados</option>
                            <option value="available" @selected(request('status') === 'available')>
                                Disponible
                            </option>
                            <option value="out_of_stock" @selected(request('status') === 'out_of_stock')>
                                Agotado
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="price_min" class="form-label">Precio mínimo</label>
                        <input
                            type="number"
                            name="price_min"
                            id="price_min"
                            class="form-control"
                            min="0"
                            step="0.01"
                            value="{{ request('price_min') }}"
                        >
                    </div>

                    <div class="col-md-3">
                        <label for="price_max" class="form-label">Precio máximo</label>
                        <input
                            type="number"
                            name="price_max"
                            id="price_max"
                            class="form-control"
                            min="0"
                            step="0.01"
                            value="{{ request('price_max') }}"
                        >
                    </div>

                    <div class="col-md-3">
                        <label for="sort" class="form-label">Ordenar por</label>
                        <select name="sort" id="sort" class="form-select">
                            <option value="date_desc" @selected($sort === 'date_desc')>
                                Fecha: más recientes
                            </option>
                            <option value="date_asc" @selected($sort === 'date_asc')>
                                Fecha: más antiguos
                            </option>
                            <option value="name_asc" @selected($sort === 'name_asc')>
                                Nombre: A-Z
                            </option>
                            <option value="name_desc" @selected($sort === 'name_desc')>
                                Nombre: Z-A
                            </option>
                            <option value="price_asc" @selected($sort === 'price_asc')>
                                Precio: menor a mayor
                            </option>
                            <option value="price_desc" @selected($sort === 'price_desc')>
                                Precio: mayor a menor
                            </option>
                            <option value="stock_asc" @selected($sort === 'stock_asc')>
                                Existencias: menor a mayor
                            </option>
                            <option value="stock_desc" @selected($sort === 'stock_desc')>
                                Existencias: mayor a menor
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="per_page" class="form-label">Productos por página</label>
                        <select name="per_page" id="per_page" class="form-select">
                            @foreach ([10, 15, 25, 50] as $size)
                                <option value="{{ $size }}" @selected($perPage === $size)>
                                    {{ $size }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Aplicar filtros
                        </button>

                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            Limpiar filtros
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de productos --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Productos registrados</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Existencias</th>
                            <th>Estado</th>
                            <th>Fecha de registro</th>

                            @if (auth()->user()->isAdmin())
                                <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>

                                <td class="fw-semibold">
                                    {{ $product->name }}
                                </td>

                                <td>
                                    {{ \Illuminate\Support\Str::limit($product->description, 45) }}
                                </td>

                                <td>{{ $product->category->name }}</td>

                                <td>
                                    ${{ number_format((float) $product->price, 2) }}
                                </td>

                                <td>{{ $product->stock }}</td>

                                <td>
                                    @if ($product->status === 'available')
                                        <span class="badge bg-success">Disponible</span>
                                    @else
                                        <span class="badge bg-danger">Agotado</span>
                                    @endif
                                </td>

                                <td>{{ $product->created_at->format('d/m/Y') }}</td>

                                @if (auth()->user()->isAdmin())
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a
                                                href="{{ route('products.show', $product) }}"
                                                class="btn btn-info btn-sm text-white"
                                            >
                                                Ver
                                            </a>

                                            <a
                                                href="{{ route('products.edit', $product) }}"
                                                class="btn btn-warning btn-sm"
                                            >
                                                Editar
                                            </a>

                                            <form
                                                action="{{ route('products.destroy', $product) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Estás seguro de eliminar este producto?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="{{ auth()->user()->isAdmin() ? 9 : 8 }}"
                                    class="text-center text-muted py-4"
                                >
                                    No se encontraron productos.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- Información de paginación --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-3">

                <p class="text-muted mb-0">
                    Mostrando {{ $products->firstItem() ?? 0 }}
                    a {{ $products->lastItem() ?? 0 }}
                    de {{ $products->total() }} productos.
                    Página {{ $products->currentPage() }}
                    de {{ $products->lastPage() }}.
                </p>

                {{ $products->links('pagination::bootstrap-5') }}

            </div>

        </div>
    </div>

</x-app-layout>
