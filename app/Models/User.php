<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'codigo_profesor',
        'estado',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    /**
     * Relación con reservas
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
    
    /**
     * Relación con notificaciones
     */
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class);
    }
    
    /**
     * Obtener notificaciones no leídas
     */
    public function notificacionesNoLeidas()
    {
        return $this->notificaciones()->where('leida', false)->orderBy('created_at', 'desc');
    }
    
    /**
     * Verificar si el usuario es admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    /**
     * Verificar si el usuario es profesor
     */
    public function isProfesor()
    {
        return $this->role === 'profesor';
    }

    /**
     * Verificar si el usuario puede crear reservas
     */
    public function puedeReservar()
    {
        return $this->role === 'profesor';
    }

    /**
     * Verificar si el usuario puede asignar horarios
     */
    public function puedeAsignar()
    {
        return $this->role === 'admin';
    }

    /**
     * Verificar si el usuario está aprobado
     */
    public function estaAprobado()
    {
        return $this->estado === 'aprobado';
    }

    /**
     * Verificar si el usuario está pendiente
     */
    public function estaPendiente()
    {
        return $this->estado === 'pendiente';
    }

    /**
     * Verificar si el usuario está rechazado
     */
    public function estaRechazado()
    {
        return $this->estado === 'rechazado';
    }

    /**
     * Verificar si el usuario puede usar el sistema
     */
    public function puedeUsarSistema()
    {
        return $this->role === 'admin' || ($this->role === 'profesor' && $this->estaAprobado());
    }
}
