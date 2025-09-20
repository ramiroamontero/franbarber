@extends('layouts.app')

<head>
    <meta charset='utf-8' />
    <link href='https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css' rel='stylesheet' />
</head>

@section(section: 'content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card overflow-auto">
                    <div class="card-header">
                        Clientes
                    </div>
                    <div class="card-body">
                        <div id="modal-container" class="modal fade" tabindex="-1" aria-labelledby="confirmModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 shadow-lg p-4">
                                    <!-- Modal Header -->
                                    <div
                                        class="modal-header border-0 d-flex justify-content-between align-items-center pb-3">
                                        <h5 class="modal-title fs-4 fw-bold text-dark" id="confirmModalLabel">
                                            Crear cliente</h5>
                                        <!-- Close button -->
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body pt-0 pb-4">
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <div class="mb-3">
                                            <label for="name" class="form-label text-secondary mb-1">Nombre:</label>
                                            <input type="name" id="name" placeholder="Franco Araujo"
                                                class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label text-secondary mb-1">Email:</label>
                                            <input type="email" id="email" placeholder="usuario@gmail.com"
                                                class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone" class="form-label text-secondary mb-1">Teléfono:</label>
                                            <input type="phone" id="phone" placeholder="1122334455"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="modal-footer border-0 d-flex justify-content-end pt-0">
                                        <a href="#" id="create-client" type="button"
                                            class="btn btn-primary rounded-pill shadow" data-bs-dismiss="modal">
                                            Enviar
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <a href="#" id="client-modal" type="button" class="btn btn-primary shadow">
                                Crear Cliente
                            </a>
                        </div>
                        <div class="col-12">
                            <div id="datatable">
                                <table id="myTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    $(document).ready(function() {
        const modalElement = $('#modal-container')[0];
        const myModal = new bootstrap.Modal(modalElement);

        $('#client-modal').on('click', function(event) {
            event.preventDefault();
            myModal.show();
        });

        // Listen for the form submission
        $('#create-client').on('click', function(event) {
            event.preventDefault();

            // The jQuery AJAX POST request with values from form
            $.ajax({
                url: '/clients',
                method: 'POST',
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                data: JSON.stringify({
                    name: $('#name').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val()
                }),

                // This function runs if the request is successful
                success: function(response) {
                    alert('El cliente fue cargado con éxito');
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
