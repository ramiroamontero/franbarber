@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    body {
    font-family: sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    background-color: #f0f2f5;
    }

    /* Modal backdrop - covers the whole screen */
    #modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black */
    z-index: 999;
    }

    /* Modal container - the actual popup box */
    #modal-container {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); /* Centers the modal */
    z-index: 1000;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    min-width: 300px;
    }

    /* Utility class to hide elements */
    .hidden {
    display: none;
    }

    /* Modal content styling */
    .modal-content {
    display: flex;
    flex-direction: column;
    }

    .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ccc;
    padding-bottom: 10px;
    margin-bottom: 15px;
    }

    .modal-header h3 {
    margin: 0;
    }

    .modal-body {
    margin-bottom: 15px;
    }

    .modal-footer {
    display: flex;
    justify-content: flex-end;
    }

    /* Button styling */
    button {
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    }

    #open-modal-btn,
    #submit-btn {
    background-color: #007bff;
    color: white;
    }

    #close-modal-btn {
    background: none;
    font-size: 24px;
    padding: 0;
    margin: 0;
    color: #888;
    }

    #close-modal-btn:hover {
    color: #333;
    }

    input[type="date"] {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    }
@stop

<head>
    <meta charset='utf-8' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>
    <script>
        const openBtn = document.getElementById('open-modal-btn');
        const closeBtn = document.getElementById('close-modal-btn');
        const submitBtn = document.getElementById('submit-btn');
        const backdrop = document.getElementById('modal-backdrop');
        const modal = document.getElementById('modal-container');
        const dateInput = document.getElementById('event-date');

        const openModal = () => {
            backdrop.classList.remove('hidden');
            modal.classList.remove('hidden');
        };

        // Function to hide the modal
        const closeModal = () => {
            backdrop.classList.add('hidden');
            modal.classList.add('hidden');
        };

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridDay',
                slotMinTime: '10:00:00',
                slotMaxTime: '20:30:00',
                slotDuration: '00:10:00',
                events: @json($appointments),
                selectable: true,
                locale: 'es',
                dateClick: function(info) {
                    openModal();
                }
            });
            calendar.render();
        });
    </script>
</head>

<body>
    <div id="modal-backdrop" class="hidden"></div>
    <div id="modal-container" class="hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Choose a Date</h3>
                <button id="close-modal-btn">&times;</button>
            </div>
            <div class="modal-body">
                <label for="event-date">Event Date:</label>
                <input type="date" id="event-date">
            </div>
            <div class="modal-footer">
                <button id="submit-btn">Submit</button>
            </div>
        </div>
    </div>
</body>

@section(section: 'content')
    <div class="page-content container-fluid">
        <div class="card">
            <div class="card-body">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
@endsection
