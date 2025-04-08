@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div id='calendar'></div>

    <!-- Modal Para Crear Registros -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Seleccionar Horario para <span id="selectedDate"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label class="block mb-2 mt-3">Conductor:</label>
                    <select id="driverSelect" class="form-control">
                        <option value="">Seleccione un conductor</option>
                    </select>

                    <label class="block mb-2">Unidad:</label>
                    <select id="unitSelect" class="form-control">
                        <option value="">Seleccione una unidad</option>
                    </select>

                    <label class="block mb-2 mt-3">Horario:</label>
                    <select id="scheduleSelect" class="form-control">
                        <option value="">Seleccione un horario</option>
                    </select>

                    <div class="mt-3">
                        <label for="statusSelect">Estado:</label>
                        <select id="statusSelect" class="form-control">
                            <option value="Activo">Activo</option>
                            <option value="inactivo" selected>Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveSchedule">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Para Ver y Editar Registros -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTitle">Detalles del Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Fecha:</strong> <span id="viewDate"></span></p>
                    <p><strong>Conductor:</strong> <span id="viewDriver"></span></p>
                    <p><strong>Unidad:</strong> <span id="viewUnit"></span></p>
                    <p><strong>Horario:</strong> <span id="viewSchedule"></span></p>
                    <p><strong>Estado:</strong> <span id="viewStatus"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="editSchedule">Editar</button>
                    <button type="button" class="btn btn-danger" id="deleteSchedule">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Para Editar Registros -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTitle">Editar Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editScheduleId">

                    <label class="block mb-2">Fecha:</label>
                    <input type="date" id="editDate" class="form-control">

                    <label class="block mb-2">Conductor:</label>
                    <select id="editDriverSelect" class="form-control"></select>

                    <label class="block mb-2">Unidad:</label>
                    <select id="editUnitSelect" class="form-control"></select>

                    <label class="block mb-2">Horario:</label>
                    <select id="editScheduleSelect" class="form-control"></select>

                    <label class="block mb-2">Estado:</label>
                    <select id="editStatusSelect" class="form-control">
                        <option value="Activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="updateSchedule">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/locales/es.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var selectedEvent = null; // Variable global para el evento seleccionado
    
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            events: '/horarios', // Cargar eventos desde la BD
    
            select: function (info) {
                document.getElementById('selectedDate').textContent = info.startStr;
    
                fetch('/get-selectors')
                    .then(response => response.json())
                    .then(data => {
                        let unitSelect = document.getElementById('unitSelect');
                        let scheduleSelect = document.getElementById('scheduleSelect');
                        let driverSelect = document.getElementById('driverSelect');
    
                        unitSelect.innerHTML = data.units.map(u => `<option value="${u.id}">${u.plate}</option>`).join('');
                        scheduleSelect.innerHTML = data.schedules.map(s => `<option value="${s.id}">${s.departure_time}</option>`).join('');
                        driverSelect.innerHTML = data.drivers.map(d => `<option value="${d.id}">${d.name}</option>`).join('');
    
                        $('#scheduleModal').modal('show'); // Mostrar modal
                    });
            },
    
            eventClick: function (info) {
                selectedEvent = info.event;
    
                document.getElementById('viewDate').textContent = selectedEvent.startStr;
                document.getElementById('viewDriver').textContent = selectedEvent.extendedProps.driver || 'No definido';
                document.getElementById('viewUnit').textContent = selectedEvent.extendedProps.unit || 'No definido';
                document.getElementById('viewSchedule').textContent = selectedEvent.extendedProps.schedule || 'No definido';
                document.getElementById('viewStatus').textContent = selectedEvent.extendedProps.status || 'No definido';
    
                $('#viewModal').modal('show'); // Mostrar modal de detalles
            }
        });
    
        calendar.render();
    
        // Guardar nuevo horario
        document.getElementById('saveSchedule').onclick = function () {
            let status = document.getElementById('statusSelect').value;
    
            fetch('/horarios', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    day: document.getElementById('selectedDate').textContent,
                    id_Units: document.getElementById('unitSelect').value,
                    id_Schedules: document.getElementById('scheduleSelect').value,
                    id_Driver: document.getElementById('driverSelect').value,
                    status: status
                })
            }).then(response => response.json())
                .then(data => {
                    $('#scheduleModal').modal('hide');
                    calendar.refetchEvents(); // Refrescar eventos
                });
        };
    
        // Editar evento seleccionado
        document.getElementById('editSchedule').addEventListener('click', function () {
            if (!selectedEvent) {
                alert("Error: No hay un evento seleccionado.");
                return;
            }
    
            // Llenar campos con la información del evento
            document.getElementById('editScheduleId').value = selectedEvent.id;
            document.getElementById('editDate').value = selectedEvent.startStr;
            document.getElementById('editStatusSelect').value = selectedEvent.extendedProps.status || '';
    
            // Obtener opciones desde el backend
            fetch('/get-selectors')
                .then(response => response.json())
                .then(data => {
                    let unitSelect = document.getElementById('editUnitSelect');
                    let scheduleSelect = document.getElementById('editScheduleSelect');
                    let driverSelect = document.getElementById('editDriverSelect');
    
                    unitSelect.innerHTML = data.units.map(u =>
                        `<option value="${u.id}" ${u.plate === selectedEvent.extendedProps.unit ? 'selected' : ''}>${u.plate}</option>`).join('');
    
                    scheduleSelect.innerHTML = data.schedules.map(s =>
                        `<option value="${s.id}" ${s.departure_time === selectedEvent.extendedProps.schedule ? 'selected' : ''}>${s.departure_time}</option>`).join('');
    
                    driverSelect.innerHTML = data.drivers.map(d =>
                        `<option value="${d.id}" ${d.name === selectedEvent.extendedProps.driver ? 'selected' : ''}>${d.name}</option>`).join('');
    
                    $('#editModal').modal('show'); // Mostrar modal de edición
                })
                .catch(error => console.error("Error cargando los selects:", error));
        });
    
        // Actualizar evento editado
        document.getElementById('updateSchedule').addEventListener('click', function () {
            let id = document.getElementById('editScheduleId').value;
            let day = document.getElementById('editDate').value;
            let id_Units = document.getElementById('editUnitSelect').value;
            let id_Schedules = document.getElementById('editScheduleSelect').value;
            let id_Driver = document.getElementById('editDriverSelect').value;
            let status = document.getElementById('editStatusSelect').value;
    
            fetch(`/horarios/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ day, id_Units, id_Schedules, id_Driver, status })
            })
                .then(response => response.json())
                .then(data => {
                    alert('Registro actualizado correctamente');
                    $('#editModal').modal('hide');
                    $('#viewModal').modal('hide');
                    calendar.refetchEvents(); // Refrescar eventos
                })
                .catch(error => console.error("Error al actualizar:", error));
        });
    
        // Eliminar evento
        document.getElementById('deleteSchedule').onclick = function () {
            if (!selectedEvent) return;
    
            if (confirm("¿Seguro que quieres eliminar este registro?")) {
                fetch(`/horarios/${selectedEvent.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        $('#viewModal').modal('hide');
                        calendar.refetchEvents(); // Refrescar eventos
                    })
                    .catch(error => console.error('Error al eliminar:', error));
            }
        };
    });
    
</script>

@endsection