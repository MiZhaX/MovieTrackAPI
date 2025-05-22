<?php

namespace App\Http\Controllers;

use App\Filters\ActorFilter;
use App\Models\Actor;
use App\Http\Requests\StoreActorRequest;
use App\Http\Requests\UpdateActorRequest;
use App\Http\Resources\ActorCollection;
use App\Http\Resources\ActorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new ActorFilter();
        $queryItems = $filter->transform($request);

        $actores = Actor::where($queryItems)
            ->with('persona', 'produccion')
            ->paginate()
            ->appends($request->query());

        return new ActorCollection($actores);
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
     * @param  \App\Http\Requests\StoreActorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreActorRequest $request)
    {
        //
        return new ActorResource(Actor::create($request->all()));
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
                'persona_id' => 'required|exists:personas,id',
                'produccion_id' => 'required|exists:producciones,id',
                'rol' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => "Error en el elemento $index",
                    'details' => $validator->errors()
                ], 422);
            }
        }

        $inserted = Actor::insert($data);

        return response()->json(['message' => 'Actores insertados correctamente.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function show(Actor $actor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function edit(Actor $actor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateActorRequest  $request
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateActorRequest $request, $persona_id, $produccion_id)
    {
        $actor = Actor::where('persona_id', $persona_id)
            ->where('produccion_id', $produccion_id)
            ->first();

        if (!$actor) {
            return response()->json(['error' => 'Actor no encontrado'], 404);
        }

        $validatedData = $request->validated();

        $actor->fill($validatedData);
        $actor->save();

        return new ActorResource($actor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function destroy($persona_id, $produccion_id)
    {
        $user = request()->user();

        if (!$user || !$user->tokenCan('delete')) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción'], 403);
        }

        $deleted = Actor::where('persona_id', $persona_id)
            ->where('produccion_id', $produccion_id)
            ->delete();

        if ($deleted === 0) {
            return response()->json(['error' => 'Actor no encontrado'], 404);
        }

        return response()->json(['message' => 'Actor eliminado correctamente'], 200);
    }
}
