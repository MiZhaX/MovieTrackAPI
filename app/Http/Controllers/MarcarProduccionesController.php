<?php

namespace App\Http\Controllers;

use App\Filters\MarcarProduccionesFilter;
use App\Models\MarcarProducciones;
use App\Http\Requests\StoreMarcarProduccionesRequest;
use App\Http\Requests\UpdateMarcarProduccionesRequest;
use App\Http\Resources\MarcarProduccionesCollection;
use App\Http\Resources\MarcarProduccionesResource;
use Database\Factories\MarcarProduccionesFactory;
use Illuminate\Http\Request;

class MarcarProduccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new MarcarProduccionesFilter();
        $queryItems = $filter->transform($request);

        $marcas = MarcarProducciones::where($queryItems)
            ->with('usuario', 'produccion')
            ->paginate()
            ->appends($request->query());

        return new MarcarProduccionesCollection($marcas);
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
     * @param  \App\Http\Requests\StoreMarcarProduccionesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMarcarProduccionesRequest $request)
    {
        return new MarcarProduccionesResource(MarcarProducciones::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MarcarProducciones  $marcarProducciones
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = request()->user();
        $marcarProducciones = MarcarProducciones::with([
            'usuario',
            'produccion'
        ])->find($id);

        if ($marcarProducciones->usuario_id != $user->id) {
            return response()->json(['error' => 'Esta marca no pertenece a tu usuario'], 403);
        }

        if (!$marcarProducciones) {
            return response()->json(['error' => 'Marca no encontrada'], 404);
        }

        return new MarcarProduccionesResource($marcarProducciones);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MarcarProducciones  $marcarProducciones
     * @return \Illuminate\Http\Response
     */
    public function edit(MarcarProducciones $marcarProducciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMarcarProduccionesRequest  $request
     * @param  \App\Models\MarcarProducciones  $marcarProducciones
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMarcarProduccionesRequest $request, $id)
    {
        $user = request()->user();
        $marca = MarcarProducciones::find($id);
        if (!$marca) {
            return response()->json(['error' => 'Marca no encontrada'], 404);
        }

        if (!$user->tokenCan('create')) {
            if ($marca->usuario_id != $user->id) {
                return response()->json(['error' => 'Esta marca no pertenece a tu usuario'], 403);
            }
        }

        $validatedData = $request->validated();
        $marca->update($validatedData);

        return new MarcarProduccionesResource($marca);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MarcarProducciones  $marcarProducciones
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = request()->user();

        if (!$user || !$user->tokenCan('delete')) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción'], 403);
        }

        $marca = MarcarProducciones::find($id);
        if (!$marca) {
            return response()->json(['error' => 'Marca no encontrada'], 404);
        }

        $marca->delete();
        return response()->json(['message' => 'Marca eliminada correctamente'], 200);
    }
}
