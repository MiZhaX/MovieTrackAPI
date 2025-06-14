<?php

namespace App\Http\Controllers;

use App\Filters\PersonaFilter;
use App\Models\Persona;
use App\Http\Requests\StorePersonaRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePersonaRequest;
use App\Http\Resources\PersonaCollection;
use App\Http\Resources\PersonaResource;
use Illuminate\Support\Facades\Validator;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new PersonaFilter();
        $queryItems = $filter->transform($request);

        $personas = Persona::where($queryItems);
        return new PersonaCollection($personas->paginate()->appends($request->query()));
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
     * @param  \App\Http\Requests\StorePersonaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonaRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('personas', 'public');
            $data['imagen'] = $path;
        }

        return new PersonaResource(Persona::create($data));
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
                'nombre' => 'required|string|max:255',
                'fecha_nacimiento' => 'required|date',
                'biografia' => 'required|string|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => "Error en el elemento $index",
                    'details' => $validator->errors()
                ], 422);
            }
        }

        $inserted = Persona::insert($data); 

        return response()->json(['message' => 'Personas insertadas correctamente.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $persona = Persona::with([
            'actores.produccion',
            'directores.produccion'
        ])->find($id); 
    
        if (!$persona) {
            return response()->json(['error' => 'Persona no encontrada'], 404);
        }
    
        return new PersonaResource($persona);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function edit(Persona $persona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePersonaRequest  $request
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonaRequest $request, $id)
    {
        //
        $persona = Persona::find($id);
        if (!$persona) {
            return response()->json(['error' => 'Persona no encontrada'], 404);
        }

        $validatedData = $request->validated();

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('personas', 'public');
            $validatedData['imagen'] = $path;
        }

        $persona->update($validatedData);

        return new PersonaResource($persona);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = request()->user();

        if (!$user || !$user->tokenCan('delete')) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción'], 403);
        }

        $persona = Persona::find($id);
        if (!$persona) {
            return response()->json(['error' => 'Persona no encontrada'], 404);
        }

        $persona->delete();
        return response()->json(['message' => 'Persona eliminada correctamente'], 200);
    }
}
