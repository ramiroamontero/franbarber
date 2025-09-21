<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&callback=initMap">
</script>

@component('mail::message')

    <style>
        .appointment-details {
            background: #f8fafc;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            font-size: 16px;
        }

        .header-title {
            color: #2d3748;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .maps {
            text-align: center;
            margin: 24px 0;
        }

        .maps a {
            text-decoration: none;
        }

        .maps a img {
            width: 100%;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
    </style>

    {{-- <img src="{{ asset('images/franbarber-logo.png') }}" alt="FranBarber Logo" class="brand-logo"> --}}

    <div class="header-title">Hola {{ $name }},</div>

    <div class="appointment-details">
        <p>Tu cita en <strong>FranBarber</strong> está programada para:</p>
        <p><strong>Fecha:</strong> {{ $date }}</p>
        <p>¡Te esperamos!</p>
    </div>

    <div class='maps'>
        <a href="https://maps.app.goo.gl/tdjp2oxmUKicexES6?g_st=ipc" target="_blank">
            <img src="https://maps.app.goo.gl/tdjp2oxmUKicexES6?g_st=ipc"
                alt="Ver ubicación en Google Maps" /></a>
                
    </div>

    <div class="footer">
    </div>
