<?php

namespace App\Http\Controllers;

use App\Filters\DirectorFilter;
use App\Models\Director;
use App\Http\Requests\StoreDirectorRequest;
use App\Http\Requests\UpdateDirectorRequest;
use App\Http\Resources\DirectorCollection;
use App\Http\Resources\DirectorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new DirectorFilter();
        $queryItems = $filter->transform($request);

        $directores = Director::where($queryItems)
            ->with('persona', 'produccion')
            ->paginate()
            ->appends($request->query());

        return new DirectorCollection($directores);
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
     * @param  \App\Http\Requests\StoreDirectorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDirectorRequest $request)
    {
        //
        return new DirectorResource(Director::create($request->all()));
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
                'produccion_id' => 'required|exists:producciones,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => "Error en el elemento $index",
                    'details' => $validator->errors()
                ], 422);
            }
        }

        $inserted = Director::insert($data); 

        return response()->json(['message' => 'Personas insertadas correctamente.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Director  $director
     * @return \Illuminate\Http\Response
     */
    public function show(Director $director)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Director  $director
     * @return \Illuminate\Http\Response
     */
    public function edit(Director $director)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDirectorRequest  $request
     * @param  \App\Models\Director  $director
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDirectorRequest $request, $persona_id, $produccion_id)
    {
        $director = Director::where('persona_id', $persona_id)
            ->where('produccion_id', $produccion_id)
            ->first();

        if (!$director) {
            return response()->json(['error' => 'Director no encontrado'], 404);
        }

        $validatedData = $request->validated();

        $director->fill($validatedData);
        $director->save();

        return new Director($director);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Director  $director
     * @return \Illuminate\Http\Response
     */
    public function destroy($persona_id, $produccion_id)
    {
        $user = request()->user();

        if (!$user || !$user->tokenCan('delete')) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción'], 403);
        }

        $deleted = Director::where('persona_id', $persona_id)
            ->where('produccion_id', $produccion_id)
            ->delete();

        if ($deleted === 0) {
            return response()->json(['error' => 'Director no encontrado'], 404);
        }

        return response()->json(['message' => 'Director eliminado correctamente'], 200);
    }
}
