<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ParkingRequest;
use App\Http\Resources\ParkingResource;
use App\Models\Parking;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ParkingController extends Controller
{
    use AuthorizesRequests;

    /**
     * Inicia um estacionamento.
     *
     * Este método valida os dados da solicitação usando a classe ParkingRequest.
     * Se a validação passar, ele verifica se já existe um estacionamento ativo para o veículo especificado.
     * Se existir, ele retorna uma resposta JSON com um erro.
     * Se não existir, ele cria um novo registro de estacionamento e retorna uma resposta JSON com os dados do estacionamento.
     *
     * @param  ParkingRequest  $request  A solicitação HTTP.
     * @return ParkingResource|JsonResponse
     */
    public function start(ParkingRequest $request)
    {
        $validatedData = $request->validated();

        if (Parking::active()->where('vehicle_id', $request->vehicle_id)->exists()) {
            return response()->json([
                'errors' => ['general' => ['Can\'t start parking twice using same vehicle. Please stop currently active parking.']],
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        $parking = Parking::create($validatedData);
        $parking->load('vehicle', 'zone');

        return new ParkingResource($parking);
    }

    /**
     * Exibe um estacionamento específico.
     *
     * Este método recebe um objeto Parking como parâmetro, que é automaticamente resolvido pelo Laravel
     * através do mecanismo de injeção de dependência. O Laravel automaticamente busca o estacionamento
     * correspondente no banco de dados usando o ID fornecido na rota.
     *
     * O método retorna uma instância de ParkingResource, que é uma representação JSON do estacionamento.
     * A classe ParkingResource é responsável por formatar a resposta JSON.
     *
     * @param  Parking  $parking  O estacionamento a ser exibido.
     * @return ParkingResource A resposta JSON.
     */
    public function show(Parking $parking): ParkingResource
    {
        return new ParkingResource($parking);
    }

    /**
     * Para o estacionamento.
     *
     * Este método recebe um objeto Parking como parâmetro, que é automaticamente resolvido pelo Laravel
     * através do mecanismo de injeção de dependência. O Laravel automaticamente busca o estacionamento
     * correspondente no banco de dados usando o ID fornecido na rota.
     *
     * O método atualiza o campo 'stop_time' do estacionamento para a hora atual, efetivamente parando o estacionamento.
     *
     * O método retorna uma instância de ParkingResource, que é uma representação JSON do estacionamento.
     * A classe ParkingResource é responsável por formatar a resposta JSON.
     *
     * @param  Parking  $parking  O estacionamento a ser parado.
     * @return ParkingResource A resposta JSON.
     */
    public function stop(Parking $parking): ParkingResource
    {
        $parking->update([
            'stop_time' => now(),
        ]);

        return new ParkingResource($parking);
    }

    /*public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Parking::class);

        return ParkingResource::collection(Parking::all());
    }

    public function store(ParkingRequest $request): ParkingResource
    {
        $this->authorize('create', Parking::class);

        return new ParkingResource(Parking::create($request->validated()));
    }

    public function show(Parking $parking): ParkingResource
    {
        $this->authorize('view', $parking);

        return new ParkingResource($parking);
    }

    public function update(ParkingRequest $request, Parking $parking): ParkingResource
    {
        $this->authorize('update', $parking);

        $parking->update($request->validated());

        return new ParkingResource($parking);
    }

    public function destroy(Parking $parking): JsonResponse
    {
        $this->authorize('delete', $parking);

        $parking->delete();

        return response()->json();
    }*/
}
