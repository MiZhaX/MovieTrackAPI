<?php

namespace App\Http\Controllers;

use App\Models\ProduccionLista;
use App\Http\Requests\StoreProduccionListaRequest;
use App\Http\Requests\UpdateProduccionListaRequest;
use App\Http\Resources\ProduccionListaCollection;
use App\Http\Resources\ProduccionListaResource;
use Illuminate\Http\Request;

class ProduccionListaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new ProduccionLista();
        $queryItems = $filter->transform($request);

        $produccionesListas = ProduccionLista::where($queryItems)
            ->with('listaPersonalizada')
            ->paginate()
            ->appends($request->query());

        return new ProduccionListaCollection($produccionesListas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProduccionListaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduccionListaRequest $request)
    {
        return new ProduccionListaResource(ProduccionLista::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProduccionLista  $produccionLista
     * @return \Illuminate\Http\Response
     */
    public function show(ProduccionLista $produccionLista)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProduccionLista  $produccionLista
     * @return \Illuminate\Http\Response
     */
    public function edit(ProduccionLista $produccionLista)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProduccionListaRequest  $request
     * @param  \App\Models\ProduccionLista  $produccionLista
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProduccionListaRequest $request, ProduccionLista $produccionLista)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProduccionLista  $produccionLista
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = request()->user();

        if (!$user || !$user->tokenCan('delete' || !$user->tokenCan('eliminarProduccionLista'))) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción'], 403);
        }

        $produccionEnLista = ProduccionLista::find($id);
        if (!$produccionEnLista) {
            return response()->json(['error' => 'Produccion en Lista no encontrada'], 404);
        }

        $produccionEnLista->delete();
        return response()->json(['message' => 'Produccion en Lista eliminada correctamente'], 200);
    }
}
