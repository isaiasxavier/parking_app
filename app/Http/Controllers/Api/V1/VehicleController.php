<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreVehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class VehicleController extends Controller
{
    use AuthorizesRequests;

    /**
     * Exibe uma lista de todos os veículos.
     *
     * Este método usa a política 'viewAny' da classe 'VehiclePolicy' para verificar se o usuário autenticado tem
     * permissão para ver a lista de veículos.
     * Se o usuário tiver permissão, ele retorna uma coleção de todos os veículos no banco de dados, cada um
     * transformado em um 'VehicleResource'.
     *
     * @return AnonymousResourceCollection Uma coleção de recursos 'VehicleResource'.
     *
     * @throws AuthorizationException Se o usuário autenticado não tiver permissão para ver a lista de veículos.
     */
    public function index(): AnonymousResourceCollection
    {
        $vehicles = Vehicle::where('user_id', auth()->id())->get();

        foreach ($vehicles as $vehicle) {
            $this->authorize('viewOwn', $vehicle);
        }

        return VehicleResource::collection($vehicles);
    }

    /**
     * Armazena um novo veículo no banco de dados.
     *
     * Este método primeiro verifica se o usuário autenticado tem permissão para criar um veículo, usando o método
     * 'authorize' com a ação 'create' e a classe 'Vehicle'. Em seguida, ele valida os dados da solicitação usando a
     * classe 'StoreVehicleRequest'.
     *
     * Se os dados forem válidos, ele cria um novo veículo no banco de dados usando o método 'create' na classe
     * 'Vehicle', passando os dados validados.
     * Finalmente, ele retorna uma nova instância de 'VehicleResource', passando o veículo recém-criado.
     *
     * @param  StoreVehicleRequest  $request  A solicitação recebida. Deve conter os dados do veículo a ser criado.
     * @return VehicleResource Uma representação do veículo recém-criado.
     *
     * @throws AuthorizationException Se o usuário autenticado não tiver permissão para criar um veículo.
     */
    public function store(StoreVehicleRequest $request): VehicleResource
    {
        $this->authorize('create', Vehicle::class);

        return new VehicleResource(Vehicle::create($request->validated()));
    }

    /**
     * Exibe as informações de um veículo específico.
     *
     * Este método primeiro verifica se o usuário autenticado tem permissão para visualizar o veículo, usando o
     * método 'authorize' com a ação 'view' e o veículo específico.
     * Se o usuário tiver permissão, ele retorna uma nova instância de 'VehicleResource', passando o veículo específico.
     *
     * @param  Vehicle  $vehicle  O veículo a ser visualizado.
     * @return VehicleResource Uma representação do veículo.
     *
     * @throws AuthorizationException Se o usuário autenticado não tiver permissão para visualizar o veículo.
     */
    public function show(Vehicle $vehicle): VehicleResource
    {
        $this->authorize('view', $vehicle);

        return new VehicleResource($vehicle);
    }

    /**
     * Atualiza as informações de um veículo específico.
     *
     * Este método primeiro verifica se o usuário autenticado tem permissão para atualizar o veículo, usando o método
     * 'authorize' com a ação 'update' e o veículo específico.
     * Em seguida, ele valida os dados da solicitação usando a classe 'StoreVehicleRequest'.
     * Se os dados forem válidos, ele atualiza o veículo no banco de dados usando o método 'update' na instância do
     * veículo, passando os dados validados.
     * Finalmente, ele retorna uma resposta JSON com uma nova instância de 'VehicleResource', passando o veículo
     * atualizado, e um código de status HTTP 202 (Aceito).
     *
     * @param  StoreVehicleRequest  $request  A solicitação recebida. Deve conter os novos dados do veículo.
     * @param  Vehicle  $vehicle  O veículo a ser atualizado.
     * @return JsonResponse Uma resposta JSON contendo a representação do veículo atualizado e um código de status HTTP 202.
     *
     * @throws AuthorizationException Se o usuário autenticado não tiver permissão para atualizar o veículo.
     */
    public function update(StoreVehicleRequest $request, Vehicle $vehicle): JsonResponse
    {
        $this->authorize('update', $vehicle);

        $vehicle->update($request->validated());

        return response()->json(new VehicleResource($vehicle), Response::HTTP_ACCEPTED);
        /*return new VehicleResource($vehicle);*/
    }

    /**
     * Deleta um veículo específico.
     *
     * Este método primeiro verifica se o usuário autenticado tem permissão para deletar o veículo, usando o método
     * 'authorize' com a ação 'delete' e o veículo específico.
     * Se o usuário tiver permissão, ele deleta o veículo do banco de dados usando o método 'delete' na instância do veículo.
     * Finalmente, ele retorna uma resposta HTTP com status 204 (No Content), indicando que a operação foi
     * bem-sucedida e não há conteúdo para retornar.
     *
     * @param  Vehicle  $vehicle  O veículo a ser deletado.
     * @return \Illuminate\Http\Response Uma resposta HTTP com status 204.
     *
     * @throws AuthorizationException Se o usuário autenticado não tiver permissão para deletar o veículo.
     */
    public function destroy(Vehicle $vehicle): \Illuminate\Http\Response
    {
        $this->authorize('delete', $vehicle);

        $vehicle->delete();

        return response()->noContent();
    }
}
