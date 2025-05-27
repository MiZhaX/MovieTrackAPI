<?php

namespace App\Http\Controllers;

use App\Filters\ListaPersonalizadaFilter;
use App\Models\ListaPersonalizada;
use App\Http\Requests\StoreListaPersonalizadaRequest;
use App\Http\Requests\UpdateListaPersonalizadaRequest;
use App\Http\Resources\ListaPersonalizadaCollection;
use App\Http\Resources\ListaPersonalizadaResource;
use Illuminate\Http\Request;

class ListaPersonalizadaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new ListaPersonalizadaFilter();
        $queryItems = $filter->transform($request);

        $user = $request->user();

        if($user->tokenCan('create')){
            $listas = ListaPersonalizada::where($queryItems)
                ->with('usuario')
                ->paginate()
                ->appends($request->query());
        } else {
            $listas = ListaPersonalizada::where($queryItems)
                ->where('usuario_id', $user->id)
                ->with('usuario')
                ->paginate()
                ->appends($request->query());
        }
        
        return new ListaPersonalizadaCollection($listas);
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
     * @param  \App\Http\Requests\StoreListaPersonalizadaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreListaPersonalizadaRequest $request)
    {
        return new ListaPersonalizadaResource(ListaPersonalizada::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ListaPersonalizada  $listaPersonalizada
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = request()->user();
        $lista = ListaPersonalizada::with([
            'produccionesListas'
        ])->find($id); 

        if (!$lista) {
            return response()->json(['error' => 'Lista no encontrada'], 404);
        }

        if ($lista->usuario_id != $user->id) {
            return response()->json(['error' => 'Esta lista no pertenece a tu usuario'], 403);
        }
    
        return new ListaPersonalizadaResource($lista);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ListaPersonalizada  $listaPersonalizada
     * @return \Illuminate\Http\Response
     */
    public function edit(ListaPersonalizada $listaPersonalizada)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateListaPersonalizadaRequest  $request
     * @param  \App\Models\ListaPersonalizada  $listaPersonalizada
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateListaPersonalizadaRequest $request, $id)
    {
        $user = request()->user();
        $lista = ListaPersonalizada::find($id);
        if (!$lista) {
            return response()->json(['error' => 'Lista no encontrada'], 404);
        }

        if(!$user->tokenCan('create')){
            if ($lista->usuario_id != $user->id) {
                return response()->json(['error' => 'Esta lista no pertenece a tu usuario'], 403);
            }
        }

        $validatedData = $request->validated(); 
        $lista->update($validatedData); 

        return new ListaPersonalizadaResource($lista); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ListaPersonalizada  $listaPersonalizada
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = request()->user();

        if (!$user || !$user->tokenCan('delete')) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción'], 403);
        }

        $lista = ListaPersonalizada::find($id);
        if (!$lista) {
            return response()->json(['error' => 'Lista no encontrada'], 404);
        }

        $lista->delete();
        return response()->json(['message' => 'Lista eliminada correctamente'], 200);
    }
}
