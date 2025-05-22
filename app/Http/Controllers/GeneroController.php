<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use App\Http\Requests\StoreGeneroRequest;
use App\Http\Requests\UpdateGeneroRequest;
use App\Http\Resources\GeneroCollection;
use App\Http\Resources\GeneroResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class GeneroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $includeProducciones = $request->query('includeProducciones');

        $generos = $includeProducciones
            ? Genero::with('producciones')->paginate()
            : Genero::paginate();

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

    public function bulkStore(Request $request)
    {
        $user = request()->user();

        if (!$user || !$user->tokenCan('create')) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción'], 403);
        }

        $data = $request->all();

        // Validar que sea un array de elementos
        if (!is_array($data)) {
            return response()->json(['error' => 'El formato debe ser un array de objetos.'], 422);
        }

        foreach ($data as $index => $item) {
            $validator = Validator::make($item, [
                'nombre' => 'required|string|max:255|unique:generos,nombre',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => "Error en el elemento $index",
                    'details' => $validator->errors()
                ], 422);
            }
        }

        $inserted = Genero::insert($data); 

        return response()->json(['message' => 'Generos insertados correctamente.'], 201);
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
