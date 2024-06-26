<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class LoginController
 *
 * Esta classe é responsável por autenticar um usuário no sistema.
 */
class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        /**
         * Handle the incoming request.
         *
         * Este método é responsável por autenticar o usuário e gerar um token de acesso.
         * Ele primeiro valida os dados da solicitação usando a classe 'LoginRequest'.
         * Em seguida, ele tenta encontrar um usuário com o e-mail fornecido.
         * Se o usuário não for encontrado ou a senha fornecida não corresponder à senha do usuário, uma exceção de validação é lançada.
         * Caso contrário, ele cria um token de acesso para o usuário.
         * O nome do dispositivo é extraído do agente do usuário sendo usado como o nome do token.
         * A data e hora de expiração do token são definidas com base na opção "Lembrar-me" selecionada pelo usuário.
         * Finalmente, ele retorna uma resposta JSON que inclui o token de acesso.
         *
         * @param  LoginRequest  $request  The incoming request.
         * @return JsonResponse A JSON response containing the access token.
         *
         * @throws ValidationException If the provided credentials are incorrect.
         */
        $validatedData = $request->validated();

        $user = User::where('email', $validatedData['email'])->first();

        if (! $user || ! Hash::check($validatedData['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $device = substr($request->userAgent() ?? '', 0, 255);
        $expiresAt = $request->remember ? null : now()->addMinutes((int) config('session.lifetime'));

        return response()->json([
            'access_token' => $user->createToken($device, expiresAt: $expiresAt)->plainTextToken,
        ], ResponseAlias::HTTP_CREATED);

    }
}
