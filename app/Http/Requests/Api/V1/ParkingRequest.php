<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParkingRequest extends FormRequest
{
    /**
     * Define as regras de validação para a solicitação.
     *
     * Este método retorna um array associativo onde as chaves são os nomes dos campos da solicitação e os valores
     * são as regras de validação para esses campos.
     *
     * As regras de validação para 'vehicle_id' e 'zone_id' são definidas para garantir que eles são obrigatórios e
     * são inteiros. Além disso, eles devem existir na tabela correspondente no banco de dados.
     *
     * Para 'vehicle_id', uma regra adicional é definida para garantir que o veículo pertence ao usuário autenticado e não foi excluído.
     *
     * @return array As regras de validação para a solicitação.
     */
    public function rules(): array
    {
        return [
            'vehicle_id' => ['required', 'integer',
                Rule::exists('vehicles', 'id')->where(function ($query) {
                    $query->where('deleted_at', null)
                        ->where('user_id', $this->user()->id);
                }), ],
            'zone_id' => ['required', 'integer', Rule::exists('zones', 'id')],
            /*'start_time' => ['nullable', 'date'],
            'stop_time' => ['nullable', 'date'],
            'total_price' => ['nullable', 'integer'],*/
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
