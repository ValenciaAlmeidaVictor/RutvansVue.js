<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function generatePDF($id)
    {
        try {
            // Obtener la venta por ID
            $venta = Venta::findOrFail($id);

            // Obtener los datos relacionados si los tienes
            $user = $venta->user_id ? \App\Models\User::find($venta->user_id) : null;
            $state = $venta->state_id ? 'Pendiente' : 'Completada'; // Ajusta según tu lógica
            $method = $venta->method_id ? 'Efectivo' : 'Tarjeta'; // Ajusta según tu lógica

            // Crear la instancia de Dompdf
            $dompdf = new Dompdf();

            // Configurar las opciones de Dompdf (por ejemplo, habilitar el uso de CSS en línea)
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true); // Necesario si quieres usar funciones PHP en el HTML
            $dompdf->setOptions($options);

            // Cargar la vista HTML para el PDF
            $html = view('ventas.pdf', compact('venta', 'user', 'state', 'method'))->render();

            // Cargar el HTML en Dompdf
            $dompdf->loadHtml($html);

            // Configurar el tamaño del papel y la orientación
            $dompdf->setPaper('A4', 'portrait');

            // Renderizar el PDF
            $dompdf->render();

            // Descargar el PDF
            return $dompdf->stream('venta_' . $venta->folio . '.pdf', ['Attachment' => 0]);
        } catch (\Exception $e) {
            // En caso de error, devolver un mensaje
            return response()->json(['error' => 'No se pudo generar el PDF: ' . $e->getMessage()], 500);
        }
    }

    public function index()
    {
        // Obtener todas las ventas desde la base de datos
        $ventas = Venta::with('user')->get();  // O cualquier lógica que tengas para obtener las ventas

        return response()->json($ventas); // Devolver las ventas como JSON
    }
}
