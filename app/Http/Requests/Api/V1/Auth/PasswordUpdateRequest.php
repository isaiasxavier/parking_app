<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest
{
    /**
     * Define as regras de validação para a solicitação de atualização de senha.
     *
     * Este método retorna um array associativo onde as chaves são os nomes dos campos de entrada e os valores são as
     * regras de validação para esses campos.
     *
     * O campo 'current_password' é obrigatório e deve ser a senha atual do usuário.
     * O campo 'password' é obrigatório e deve ser confirmado através do campo 'password_confirmation'.
     * A regra 'confirmed:api_reset_password' parece ser uma regra de validação personalizada que está sendo usada
     * para confirmar a nova senha.
     *
     * @return array As regras de validação para a solicitação de atualização de senha.
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
