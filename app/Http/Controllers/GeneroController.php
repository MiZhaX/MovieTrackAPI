<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use App\Http\Requests\StoreGeneroRequest;
use App\Http\Requests\UpdateGeneroRequest;
use App\Http\Resources\GeneroCollection;
use App\Http\Resources\GeneroResource;

class GeneroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $generos = Genero::paginate();
        return new GeneroCollection($generos);
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
     * @param  \App\Http\Requests\StoreGeneroRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGeneroRequest $request)
    {
        //
        return new GeneroResource(Genero::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Genero  $genero
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $genero = Genero::find($id); 
        if (!$genero) {
            return response()->json(['error' => 'Genero no encontrado'], 404);
        }

        return new GeneroResource($genero);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Genero  $genero
     * @return \Illuminate\Http\Response
     */
    public function edit(Genero $genero)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGeneroRequest  $request
     * @param  \App\Models\Genero  $genero
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGeneroRequest $request, $id)
    {
        //
        $genero = Genero::find($id);
        if (!$genero) {
            return response()->json(['error' => 'Genero no encontrado'], 404);
        }

        $validatedData = $request->validated(); 
        $genero->update($validatedData); 

        return new GeneroResource($genero); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Genero  $genero
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = request()->user();

        if (!$user || !$user->tokenCan('delete')) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción'], 403);
        }

        $genero = Genero::find($id);
        if (!$genero) {
            return response()->json(['error' => 'Género no encontrado'], 404);
        }

        if ($genero->producciones()->exists()) {
            return response()->json(['error' => 'El género está asociado a una o más producciones y no puede ser eliminado'], 400);
        }

        $genero->delete(); 
        return response()->json(['message' => 'Género eliminado correctamente'], 200);
    }
}
