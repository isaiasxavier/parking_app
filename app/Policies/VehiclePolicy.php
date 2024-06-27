<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiclePolicy
{
    use HandlesAuthorization;

    public function viewAny(): true
    {
        // Qualquer usuário autenticado pode ver a lista de veículos
        return true;
    }

    public function view(User $user, Vehicle $vehicle): bool
    {
        // O usuário só pode ver os detalhes do veículo se ele for o criador
        return $user->id === $vehicle->user_id;
    }

    public function create(): true
    {
        // Qualquer usuário autenticado pode criar um veículo
        return true;
    }

    public function update(User $user, Vehicle $vehicle): bool
    {
        // O usuário só pode atualizar o veículo se ele for o criador
        return $user->id === $vehicle->user_id;
    }

    public function delete(User $user, Vehicle $vehicle): bool
    {
        // O usuário só pode excluir o veículo se ele for o criador
        return $user->id === $vehicle->user_id;
    }

    public function restore(User $user, Vehicle $vehicle): bool
    {
        // O usuário só pode restaurar o veículo se ele for o criador
        return $user->id === $vehicle->user_id;
    }

    public function forceDelete(User $user, Vehicle $vehicle): bool
    {
        // O usuário só pode forçar a exclusão do veículo se ele for o criador
        return $user->id === $vehicle->user_id;
    }
}
