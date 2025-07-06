<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\User;

// Inicializar Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ACTUALIZANDO DATOS DE USUARIOS ===\n\n";

// Actualizar admin
$admin = User::where('email', 'admin@ejemplo.com')->first();
if($admin) {
    $admin->update(['estado' => 'aprobado']);
    echo "✓ Admin actualizado: {$admin->name}\n";
}

// Actualizar profesor 1
$prof1 = User::where('email', 'profesor1@ejemplo.com')->first();
if($prof1) {
    $prof1->update(['codigo_profesor' => 'PROF001', 'estado' => 'aprobado']);
    echo "✓ Profesor 1 actualizado: {$prof1->name} - PROF001 - aprobado\n";
}

// Actualizar profesor 2
$prof2 = User::where('email', 'profesor2@ejemplo.com')->first();
if($prof2) {
    $prof2->update(['codigo_profesor' => 'PROF002', 'estado' => 'pendiente']);
    echo "✓ Profesor 2 actualizado: {$prof2->name} - PROF002 - pendiente\n";
}

// Actualizar profesor 3
$prof3 = User::where('email', 'profesor3@ejemplo.com')->first();
if($prof3) {
    $prof3->update(['codigo_profesor' => 'PROF003', 'estado' => 'rechazado']);
    echo "✓ Profesor 3 actualizado: {$prof3->name} - PROF003 - rechazado\n";
}

echo "\n=== DATOS ACTUALIZADOS ===\n";
