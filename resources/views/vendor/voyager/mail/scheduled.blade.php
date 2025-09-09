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

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #718096;
            text-align: center;
        }

        .brand-logo {
            display: block;
            margin: 0 auto 20px auto;
            width: 120px;
        }

        .btn-confirm {
            background: #3182ce;
            color: #fff !important;
            padding: 12px 32px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(49, 130, 206, 0.15);
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

    <img src="{{ asset('images/franbarber-logo.png') }}" alt="FranBarber Logo" class="brand-logo">

    <div class="header-title">Hola {{ $name }},</div>

    <div class="appointment-details">
        <p>Tu cita en <strong>FranBarber</strong> está programada para:</p>
        <p><strong>Fecha:</strong> {{ $date }}</p>
    </div>

    <a href="{{ $confirmationUrl ?? '#' }}" class="btn-confirm">Confirmar cita</a>

    <div class='maps'>
        <a href="https://maps.app.goo.gl/qfD1EwDtQzPYqB2v9" target="_blank">
            <img src="https://maps.googleapis.com/maps/api/staticmap?center=FranBarber&zoom=16&size=600x300&markers=color:red%7Clabel:F%7C40.416775,-3.703790"
                alt="Ver ubicación en Google Maps" /></a>
    </div>

    <div class="footer">
        ¡Te esperamos!<br>
    </div>
