<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ZoneResource;
use App\Models\Zone;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Zones
 *
 * @authenticated
 */
class ZoneController extends Controller
{
    use AuthorizesRequests;

    /**
     * Método para listar todas as zonas.
     *
     * Este método é responsável por retornar uma coleção de todas as zonas
     * existentes no banco de dados. Ele primeiro autoriza a ação 'viewAny' para
     * a classe Zone, o que significa que qualquer usuário, autenticado ou não,
     * tem permissão para ver a lista de zonas.
     *
     * Após a autorização, ele recupera todas as zonas do banco de dados usando
     * o método 'all' na classe 'Zone'. Em seguida, ele retorna essas zonas como
     * uma coleção de recursos 'ZoneResource', que transforma cada instância de
     * 'Zone' em um array formatado para a resposta da API.
     *
     * @return AnonymousResourceCollection Coleção de recursos de zonas.
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Zone::class);

        return ZoneResource::collection(Zone::all());
    }

    /*public function store(ZoneRequest $request): ZoneResource
    {
        $this->authorize('create', Zone::class);

        return new ZoneResource(Zone::create($request->validated()));
    }

    public function show(Zone $zone): ZoneResource
    {
        $this->authorize('view', $zone);

        return new ZoneResource($zone);
    }

    public function update(ZoneRequest $request, Zone $zone): ZoneResource
    {
        $this->authorize('update', $zone);

        $zone->update($request->validated());

        return new ZoneResource($zone);
    }

    public function destroy(Zone $zone): JsonResponse
    {
        $this->authorize('delete', $zone);

        $zone->delete();

        return response()->json();
    }*/
}
