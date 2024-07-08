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
use App\Services\Api\V1\ParkingPriceService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @group Parking
 *
 * @authenticated
 */
class ParkingController extends Controller
{
    use AuthorizesRequests;

    /**
     * Inicia um estacionamento.
     *
     * Este método primeiro verifica se o usuário autenticado tem permissão para criar um veículo, usando o método
     * 'authorize' com a ação 'create' e a classe 'Parking'.
     *
     * Este método valida os dados da solicitação usando a classe ParkingRequest.
     * Se a validação passar, ele verifica se já existe um estacionamento ativo para o veículo especificado (através
     * do 'start_time') e se a coluna 'stop_time' é nula (o que significa que o veículo ainda nao finalizou o
     * estacionamento).
     * Se existir, ele retorna uma resposta JSON com um erro.
     * Se não existir, ele cria um novo registro de estacionamento e retorna uma resposta JSON com os dados do estacionamento.
     *
     * @param  ParkingRequest  $request  A solicitação HTTP.
     * @return ParkingResource|JsonResponse
     */
    public function start(ParkingRequest $request)
    {
        $this->authorize('create', Parking::class);

        $validatedData = $request->validated();

        if (Parking::active()->where('vehicle_id', $request->vehicle_id)->whereNull('stop_time')->exists()) {
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
     * Este método recebe um ID de estacionamento como parâmetro. O Laravel não resolve automaticamente o objeto Parking
     * através do mecanismo de injeção de dependência neste caso. Em vez disso, o método busca manualmente o estacionamento
     * correspondente no banco de dados usando o ID fornecido na rota.
     *
     * Se o estacionamento não for encontrado, o método retorna uma resposta JSON com um erro 404.
     * Se o estacionamento for encontrado, o método verifica se o usuário autenticado tem permissão para visualizá-lo.
     * Se o usuário não tiver permissão, o método retorna uma resposta JSON com um erro 403.
     * Se o usuário tiver permissão, o método retorna uma instância de ParkingResource, que é uma representação JSON do estacionamento.
     *
     * @param  int  $id  O ID do estacionamento a ser exibido.
     * @return ParkingResource|JsonResponse
     */
    public function show(int $id)
    {
        $parking = Parking::find($id);

        if (! $parking) {
            return response()->json([
                'errors' => ['general' => ['You don\'t Have a Parking With this ID to SHOW!']],
            ], ResponseAlias::HTTP_NOT_FOUND);
        }

        $this->authorize('view', $parking);

        return new ParkingResource($parking);
    }

    /**
     * Para o estacionamento.
     *
     * Este método recebe um ID de estacionamento como parâmetro. O Laravel não resolve automaticamente o objeto Parking
     * através do mecanismo de injeção de dependência neste caso. Em vez disso, o método busca manualmente o estacionamento
     * correspondente no banco de dados usando o ID fornecido na rota.
     *
     * Se o estacionamento não for encontrado, o método retorna uma resposta JSON com um erro 404.
     * Se o estacionamento for encontrado, o método verifica se o usuário autenticado tem permissão para atualizá-lo.
     * Se o usuário não tiver permissão, o método retorna uma resposta JSON com um erro 403.
     * Se o usuário tiver permissão, o método verifica se o estacionamento já foi parado (ou seja, se 'stop_time' não é nulo).
     * Se o estacionamento já foi parado, o método retorna uma resposta JSON com um erro 422.
     * Se o estacionamento não foi parado, o método atualiza o campo 'stop_time' do estacionamento para a hora atual e calcula o preço total.
     * Finalmente, o método retorna uma instância de ParkingResource, que é uma representação JSON do estacionamento.
     *
     * @param  int  $id  O ID do estacionamento a ser parado.
     * @return ParkingResource|JsonResponse
     */
    public function stop(int $id)
    {
        $parking = Parking::find($id);

        if (! $parking) {
            return response()->json([
                'errors' => ['general' => ['You don\'t Have a Parking With this ID to STOP!']],
            ], ResponseAlias::HTTP_NOT_FOUND);
        }

        if ($parking->stop_time !== null) {
            return response()->json([
                'errors' => ['general' => ['Parking already stopped.']],
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->authorize('update', $parking);

        $parking->update([
            'stop_time' => now(),
            'total_price' => ParkingPriceService::calculatePrice($parking->zone_id, $parking->start_time),
        ]);

        return new ParkingResource($parking);
    }

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Parking::class);

        $parkings = Parking::with(['zone', 'vehicle'])->get()->map(function ($parking) {
            if ($parking->stop_time === null) {
                $parking->total_price = ParkingPriceService::calculatePrice($parking->zone_id, $parking->start_time);
            } else {
                $parking->total_price = ParkingPriceService::calculatePrice($parking->zone_id, $parking->start_time, $parking->stop_time);
            }

            return $parking;
        });

        return ParkingResource::collection($parkings);
    }

    /*public function store(ParkingRequest $request): ParkingResource
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
