<?php

namespace App\Http\Controllers;

use App\Models\Produccion;
use App\Http\Requests\StoreProduccionRequest;
use App\Http\Requests\UpdateProduccionRequest;
use App\Http\Resources\ProduccionCollection;
use App\Filters\ProduccionFilter;
use App\Http\Resources\ProduccionResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

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
        $query = Produccion::query();

        $producciones = $filter->transformProduction($request, $query);
        $producciones = $producciones->with('genero');

        return new ProduccionCollection($producciones->paginate()->appends($request->query()));
    }

    /**
     * Display a listing of the top ten productions by Crítica.
     *
     * @return \Illuminate\Http\Response
     */
    public function topCritica(Request $request)
    {
        $filter = new ProduccionFilter();
        $queryItems = $filter->transform($request);

        $producciones = Produccion::where($queryItems)
            ->orderByDesc('puntuacion_critica')
            ->limit(10);

        if ($request->query('includeGeneros')) {
            $producciones->with('genero');
        }

        return ProduccionResource::collection($producciones->get());
    }

    /**
     * Obtiene las últimas 5 producciones estrenadas.
     *
     * @return \Illuminate\Http\Response
     */
    public function ultimosEstrenos(Request $request)
    {
        $filter = new ProduccionFilter();
        $queryItems = $filter->transform($request);

        $producciones = Produccion::where($queryItems)
            ->orderByDesc('fecha_estreno')
            ->limit(6);

        if ($request->query('includeGeneros')) {
            $producciones->with('genero');
        }

        return ProduccionResource::collection($producciones->get());
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
        $data = $request->all();

        if ($request->hasFile('poster')) {
            // Cloudinary
            $uploadedFileUrl = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($request->file('poster')->getRealPath(), [
                'folder' => 'posters'
            ])->getSecurePath();
            $data['poster'] = $uploadedFileUrl;
        }

        return new ProduccionResource(Produccion::create($data));
    }

    public function bulkStore(Request $request)
    {
        $user = request()->user();

        if (!$user || !$user->tokenCan('create')) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción'], 403);
        }

        $data = $request->all();

        if (!is_array($data)) {
            return response()->json(['error' => 'El formato debe ser un array de objetos.'], 422);
        }

        foreach ($data as $index => &$item) {
            $validator = Validator::make($item, [
                'titulo' => 'required|string|max:255',
                'tipo' => ['required', 'string', Rule::in(['pelicula', 'serie'])],
                'genero_id' => 'required|exists:generos,id',
                'sinopsis' => 'required|string|max:1000',
                'duracion' => 'required|integer|min:1',
                'fecha_estreno' => 'required|date',
                'poster' => 'required',
                'puntuacion_critica' => 'required|numeric|min:0|max:10',
                'puntuacion_usuarios' => 'required|numeric|min:0|max:5'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => "Error en el elemento $index",
                    'details' => $validator->errors()
                ], 422);
            }

            if (isset($item['poster']) && str_starts_with($item['poster'], 'data:image')) {
                $image = $item['poster'];
                $image = preg_replace('/^data:image\/\w+;base64,/', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = 'posters/' . uniqid() . '.png';
                \Illuminate\Support\Facades\Storage::disk('public')->put($imageName, base64_decode($image));
                $item['poster'] = $imageName;
            }
        }

        Produccion::insert($data);

        return response()->json(['message' => 'Producciones insertadas correctamente.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produccion = Produccion::with([
            'genero',
            'actores.persona',
            'directores.persona'
        ])->find($id);

        if (!$produccion) {
            return response()->json(['error' => 'Producción no encontrada'], 404);
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

        if ($request->hasFile('poster')) {
            $uploadedFileUrl = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($request->file('poster')->getRealPath(), [
                'folder' => 'posters'
            ])->getSecurePath();
            $validatedData['poster'] = $uploadedFileUrl;
        }

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
