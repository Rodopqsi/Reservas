<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aula;

class AulaController extends Controller
{
    public function __construct()
    {
        // En Laravel 12, el middleware se maneja de forma diferente
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aulas = Aula::paginate(10);
        return view('admin.aulas.index', compact('aulas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.aulas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:aulas',
            'capacidad' => 'required|integer|min:1',
            'descripcion' => 'nullable|string',
            'ubicacion' => 'nullable|string|max:255',
            'equipamiento' => 'nullable|array',
        ]);

        Aula::create($request->all());

        return redirect()->route('admin.aulas.index')
            ->with('success', 'Aula creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aula $aula)
    {
        return view('admin.aulas.show', compact('aula'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aula $aula)
    {
        return view('admin.aulas.edit', compact('aula'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aula $aula)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:aulas,codigo,' . $aula->id,
            'capacidad' => 'required|integer|min:1',
            'descripcion' => 'nullable|string',
            'ubicacion' => 'nullable|string|max:255',
            'equipamiento' => 'nullable|array',
        ]);

        $aula->update($request->all());

        return redirect()->route('admin.aulas.index')
            ->with('success', 'Aula actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aula $aula)
    {
        $aula->delete();

        return redirect()->route('admin.aulas.index')
            ->with('success', 'Aula eliminada exitosamente.');
    }
}
