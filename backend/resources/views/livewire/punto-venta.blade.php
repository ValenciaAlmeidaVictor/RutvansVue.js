{{-- resources/views/punto-venta/index.blade.php --}}

@extends('adminlte::page')

@section('title', 'Punto de Venta - Combis')

@section('content_header')
    <h1 class="text-center text-primary"><i class="fas fa-cash-register"></i> Punto de Venta - Combis</h1>
@endsection

@section('content')
<div class="row">
    <!-- Selección de Ruta -->
    <div class="col-md-4">
        <div class="card shadow-lg">
            <div class="card-header bg-gradient-blue text-white">
                <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Selección de Ruta</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Origen:</label>
                    <select id="origin_locality_id" class="form-control">
                        @foreach ($rutas as $ruta)
                            <option value="{{ $ruta->origin_locality_id }}">
                                {{ $ruta->originLocality ? $ruta->originLocality->name : 'Desconocido' }} <!-- Verificación de null -->
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Destino:</label>
                    <select id="destination_locality_id" class="form-control">
                        @foreach ($rutas as $ruta)
                            <option value="{{ $ruta->destination_locality_id }}">
                                {{ $ruta->destinationLocality ? $ruta->destinationLocality->name : 'Desconocido' }} <!-- Verificación de null -->
                            </option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary btn-block" id="buscarRutas"><i class="fas fa-search"></i> Buscar</button>
            </div>
        </div>
    </div>

    <!-- Selección de Asiento (Proceso Administrativo) -->
    <div class="col-md-4">
        <div class="card shadow-lg">
            <div class="card-header bg-gradient-purple text-white">
                <h3 class="card-title"><i class="fas fa-chair"></i> Selección de Asiento</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Unidad Disponible:</label>
                    <select id="unidad" class="form-control">
                        <!-- Opciones dinámicas -->
                    </select>
                </div>
                <div class="form-group">
                    <label>Selecciona un Número de Asiento:</label>
                    <select id="asiento" class="form-control">
                        <!-- Opciones dinámicas de números de asientos -->
                    </select>
                </div>
                <button class="btn btn-success btn-block" id="reservarAsiento"><i class="fas fa-check"></i> Reservar Asiento</button>
            </div>
        </div>
    </div>

    <!-- Métodos de Pago -->
    <div class="col-md-4">
        <div class="card shadow-lg">
            <div class="card-header bg-gradient-orange text-white">
                <h3 class="card-title"><i class="fas fa-credit-card"></i> Métodos de Pago</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Selecciona un método:</label><br>
                    <div>
                        <input type="checkbox" id="efectivo" name="metodoPago" value="Efectivo"> Efectivo
                    </div>
                    <div>
                        <input type="checkbox" id="tarjetaCredito" name="metodoPago" value="Tarjeta de Crédito"> Tarjeta de Crédito
                    </div>
                    <div>
                        <input type="checkbox" id="transferencia" name="metodoPago" value="Transferencia"> Transferencia
                    </div>
                </div>
                <button class="btn btn-warning btn-block" id="procederPago"><i class="fas fa-dollar-sign"></i> Proceder al Pago</button>
            </div>
        </div>
    </div>
</div>

<!-- Carrito de Boletos -->
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card shadow-lg">
            <div class="card-header bg-gradient-dark text-white">
                <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Carrito de Asientos</h3>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="bg-gradient-secondary text-white">
                        <tr>
                            <th>Ruta</th>
                            <th>Unidad</th>
                            <th>Asiento</th>
                            <th>Métodos de Pago</th>
                            <th>Precio</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="carrito">
                        <!-- Filas dinámicas -->
                    </tbody>
                </table>
                <h4 class="text-right text-dark">Total: <span id="total" class="text-primary">$0.00</span></h4>
                <button class="btn btn-success btn-block mt-2" id="confirmarVenta"><i class="fas fa-check-circle"></i> Confirmar Venta</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    let carrito = [];
    let precioBoleto = 150;
    let unidadesDisponibles = [
        { id: 1, nombre: 'Unidad 1', asientosDisponibles: [1, 2, 3, 4, 5] },
        { id: 2, nombre: 'Unidad 2', asientosDisponibles: [1, 2, 3, 4, 5] },
        { id: 3, nombre: 'Unidad 3', asientosDisponibles: [1, 2, 3, 4, 5] }
    ];

    function cargarUnidades() {
        let selectUnidad = document.getElementById('unidad');
        selectUnidad.innerHTML = '';
        unidadesDisponibles.forEach(unidad => {
            let option = document.createElement('option');
            option.value = unidad.id;
            option.textContent = unidad.nombre;
            selectUnidad.appendChild(option);
        });
    }

    function cargarAsientos() {
        let selectAsiento = document.getElementById('asiento');
        let unidadId = document.getElementById('unidad').value;
        selectAsiento.innerHTML = '';

        let unidad = unidadesDisponibles.find(u => u.id == unidadId);
        if (unidad) {
            unidad.asientosDisponibles.forEach(asiento => {
                let option = document.createElement('option');
                option.value = asiento;
                option.textContent = `Asiento ${asiento}`;
                selectAsiento.appendChild(option);
            });
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        cargarUnidades();
        cargarAsientos();
    });

    document.getElementById('unidad').addEventListener('change', cargarAsientos);

    document.getElementById('reservarAsiento').addEventListener('click', function() {
        let origen = document.getElementById('origen').value;
        let destino = document.getElementById('destino').value;
        let unidad = document.getElementById('unidad').value;
        let asiento = document.getElementById('asiento').value;

        let metodoPago = [];
        if (document.getElementById('efectivo').checked) metodoPago.push('Efectivo');
        if (document.getElementById('tarjetaCredito').checked) metodoPago.push('Tarjeta de Crédito');
        if (document.getElementById('transferencia').checked) metodoPago.push('Transferencia');

        let boleto = { origen, destino, unidad, asiento, metodoPago, precio: precioBoleto };
        carrito.push(boleto);
        actualizarCarrito();
    });

    function actualizarCarrito() {
        let tbody = document.getElementById('carrito');
        tbody.innerHTML = '';
        let total = 0;

        carrito.forEach((b, index) => {
            total += b.precio;
            let fila = `<tr>
                            <td>${b.origen} - ${b.destino}</td>
                            <td>${b.unidad}</td>
                            <td>${b.asiento}</td>
                            <td>${b.metodoPago.join(', ')}</td>
                            <td class="text-success font-weight-bold">$${b.precio}.00</td>
                            <td><button class="btn btn-danger btn-sm" onclick="eliminarBoleto(${index})"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
            tbody.innerHTML += fila;
        });
        document.getElementById('total').innerText = `$${total}.00`;
    }

    function eliminarBoleto(index) {
        carrito.splice(index, 1);
        actualizarCarrito();
    }

    document.getElementById('procederPago').addEventListener('click', function() {
        let metodosSeleccionados = [];

        if (document.getElementById('efectivo').checked) {
            metodosSeleccionados.push('Efectivo');
        }
        if (document.getElementById('tarjetaCredito').checked) {
            metodosSeleccionados.push('Tarjeta de Crédito');
        }
        if (document.getElementById('transferencia').checked) {
            metodosSeleccionados.push('Transferencia');
        }

        alert(`Métodos seleccionados: ${metodosSeleccionados.join(', ')}`);
    });
</script>
@endsection
