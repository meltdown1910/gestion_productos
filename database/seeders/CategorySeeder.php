<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electrónica',
                'description' => 'Productos electrónicos y tecnológicos.',
            ],
            [
                'name' => 'Ropa',
                'description' => 'Prendas de vestir y accesorios.',
            ],
            [
                'name' => 'Alimentos',
                'description' => 'Productos alimenticios.',
            ],
            [
                'name' => 'Hogar',
                'description' => 'Artículos para el hogar.',
            ],
            [
                'name' => 'Papelería',
                'description' => 'Material escolar y de oficina.',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}
