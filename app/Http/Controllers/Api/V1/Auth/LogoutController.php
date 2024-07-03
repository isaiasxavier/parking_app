<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

/**
 * @group Auth
 *
 * @authenticated
 */
class LogoutController extends Controller
{
    /**
     * Realiza o logout do usuário autenticado.
     *
     * Este método obtém o usuário autenticado através do helper 'auth()', e então deleta o token de acesso atual.
     * Após a deleção do token, ele retorna uma resposta HTTP com status 204 (No Content), indicando que a operação
     * foi bem-sucedida e não há conteúdo para retornar.
     *
     * @return Response Uma resposta HTTP com status 204.
     */
    public function __invoke()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
