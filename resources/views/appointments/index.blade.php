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
                                        <div class="mb-3">
                                            <label for="date" class="form-label text-secondary mb-1">El rango de fecha
                                                elegido es:</label>
                                            <input type="text" id="date" disabled
                                                class="form-control bg-light text-muted" value="2023-10-26 a 2023-10-28">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label text-secondary mb-1">Email del
                                                usuario:</label>
                                            <input type="email" id="email" placeholder="ej. usuario@ejemplo.com"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="modal-footer border-0 d-flex justify-content-end pt-0">
                                        <button type="button" class="btn btn-primary rounded-pill shadow"
                                            data-bs-dismiss="modal">
                                            Enviar
                                        </button>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        const modalElement = $('#modal-container')[0];
        const myModal = new bootstrap.Modal(modalElement);

        const toggleModal = () => {
            myModal.show();
        };

        const dateInput = document.getElementById('date');
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            slotMinTime: '10:00:00',
            slotMaxTime: '20:30:00',
            slotDuration: '00:10:00',
            events: @json($appointments),
            selectable: true,
            locale: 'es',
            dateClick: function(info) {
                $('#date').val(info.dateStr);
                toggleModal();
            }
        });
        calendar.render();

        // Listen for the form submission
        $('#create-appointment').on('submit', function(event) {
            // Prevent the default form submission which reloads the page
            event.preventDefault();

            // Get the values from the input fields
            var date = $('#date').val();
            var email = $('#email').val();

            // The data we are sending to the server
            var dataToSend = {
                date,
                email
            };

            // The jQuery AJAX POST request
            $.ajax({
                url: '/api/save-data', // The endpoint on your server
                method: 'POST',
                contentType: 'application/json', // Tell the server we're sending JSON
                data: JSON.stringify(dataToSend), // Convert the JS object to a JSON string

                // This function runs if the request is successful
                success: function(response) {
                    console.log('Success:', response);
                    $('#response').text('Success! Server responded: ' + response.message);
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
