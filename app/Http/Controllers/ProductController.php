<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Mostrar productos con filtros, ordenamiento y paginación.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Buscar por nombre.
        $query->when($request->filled('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        });

        // Filtrar por categoría.
        $query->when($request->filled('category_id'), function ($query) use ($request) {
            $query->where('category_id', $request->category_id);
        });

        // Filtrar por precio mínimo.
        $query->when($request->filled('price_min'), function ($query) use ($request) {
            $query->where('price', '>=', $request->price_min);
        });

        // Filtrar por precio máximo.
        $query->when($request->filled('price_max'), function ($query) use ($request) {
            $query->where('price', '<=', $request->price_max);
        });

        // Filtrar por estado.
        $query->when($request->filled('status'), function ($query) use ($request) {
            $query->where('status', $request->status);
        });

        // Opciones de ordenamiento permitidas.
        $sortOptions = [
            'name_asc' => ['name', 'asc'],
            'name_desc' => ['name', 'desc'],
            'price_asc' => ['price', 'asc'],
            'price_desc' => ['price', 'desc'],
            'stock_asc' => ['stock', 'asc'],
            'stock_desc' => ['stock', 'desc'],
            'date_asc' => ['created_at', 'asc'],
            'date_desc' => ['created_at', 'desc'],
        ];

        $sort = $request->input('sort', 'date_desc');

        if (array_key_exists($sort, $sortOptions)) {
            [$column, $direction] = $sortOptions[$sort];
            $query->orderBy($column, $direction);
        } else {
            $sort = 'date_desc';
            $query->orderBy('created_at', 'desc');
        }

        // Tamaño de página permitido.
        $allowedPageSizes = [10, 15, 25, 50];

        $perPage = (int) $request->input('per_page', 10);

        if (!in_array($perPage, $allowedPageSizes, true)) {
            $perPage = 10;
        }

        $products = $query->paginate($perPage)->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact(
            'products',
            'categories',
            'sort',
            'perPage'
        ));
    }

    /**
     * Mostrar formulario para crear un producto.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    /**
     * Guardar un producto nuevo.
     */
    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto registrado correctamente.');
    }

    /**
     * Mostrar un producto específico.
     */
    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }

    /**
     * Mostrar formulario para editar un producto.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Actualizar un producto.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Eliminar un producto.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
