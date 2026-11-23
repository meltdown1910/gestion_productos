<x-app-layout title="Editar producto">

    <div class="mb-4">
        <h2 class="fw-bold">Editar producto</h2>
        <p class="text-muted">
            Modifica la información de: {{ $product->name }}.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">

            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Nombre --}}
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nombre del producto</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $product->name) }}"
                            required
                        >

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Categoría --}}
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Categoría</label>
                        <select
                            name="category_id"
                            id="category_id"
                            class="form-select @error('category_id') is-invalid @enderror"
                            required
                        >
                            <option value="">Selecciona una categoría</option>

                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @selected(old('category_id', $product->category_id) == $category->id)
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div class="col-12">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea
                            name="description"
                            id="description"
                            rows="4"
                            class="form-control @error('description') is-invalid @enderror"
                            required
                        >{{ old('description', $product->description) }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Precio --}}
                    <div class="col-md-4">
                        <label for="price" class="form-label">Precio</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input
                                type="number"
                                name="price"
                                id="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $product->price) }}"
                                min="0.01"
                                step="0.01"
                                required
                            >
                        </div>

                        @error('price')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Existencias --}}
                    <div class="col-md-4">
                        <label for="stock" class="form-label">Existencias</label>
                        <input
                            type="number"
                            name="stock"
                            id="stock"
                            class="form-control @error('stock') is-invalid @enderror"
                            value="{{ old('stock', $product->stock) }}"
                            min="0"
                            step="1"
                            required
                        >

                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-4">
                        <label for="status" class="form-label">Estado</label>
                        <select
                            name="status"
                            id="status"
                            class="form-select @error('status') is-invalid @enderror"
                            required
                        >
                            <option value="">Selecciona un estado</option>

                            <option
                                value="available"
                                @selected(old('status', $product->status) === 'available')
                            >
                                Disponible
                            </option>

                            <option
                                value="out_of_stock"
                                @selected(old('status', $product->status) === 'out_of_stock')
                            >
                                Agotado
                            </option>
                        </select>

                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Guardar cambios
                    </button>

                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>
    </div>

</x-app-layout>
