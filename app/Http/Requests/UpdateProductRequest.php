<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')->ignore($product),
            ],

            'description' => [
                'required',
                'string',
            ],

            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id'),
            ],

            'price' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in(['available', 'out_of_stock']),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del producto es obligatorio.',
            'name.unique' => 'Ya existe otro producto con ese nombre.',
            'description.required' => 'La descripción es obligatoria.',
            'category_id.required' => 'Debes seleccionar una categoría.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser numérico.',
            'price.gt' => 'El precio debe ser mayor que cero.',
            'stock.required' => 'Las existencias son obligatorias.',
            'stock.integer' => 'Las existencias deben ser un número entero.',
            'stock.min' => 'Las existencias no pueden ser negativas.',
            'status.required' => 'Debes seleccionar el estado del producto.',
            'status.in' => 'El estado seleccionado no es válido.',
        ];
    }
}
