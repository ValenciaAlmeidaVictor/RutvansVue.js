<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UnitSchedule;
use App\Models\Unit;
use App\Models\Locality;
use App\Models\Schedule;
use App\Models\Route;
use App\Models\Driver;
use App\Models\TicketDetail;
use App\Models\FareType;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ViajeComponent extends Component
{
    public function render()
    {
        return view('livewire.viaje-component');
    }

    // Obtener todos los viajes disponibles
    public function index()
    {
        $hoy = Carbon::today()->toDateString();

        $viajes = UnitSchedule::with([
                'unit.routeUnits.route.originLocality',
                'unit.routeUnits.route.destinationLocality',
                'unit.routeUnits.schedule',
                'unit.driver',
                'schedule'
            ])
            ->where('status', 'activo')
            ->where('day', $hoy)
            ->get()
            ->flatMap(function($unitSchedule) {
                return $unitSchedule->unit->routeUnits->map(function($routeUnit) use ($unitSchedule) {
                    if ($routeUnit->schedule_id == $unitSchedule->schedule->id) {
                        return [
                            'id' => $routeUnit->id,
                            'unit_schedule_id' => $unitSchedule->id,
                            'imagen' => asset('storage/units/' . $routeUnit->unit->unit_image),
                            'horaSalida' => $routeUnit->schedule->departure_time,
                            'origen' => $routeUnit->route->originLocality->locality,
                            'horaLlegada' => $routeUnit->schedule->arrival_time,
                            'destino' => $routeUnit->route->destinationLocality->locality,
                            'conductor' => $unitSchedule->driver->name ?? 'Conductor no asignado',
                            'modeloUnidad' => $routeUnit->unit->model,
                            'placas' => $routeUnit->unit->plate,
                            'capacidad' => $routeUnit->unit->capacitance,
                            'fecha' => $routeUnit->date,
                            'status' => $unitSchedule->status,
                            'day' => $unitSchedule->day
                        ];
                    }
                    return null;
                })->filter();
            })
            ->filter()
            ->values();

        return response()->json($viajes);
    }

    // Obtener asientos disponibles/ocupados para un viaje
    public function asientos($routeUnitId)
    {
        // Obtener los asientos ocupados
        $asientosOcupados = TicketDetail::whereHas('ticket', function($q) use ($routeUnitId) {
            $q->where('route_unit_id', $routeUnitId);
        })->pluck('seat_number')->toArray();

        // Obtener capacidad de la unidad
        $capacidad = RouteUnit::with('unit')
            ->findOrFail($routeUnitId)
            ->unit
            ->capacitance;

        // Generar todos los asientos
        $asientos = [];
        for ($i = 1; $i <= $capacidad; $i++) {
            $asientos[] = [
                'id' => $i,
                'seatNumber' => str_pad($i, 2, '0', STR_PAD_LEFT),
                'status' => in_array($i, $asientosOcupados) ? 'occupied' : 'available',
                'selected' => false
            ];
        }

        return response()->json($asientos);
    }

    // Obtener todos los tipos de tarifas
    public function tiposTarifas()
    {
        return response()->json(FareType::select(['id', 'name', 'percentage', 'description'])->get());
    }

    // Obtener información específica de un viaje
    public function getViajeInfo($routeUnitId)
    {
        $routeUnit = RouteUnit::with(['route', 'unit', 'schedule'])->findOrFail($routeUnitId);
        
        return response()->json([
            'precio_base' => $routeUnit->route->fare->base_price ?? 100,
            'origen' => $routeUnit->route->originLocality->name,
            'destino' => $routeUnit->route->destinationLocality->name,
            'fecha' => $routeUnit->date,
            'hora_salida' => $routeUnit->schedule->departure_time,
            'imagen' => asset('storage/units/' . $routeUnit->unit->unit_image)
        ]);
    }

    // Crear un nuevo ticket
    public function getTicket(Request $request)
    {
        $validated = $request->validate([
            'passenger_name' => 'required|string|max:255',
            'fare_type' => 'required|string',
            'seat_number' => 'required|integer',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'date' => 'required|date',
            'departure_time' => 'required',
            'base_price' => 'required|numeric',
            'discount' => 'required|numeric',
            'total' => 'required|numeric'
        ]);

        // Obtener el route_unit_id de la ruta
        $routeUnit = RouteUnit::where('date', $validated['date'])
            ->whereHas('schedule', function($q) use ($validated) {
                $q->where('departure_time', $validated['departure_time']);
            })
            ->firstOrFail();

        // Obtener el primer destino intermedio (ajustar según tu lógica)
        $intermediateDestination = IntermediateDestination::where('route_id', $routeUnit->route_id)
            ->firstOrFail();

        // Crear el ticket
        $ticket = Ticket::create([
            'passenger_name' => $validated['passenger_name'],
            'total' => $validated['total'],
            'route_unit_id' => $routeUnit->id,
            'schedule_id' => $routeUnit->schedule_id,
            'route_id' => $routeUnit->route_id,
            'intermediate_destination_id' => $intermediateDestination->id
        ]);

        // Obtener el tipo de tarifa
        $fareType = FareType::where('name', $validated['fare_type'])->firstOrFail();

        // Crear el detalle del ticket (asiento)
        TicketDetail::create([
            'seat_number' => $validated['seat_number'],
            'seat_price' => $validated['total'],
            'ticket_id' => $ticket->id,
            'fare_type_id' => $fareType->id
        ]);

        return response()->json([
            'message' => 'Ticket creado exitosamente',
            'ticket_id' => $ticket->id,
            'folio' => 'TKT-' . str_pad($ticket->id, 6, '0', STR_PAD_LEFT),
            'data' => [
                'passenger_name' => $validated['passenger_name'],
                'seat_number' => $validated['seat_number'],
                'origin' => $validated['origin'],
                'destination' => $validated['destination'],
                'date' => $validated['date'],
                'departure_time' => $validated['departure_time'],
                'total' => $validated['total']
            ]
        ], 201);
    }
}