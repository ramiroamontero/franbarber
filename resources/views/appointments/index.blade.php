@extends('layouts.app')

@section(section: 'content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Turnos</div>
                    <div class="card-body">
                        <div id="modal-container" class="modal fade" tabindex="-1" aria-labelledby="confirmModalLabel"
                            aria-hidden="true" data-bs-backdrop="static">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 shadow-lg p-4">

                                    <!-- Modal Header -->
                                    <div
                                        class="modal-header border-0 d-flex justify-content-between align-items-center pb-3">
                                        <h5 class="modal-title fs-4 fw-bold text-dark" id="confirmModalLabel">Confirmación
                                            de fecha</h5>
                                        <!-- Close button -->
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body pt-0 pb-4">
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <div class="mb-3">
                                            <label for="date" class="form-label text-secondary mb-1">El rango de fecha
                                                elegido es:</label>
                                            <input type="text" id="date" disabled
                                                class="form-control bg-light text-muted" value="2023-10-26 a 2023-10-28">
                                        </div>
                                        <div class="mb-3">
                                            <label for="client" class="form-label text-secondary mb-1"></label>
                                            <select name="clients" id="clientId" class="form-control">
                                                <option value="">Elegí un cliente</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}"
                                                        @if (isset($selectedValue) && $selectedValue == $key) selected @endif>
                                                        {{ $client->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="comments"
                                                class="form-label text-secondary mb-1">Comentarios:</label>
                                            <input type="textbox" id="comments" class="form-control bg-light text-muted"
                                                placeholder="Comentarios adicionales">
                                        </div>
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="modal-footer border-0 d-flex justify-content-end pt-0">
                                        <a href="#" id="create-appointment" type="button"
                                            class="btn btn-primary rounded-pill shadow" data-bs-dismiss="modal">
                                            Guardar
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>
<script>
    $(document).ready(function() {
        const modalElement = $('#modal-container')[0];
        const myModal = new bootstrap.Modal(modalElement);

        const toggleModal = () => {
            myModal.show();
        };

        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridDay',
            views: {
                timeGridDay: {
                    type: 'agenda',
                    duration: {
                        days: 4
                    },
                    buttonText: '4 day list'
                }
            },
            slotMinTime: '10:00:00',
            slotMaxTime: '20:30:00',
            slotDuration: '00:10:00',
            events: '/appointments/appointments',
            selectable: true,
            locale: 'es',
            dateClick: function(info) {
                $('#date').val(info.dateStr);
                toggleModal();
            }
        });
        calendar.render();

        // Listen for the form submission
        $('#create-appointment').on('click', function(event) {
            // Prevent the default form submission which reloads the page
            event.preventDefault();

            // The jQuery AJAX POST request
            $.ajax({
                url: '/appointments',
                method: 'POST',
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                data: JSON.stringify({
                    date: $('#date').val(),
                    clientId: $('#clientId').val(),
                    comments: $('#comments').val()
                }), // Convert the JS object to a JSON string

                // This function runs if the request is successful
                success: function(response) {
                    alert('La cita fue creada con éxito!');
                    location.reload();
                },

                // This function runs if the request fails
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#response').text('Error: Could not reach the server.');
                }
            });
        });
    });
</script>
