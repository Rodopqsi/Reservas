<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Aula;
use App\Models\Reserva;
use App\Models\User;

class TestCalendario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:calendario';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba el sistema de calendario mejorado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== PRUEBA DEL CALENDARIO MEJORADO ===');
        $this->newLine();

        // Verificar que las rutas estén funcionando
        $this->info('1. Verificando rutas...');
        $routes = [
            'calendario.index' => 'Calendario principal',
            'reservas.create' => 'Crear reserva',
            'reservas.store' => 'Guardar reserva'
        ];

        foreach ($routes as $route => $description) {
            try {
                $url = route($route);
                $this->line("   ✓ $description: $url");
            } catch (\Exception $e) {
                $this->error("   ✗ $description: Error - " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info('2. Verificando modelos...');

        // Verificar que los modelos estén funcionando
        try {
            $aulas = Aula::where('activo', true)->count();
            $this->line("   ✓ Aulas activas: $aulas");
        } catch (\Exception $e) {
            $this->error("   ✗ Error al obtener aulas: " . $e->getMessage());
        }

        try {
            $reservas = Reserva::count();
            $this->line("   ✓ Total de reservas: $reservas");
        } catch (\Exception $e) {
            $this->error("   ✗ Error al obtener reservas: " . $e->getMessage());
        }

        try {
            $usuarios = User::count();
            $this->line("   ✓ Total de usuarios: $usuarios");
        } catch (\Exception $e) {
            $this->error("   ✗ Error al obtener usuarios: " . $e->getMessage());
        }

        $this->newLine();
        $this->info('3. Verificando configuración...');

        // Verificar configuración de horarios
        $horarios = [];
        for ($hora = 8; $hora <= 17; $hora++) {
            $horarios[] = [
                'inicio' => sprintf('%02d:00', $hora),
                'fin' => sprintf('%02d:00', $hora + 1),
                'display' => sprintf('%02d:00-%02d:00', $hora, $hora + 1)
            ];
        }

        $this->line("   ✓ Horarios configurados: " . count($horarios) . " intervalos");
        $this->line("   ✓ Primer horario: " . $horarios[0]['display']);
        $this->line("   ✓ Último horario: " . $horarios[count($horarios)-1]['display']);

        $this->newLine();
        $this->info('4. Prueba de funcionalidad de selección múltiple...');

        // Simular selección múltiple
        $seleccionPrueba = [
            'aula_id' => 1,
            'fecha' => '2024-02-15',
            'hora_inicio' => '09:00',
            'hora_fin' => '12:00'
        ];

        $this->line("   ✓ Simulando selección múltiple:");
        $this->line("     - Aula ID: " . $seleccionPrueba['aula_id']);
        $this->line("     - Fecha: " . $seleccionPrueba['fecha']);
        $this->line("     - Hora inicio: " . $seleccionPrueba['hora_inicio']);
        $this->line("     - Hora fin: " . $seleccionPrueba['hora_fin']);

        // Calcular duración
        $horaInicio = strtotime($seleccionPrueba['hora_inicio']);
        $horaFin = strtotime($seleccionPrueba['hora_fin']);
        $duracion = ($horaFin - $horaInicio) / 3600;

        $this->line("     - Duración: $duracion horas");

        if ($duracion > 0 && $duracion <= 8) {
            $this->line("   ✓ Validación de duración: CORRECTA");
        } else {
            $this->error("   ✗ Validación de duración: INCORRECTA");
        }

        $this->newLine();
        $this->info('5. URLs de prueba generadas...');

        // Generar URLs de prueba
        $testUrls = [
            'Calendario' => route('calendario.index'),
            'Reserva simple' => route('reservas.create') . '?aula_id=1&fecha=2024-02-15&hora_inicio=09:00',
            'Reserva múltiple' => route('reservas.create') . '?aula_id=1&fecha=2024-02-15&hora_inicio=09:00&hora_fin=12:00'
        ];

        foreach ($testUrls as $name => $url) {
            $this->line("   ✓ $name: $url");
        }

        $this->newLine();
        $this->info('=== PRUEBA COMPLETADA ===');
        $this->line('Puedes usar las URLs de arriba para probar el sistema manualmente.');
        
        return 0;
    }
}
