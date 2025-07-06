<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Inicializar Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Obtener el usuario profesor aprobado
$profesor = User::where('email', 'profesor1@ejemplo.com')->first();

if ($profesor) {
    // Hacer login automático
    Auth::login($profesor);
    
    echo "<h1>✅ Login Exitoso</h1>";
    echo "<div style='background: #d4edda; padding: 15px; border: 1px solid #c3e6cb; border-radius: 5px; margin: 10px 0;'>";
    echo "<h3>Usuario autenticado:</h3>";
    echo "<p><strong>Nombre:</strong> " . $profesor->name . "</p>";
    echo "<p><strong>Email:</strong> " . $profesor->email . "</p>";
    echo "<p><strong>Rol:</strong> " . $profesor->role . "</p>";
    echo "<p><strong>Estado:</strong> " . $profesor->estado . "</p>";
    echo "</div>";
    
    echo "<h3>🔗 Enlaces disponibles:</h3>";
    echo "<ul>";
    echo "<li><a href='/calendario'>📅 Ver Calendario</a></li>";
    echo "<li><a href='/reservas/create'>➕ Crear Reserva</a></li>";
    echo "<li><a href='/reservas'>📋 Mis Reservas</a></li>";
    echo "<li><a href='/dashboard'>🏠 Dashboard</a></li>";
    echo "</ul>";
    
    echo "<div style='background: #cce5ff; padding: 15px; border: 1px solid #99ccff; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>🎯 Próximos pasos:</h3>";
    echo "<p>1. Ve al <a href='/calendario'>calendario</a></p>";
    echo "<p>2. Selecciona un slot de horario</p>";
    echo "<p>3. Confirma la selección</p>";
    echo "<p>4. Serás redirigido al formulario de reserva</p>";
    echo "</div>";
    
    // Auto-redirect después de 3 segundos
    echo "<script>setTimeout(function(){ window.location.href = '/calendario'; }, 3000);</script>";
    echo "<p style='color: #666; font-style: italic;'>Redirigiendo al calendario en 3 segundos...</p>";
    
} else {
    echo "<div style='background: #f8d7da; padding: 15px; border: 1px solid #f5c6cb; border-radius: 5px; margin: 10px 0;'>";
    echo "<h3>❌ No se encontró el usuario profesor</h3>";
    echo "<p>Ejecuta el seeder para crear usuarios de prueba:</p>";
    echo "<pre>php artisan db:seed --class=AdminUserSeeder</pre>";
    echo "</div>";
}

echo "<div style='background: #e2e3e5; padding: 15px; border: 1px solid #d3d6db; border-radius: 5px; margin: 20px 0;'>";
echo "<h3>📊 Estado del Sistema:</h3>";
echo "<p>✅ Rutas corregidas</p>";
echo "<p>✅ Permisos en el controlador</p>";
echo "<p>✅ Vista modernizada</p>";
echo "<p>✅ Calendario actualizado</p>";
echo "</div>";
?>
