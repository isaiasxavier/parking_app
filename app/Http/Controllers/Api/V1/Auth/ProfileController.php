<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\ProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProfileController extends Controller
{
    /**
     * Exibe as informações do perfil do usuário autenticado.
     *
     * @return JsonResponse
     *
     * Este método retorna um JSON com os campos 'name' e 'email' do usuário autenticado.
     */
    public function show(Request $request): JsonResponse
    {
        return response()->json($request->user()->only('name', 'email'));
    }

    /**
     * Atualiza as informações do perfil do usuário autenticado.
     *
     * @return JsonResponse
     *
     * Este método valida os dados recebidos através do objeto ProfileRequest, atualiza as informações do usuário autenticado
     * e retorna um JSON com os dados validados e um código de status HTTP 202 (Aceito).
     */
    public function update(ProfileRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        auth()->user()->update($validatedData);

        return response()->json($validatedData, ResponseAlias::HTTP_ACCEPTED);
    }
}
