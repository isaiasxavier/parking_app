<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Models\Scopes\Parking;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Apply a global scope to filter records by the current authenticated user.
 *
 * This scope ensures that queries on models using this scope are automatically filtered to only include records
 * associated with the current authenticated user's ID. It's particularly useful for multi-tenant applications where
 * data isolation between users is required.
 *
 * Usage:
 * In the boot method of your model, use `$this->addGlobalScope(new UserScope());` to apply it.
 */
class UserScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  Builder  $builder  The Eloquent query builder instance.
     * @param  Model  $model  The model instance.
     */
    public function apply(Builder $builder, Model $model): void
    {
        /*Log::info('User ID: '.auth()->id());*/
        $builder->where('user_id', auth()->id());
    }
}
