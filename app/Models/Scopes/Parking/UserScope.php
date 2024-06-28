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

class UserScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        /*Log::info('User ID: '.auth()->id());*/
        $builder->where('user_id', auth()->id());
    }
}
