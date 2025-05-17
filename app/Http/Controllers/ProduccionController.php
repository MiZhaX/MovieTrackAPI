<?php

namespace App\Http\Controllers;

use App\Models\Produccion;
use App\Http\Requests\StoreProduccionRequest;
use App\Http\Requests\UpdateProduccionRequest;
use App\Http\Resources\ProduccionCollection;
use App\Filters\ProduccionFilter;
use App\Http\Resources\ProduccionResource;
use Illuminate\Http\Request;

class ProduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $filter = new ProduccionFilter();
        $queryItems = $filter->transform($request);

        $includeGeneros = $request->query('includeGeneros');

        $producciones = Produccion::where($queryItems);
        if($includeGeneros){
            $producciones = $producciones->with('genero');
        }
        return new ProduccionCollection($producciones->paginate()->appends($request->query()));
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
     * @param  \App\Http\Requests\StoreProduccionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduccionRequest $request)
    {
        //
        return new ProduccionResource(Produccion::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produccion = Produccion::find($id); 
        if (!$produccion) {
            return response()->json(['error' => 'Produccion no encontrada'], 404);
        }

        $includeGeneros = request()->query('includeGeneros');
        if ($includeGeneros) {
            $produccion->load('genero'); 
        }
        return new ProduccionResource($produccion);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produccion  $produccion
     * @return \Illuminate\Http\Response
     */
    public function edit(Produccion $produccion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProduccionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProduccionRequest $request, $id)
    {
        $produccion = Produccion::find($id);
        if (!$produccion) {
            return response()->json(['error' => 'Producción no encontrada'], 404);
        }

        $validatedData = $request->validated(); 
        $produccion->update($validatedData); 

        return new ProduccionResource($produccion); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = request()->user();

        if (!$user || !$user->tokenCan('delete')) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción'], 403);
        }

        $produccion = Produccion::find($id);
        if (!$produccion) {
            return response()->json(['error' => 'Producción no encontrada'], 404);
        }

        $produccion->delete();
        return response()->json(['message' => 'Producción eliminada correctamente'], 200);
    }
}
