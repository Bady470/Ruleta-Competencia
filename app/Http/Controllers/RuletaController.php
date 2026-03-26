<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RuletaController extends Controller
{
    /**
     * Mostrar la vista de la ruleta de equipos.
     */
    public function index()
    {
        return view('ruleta_equipos_completa');
    }

    public function puntaje()
    {
        return view('puntajes');
    }

    /**
     * Guardar los equipos en la sesión.
     * Esta ruta se llama vía AJAX desde la ruleta.
     */
    public function guardarEquipos(Request $request)
    {
        try {
            $equipos = $request->input('equipos', []);

            // Guardar en la sesión de forma persistente
            session(['equipos_formados' => $equipos]);

            // Forzar el guardado de la sesión
            session()->save();

            return response()->json([
                'success' => true,
                'message' => 'Equipos guardados correctamente',
                'equipos_count' => count($equipos)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar los equipos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar la vista de resultados con todos los equipos formados.
     */
    public function resultados(Request $request)
    {
        // Obtener los equipos de la sesión
        $equipos = session('equipos_formados', []);

        // Si no hay equipos, redirigir a la ruleta
        if (empty($equipos)) {
            return redirect('/')->with('error', 'No hay equipos formados aún');
        }

        return view('ruleta_resultados', compact('equipos'));
    }

    /**
     * Limpiar la sesión y reiniciar.
     */
    public function limpiar(Request $request)
    {
        session()->forget('equipos_formados');
        session()->save();

        return redirect('/')->with('success', 'Sesión limpiada correctamente');
    }

    /**
     * Exportar equipos a PDF (opcional).
     */
    public function exportarPDF()
    {
        $equipos = session('equipos_formados', []);

        if (empty($equipos)) {
            return redirect('/')->with('error', 'No hay equipos para exportar');
        }

        // Aquí puedes implementar la lógica de exportación a PDF
        // Por ahora, simplemente retornamos un JSON
        return response()->json($equipos);
    }

    /**
     * Exportar equipos a Excel (opcional).
     */
    public function exportarExcel()
    {
        $equipos = session('equipos_formados', []);

        if (empty($equipos)) {
            return redirect('/')->with('error', 'No hay equipos para exportar');
        }

        // Aquí puedes implementar la lógica de exportación a Excel
        // Por ahora, simplemente retornamos un JSON
        return response()->json($equipos);
    }
}
