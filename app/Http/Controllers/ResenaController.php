<?php

namespace App\Http\Controllers;

use App\Filters\ResenaFilter;
use App\Models\Resena;
use App\Http\Requests\StoreResenaRequest;
use App\Http\Requests\UpdateResenaRequest;
use App\Http\Resources\ResenaCollection;
use App\Http\Resources\ResenaResource;
use Illuminate\Http\Request;

class ResenaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new ResenaFilter();
        $queryItems = $filter->transform($request);

        $includeDetalles = $request->query('includeDetalles');

        $resenas = $includeDetalles
            ? Resena::where($queryItems)->with('usuario', 'produccion')->paginate()->appends($request->query())
            : Resena::where($queryItems)->paginate()->appends($request->query());

        return new ResenaCollection($resenas);
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
     * @param  \App\Http\Requests\StoreResenaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResenaRequest $request)
    {
        //
        return new ResenaResource(Resena::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resena  $resena
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $includeDetalles = $request->query('includeDetalles');

        $resena = $includeDetalles
            ? Resena::with('usuario', 'produccion')->find($id)
            : Resena::find($id);

        if (!$resena) {
            return response()->json(['error' => 'Reseña no encontrada'], 404);
        }

        return new ResenaResource($resena);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resena  $resena
     * @return \Illuminate\Http\Response
     */
    public function edit(Resena $resena)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateResenaRequest  $request
     * @param  \App\Models\Resena  $resena
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResenaRequest $request, $id)
    {
        //
        $resena = Resena::find($id);
        if (!$resena) {
            return response()->json(['error' => 'Reseña no encontrada'], 404);
        }

        $validatedData = $request->validated(); 
        $resena->update($validatedData); 

        return new ResenaResource($resena);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resena  $resena
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = request()->user();

        if (!$user || !$user->tokenCan('delete')) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción'], 403);
        }

        $resena = Resena::find($id);
        if (!$resena) {
            return response()->json(['error' => 'Reseña no encontrada'], 404);
        }

        $resena->delete();
        return response()->json(['message' => 'Reseña eliminada correctamente'], 200);
    }
}
