<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gestion.com'],
            [
                'name' => 'Administrador',
                'password' => 'Admin12345',
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'empleado@gestion.com'],
            [
                'name' => 'Empleado',
                'password' => 'Empleado12345',
                'role' => 'employee',
            ]
        );
    }
}
