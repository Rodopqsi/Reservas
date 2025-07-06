<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador si no existe
        if (!User::where('email', 'admin@ejemplo.com')->exists()) {
            User::create([
                'name' => 'Administrador',
                'email' => 'admin@ejemplo.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'estado' => 'aprobado',
            ]);
        }

        // Crear usuarios profesores de ejemplo si no existen
        if (!User::where('email', 'profesor1@ejemplo.com')->exists()) {
            User::create([
                'name' => 'Profesor Juan Pérez',
                'email' => 'profesor1@ejemplo.com',
                'password' => Hash::make('password'),
                'codigo_profesor' => 'PROF001',
                'role' => 'profesor',
                'estado' => 'aprobado',
            ]);
        }

        if (!User::where('email', 'profesor2@ejemplo.com')->exists()) {
            User::create([
                'name' => 'Profesora María García',
                'email' => 'profesor2@ejemplo.com',
                'password' => Hash::make('password'),
                'codigo_profesor' => 'PROF002',
                'role' => 'profesor',
                'estado' => 'pendiente',
            ]);
        }
    }
}
