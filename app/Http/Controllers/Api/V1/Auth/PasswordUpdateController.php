<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\PasswordUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Auth
 *
 * @authenticated
 */
class PasswordUpdateController extends Controller
{
    /**
     * Atualiza a senha do usuário autenticado.
     *
     * Este método recebe um objeto PasswordUpdateRequest que valida os dados de entrada.
     * Primeiro, ele verifica se a nova senha é a mesma que a senha atual. Se for, ele retorna uma resposta JSON com
     * uma mensagem de erro e um código de status HTTP 422 (Entidade Não Processável).
     * Se a nova senha for diferente da senha atual, ele atualiza a senha do usuário no banco de dados e retorna uma
     * resposta JSON com uma mensagem de sucesso e um código de status HTTP 202 (Aceito).
     *
     * @param  PasswordUpdateRequest  $request  O objeto de solicitação que contém os dados de entrada validados.
     * @return JsonResponse Uma resposta JSON que contém uma mensagem e um código de status HTTP.
     */
    public function __invoke(PasswordUpdateRequest $request)
    {
        $validatedData = $request->validated();
        $currentUser = auth()->user();

        if (Hash::check($validatedData['password'], $currentUser->password)) {
            return response()->json([
                'message' => 'The new password cannot be the same as the current password!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $currentUser->update([
            'password' => Hash::make($validatedData['password']),
        ]);

        return response()->json([
            'message' => 'Your Password Has Been Updated!',
        ], Response::HTTP_ACCEPTED);
    }
}
