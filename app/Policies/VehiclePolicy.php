<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiclePolicy
{
    use HandlesAuthorization;

    /*public function viewAny(User $user): bool
    {
        $vehicle = Vehicle::class;

        // O usuário só pode ver a lista dos próprios veículos
        return $user->id === $vehicle->user_id;
    }*/
    public function viewOwn(User $user, Vehicle $vehicle): bool
    {
        // O usuário só pode ver o veículo se ele for o criador
        return $user->id === $vehicle->user_id;
    }

    public function view(User $user, Vehicle $vehicle): bool
    {
        // O usuário só pode ver os detalhes do veículo se ele for o criador
        return $user->id === $vehicle->user_id;
    }

    public function create(User $user): true
    {
        // Qualquer usuário autenticado pode criar um veículo
        return auth()->check();
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
