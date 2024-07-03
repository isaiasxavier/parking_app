<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\UserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @group Auth
 *
 * @unauthenticated
 */
class RegisterController extends Controller
{
    public function __invoke(UserRequest $request)
    {
        /**
         * Handle the incoming request.
         *
         * Este método é responsável por registrar um novo usuário no sistema.
         * Ele primeiro valida os dados da solicitação usando a classe 'UserRequest'.
         * Em seguida, ele cria um novo usuário com os dados validados.
         * A senha do usuário é criptografada usando a função 'Hash::make'.
         * Em seguida, ele dispara um evento 'Registered' para o novo usuário.
         * O nome do dispositivo é extraído do agente do usuário sendo usado como o nome do token.
         * Finalmente, ele retorna uma resposta JSON que inclui o token de acesso.
         *
         * @param  UserRequest  $request  A solicitação recebida. Deve conter os dados do usuário a ser registrado.
         * @return JsonResponse Uma resposta JSON contendo o token de acesso do novo usuário.
         */
        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        event(new Registered($user));

        $device = substr($request->userAgent() ?? '', 0, 255);

        return response()->json([
            'access_token' => $user->createToken($device)->plainTextToken,
        ], ResponseAlias::HTTP_CREATED);
    }
}
