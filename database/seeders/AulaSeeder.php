<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aula;

class AulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aulas = [
            [
                'nombre' => 'Aula Magna',
                'codigo' => 'AM-001',
                'descripcion' => 'Aula principal para conferencias y eventos especiales',
                'capacidad' => 200,
                'ubicacion' => 'Primer piso - Ala Norte',
                'equipamiento' => ['Proyector', 'Micrófono', 'Pantalla', 'Aire Acondicionado', 'WiFi'],
                'activo' => true,
            ],
            [
                'nombre' => 'Aula de Informática 1',
                'codigo' => 'INF-101',
                'descripcion' => 'Aula equipada con computadoras para clases de programación',
                'capacidad' => 30,
                'ubicacion' => 'Segundo piso - Ala Este',
                'equipamiento' => ['Computadora', 'Proyector', 'Pizarra', 'Aire Acondicionado', 'WiFi'],
                'activo' => true,
            ],
            [
                'nombre' => 'Aula de Informática 2',
                'codigo' => 'INF-102',
                'descripcion' => 'Aula equipada con computadoras para clases de programación',
                'capacidad' => 25,
                'ubicacion' => 'Segundo piso - Ala Este',
                'equipamiento' => ['Computadora', 'Proyector', 'Pizarra', 'Aire Acondicionado', 'WiFi'],
                'activo' => true,
            ],
            [
                'nombre' => 'Aula Teórica A',
                'codigo' => 'TEO-A01',
                'descripcion' => 'Aula para clases teóricas y seminarios',
                'capacidad' => 50,
                'ubicacion' => 'Primer piso - Ala Sur',
                'equipamiento' => ['Proyector', 'Pizarra', 'Pantalla', 'WiFi'],
                'activo' => true,
            ],
            [
                'nombre' => 'Aula Teórica B',
                'codigo' => 'TEO-B01',
                'descripcion' => 'Aula para clases teóricas y seminarios',
                'capacidad' => 45,
                'ubicacion' => 'Primer piso - Ala Sur',
                'equipamiento' => ['Proyector', 'Pizarra', 'Pantalla', 'WiFi'],
                'activo' => true,
            ],
            [
                'nombre' => 'Laboratorio de Física',
                'codigo' => 'FIS-LAB',
                'descripcion' => 'Laboratorio equipado para prácticas de física',
                'capacidad' => 20,
                'ubicacion' => 'Tercer piso - Ala Oeste',
                'equipamiento' => ['Proyector', 'Pizarra', 'WiFi', 'Sillas Ergonómicas'],
                'activo' => true,
            ],
            [
                'nombre' => 'Sala de Conferencias',
                'codigo' => 'CONF-001',
                'descripcion' => 'Sala moderna para conferencias y reuniones',
                'capacidad' => 15,
                'ubicacion' => 'Cuarto piso - Ala Central',
                'equipamiento' => ['Proyector', 'Pantalla', 'Micrófono', 'Aire Acondicionado', 'WiFi', 'Sillas Ergonómicas'],
                'activo' => true,
            ],
        ];

        foreach ($aulas as $aula) {
            Aula::create($aula);
        }
    }
}
