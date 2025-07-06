<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Aula;
use App\Models\Reserva;
use App\Models\User;

class TestSistema extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:sistema';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba completa del sistema de reservas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== PRUEBA COMPLETA DEL SISTEMA ===');
        $this->newLine();

        // Test 1: Verificar modelos
        $this->info('1. Verificando modelos...');
        try {
            $aulas = Aula::count();
            $reservas = Reserva::count();
            $usuarios = User::count();
            
            $this->line("   ✓ Aulas: $aulas registradas");
            $this->line("   ✓ Reservas: $reservas registradas");
            $this->line("   ✓ Usuarios: $usuarios registrados");
        } catch (\Exception $e) {
            $this->error("   ✗ Error en modelos: " . $e->getMessage());
        }

        // Test 2: Verificar rutas
        $this->newLine();
        $this->info('2. Verificando rutas principales...');
        $routes = [
            'calendario.index' => 'Calendario',
            'reservas.index' => 'Lista de reservas',
            'reservas.create' => 'Crear reserva',
            'admin.dashboard' => 'Panel admin'
        ];

        foreach ($routes as $route => $description) {
            try {
                $url = route($route);
                $this->line("   ✓ $description: $url");
            } catch (\Exception $e) {
                $this->error("   ✗ $description: Error");
            }
        }

        // Test 3: Verificar controladores
        $this->newLine();
        $this->info('3. Verificando controladores...');
        $controllers = [
            'App\Http\Controllers\CalendarioController' => 'CalendarioController',
            'App\Http\Controllers\ReservaController' => 'ReservaController',
            'App\Http\Controllers\Admin\DashboardController' => 'DashboardController'
        ];

        foreach ($controllers as $class => $name) {
            if (class_exists($class)) {
                $this->line("   ✓ $name: OK");
            } else {
                $this->error("   ✗ $name: No encontrado");
            }
        }

        // Test 4: Verificar políticas
        $this->newLine();
        $this->info('4. Verificando políticas...');
        if (class_exists('App\Policies\ReservaPolicy')) {
            $this->line("   ✓ ReservaPolicy: OK");
        } else {
            $this->error("   ✗ ReservaPolicy: No encontrada");
        }

        // Test 5: Verificar middleware
        $this->newLine();
        $this->info('5. Verificando middleware...');
        if (class_exists('App\Http\Middleware\EnsureUserIsAdmin')) {
            $this->line("   ✓ EnsureUserIsAdmin: OK");
        } else {
            $this->error("   ✗ EnsureUserIsAdmin: No encontrado");
        }

        // Test 6: Verificar vistas
        $this->newLine();
        $this->info('6. Verificando vistas principales...');
        $views = [
            'calendario.index' => 'Calendario principal',
            'reservas.index' => 'Lista de reservas',
            'reservas.create' => 'Crear reserva',
            'reservas.show' => 'Detalles de reserva',
            'admin.dashboard' => 'Panel administrativo'
        ];

        foreach ($views as $view => $description) {
            $viewPath = resource_path("views/" . str_replace('.', '/', $view) . ".blade.php");
            if (file_exists($viewPath)) {
                $this->line("   ✓ $description: OK");
            } else {
                $this->error("   ✗ $description: No encontrada");
            }
        }

        // Test 7: Verificar datos de prueba
        $this->newLine();
        $this->info('7. Verificando datos de prueba...');
        
        $adminUsers = User::where('role', 'admin')->count();
        $profesorUsers = User::where('role', 'profesor')->count();
        $aulasActivas = Aula::where('activo', true)->count();
        $reservasPendientes = Reserva::where('estado', 'pendiente')->count();

        $this->line("   ✓ Administradores: $adminUsers");
        $this->line("   ✓ Profesores: $profesorUsers");
        $this->line("   ✓ Aulas activas: $aulasActivas");
        $this->line("   ✓ Reservas pendientes: $reservasPendientes");

        // Test 8: Generar URLs de prueba
        $this->newLine();
        $this->info('8. URLs de acceso rápido:');
        $this->line("   • Calendario: " . route('calendario.index'));
        $this->line("   • Nueva reserva: " . route('reservas.create'));
        $this->line("   • Mis reservas: " . route('reservas.index'));
        $this->line("   • Panel admin: " . route('admin.dashboard'));
        $this->line("   • Diagnóstico: " . route('calendario.debug'));
        $this->line("   • Versión simple: " . route('calendario.simple'));

        $this->newLine();
        $this->info('=== PRUEBA COMPLETADA ===');
        $this->line('Sistema listo para usar. Accede a las URLs de arriba para probarlo.');
        
        return 0;
    }
}
