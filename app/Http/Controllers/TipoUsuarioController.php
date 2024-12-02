<?php

namespace App\Http\Controllers;

use App\Models\TipoUsuario;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoUsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = TipoUsuario::query();

        if ($request->filled('criterio') && $request->filled('buscar')) {
            $criterio = $request->criterio;
            $buscar = $request->buscar;
            $query->where($criterio, 'like', "%$buscar%");
        }

        $tipoUsuarios = $query->paginate(10);

        return Inertia::render('TipoUsuario/Index', [
            'tipoUsuarios' => $tipoUsuarios
        ]);
    }

    public function create()
    {
        return Inertia::render('TipoUsuario/Create');
    }

    // En el controlador TipoUsuarioController
public function store(Request $request)
{
    $request->validate([
        'descripcion' => 'required|string|min:3|max:20|unique:TipoUsuario,descripcion',
    ]);

    // Crear el tipo de usuario
    $tipoUsuario = TipoUsuario::create([
        'descripcion' => $request->descripcion,
    ]);

    return redirect()->route('tipoUsuario.index')->with('success', 'Tipo de usuario registrado exitosamente.');
}

    public function edit($id)
    {
        $tipoUsuario = TipoUsuario::findOrFail($id);
        return Inertia::render('TipoUsuario/Edit', [
            'tipoUsuario' => $tipoUsuario
        ]);
    }

    public function update(Request $request, TipoUsuario $tipoUsuario)
    {
        // Validación de los datos
        $validated = $request->validate([
            'descripcion' => 'required|string|min:3|max:20',
        ]);
        $tipoUsuario->update($validated);
        return redirect()->route('tipoUsuario.index')->with('success', 'Tipo de usuario actualizado');
        
    }

    public function destroy($id)
    {
        TipoUsuario::destroy($id);
        return redirect()->route('tipoUsuario.index')->with('success', 'Tipo de usuario eliminado');
    }
}
