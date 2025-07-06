<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reserva;

class ReservaPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reserva $reserva)
    {
        return $user->id === $reserva->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reserva $reserva)
    {
        return $user->id === $reserva->user_id && $reserva->estado === 'pendiente';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reserva $reserva)
    {
        return $user->id === $reserva->user_id && in_array($reserva->estado, ['pendiente', 'aprobada']);
    }
}
