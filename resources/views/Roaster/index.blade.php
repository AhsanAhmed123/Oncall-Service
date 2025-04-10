@extends('layouts.layout')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


   <div class="page-content-wrapper container">

    <div class="d-flex justify-content-between">
        <button class="btn btn-primary" onclick="showRosterForm()">Roster View</button>
        <button class="btn btn-danger" onclick="showCalendar()">Clear Calendar</button>
    </div>

    <!-- Calendar -->
    <div id="calendar" class="mt-4"></div>

    <!-- Roster Form -->
    <div id="rosterForm" class="mt-4" style="display: none;">
        <h3>Manage Roster</h3>
        <select class="form-control mb-2" id="username">
            <option>Select Employee</option>
            @foreach ($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
            @endforeach
        </select>
        <input type="datetime-local" id="start_time" class="form-control mb-2">
        <input type="datetime-local" id="end_time" class="form-control mb-2">
        
        <label>Select Days:</label>
        <div id="days">
            @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                <button type="button" class="btn btn-outline-primary" onclick="toggleDay(this)">{{ $day }}</button>
            @endforeach
        </div>

        <button class="btn btn-success mt-2">Save</button>
    </div>
</div>
   </div>

<script>
    let selectedDays = [];

    function toggleDay(button) {
        let day = button.innerText;
        if (selectedDays.includes(day)) {
            selectedDays = selectedDays.filter(d => d !== day);
            button.classList.remove('btn-primary');
            button.classList.add('btn-outline-primary');
        } else {
            selectedDays.push(day);
            button.classList.add('btn-primary');
            button.classList.remove('btn-outline-primary');
        }
    }

    function showRosterForm() {
        $('#calendar').hide();
        $('#rosterForm').show();

        // Reset form
        $('#username').prop('disabled', false).val('');
        $('#start_time').val('');
        $('#end_time').val('');
        selectedDays = [];
        $('#days button').removeClass('btn-primary').addClass('btn-outline-primary');
        $('.btn-success').text('Save').off('click').on('click', saveRoster);
    }

    function showCalendar() {
        $('#calendar').show();
        $('#rosterForm').hide();
    }

    function saveRoster() {
        $.ajax({
            url: '/roster-save',
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                username: $('#username').val(),
                start_time: $('#start_time').val(),
                end_time: $('#end_time').val(),
                days: selectedDays
            },
            success: function () {
                alert('Roster saved!');
                location.reload();
            }
        });
    }

    function updateRoster(id) {
        $.ajax({
            url: '/update-event',
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                start: $('#start_time').val(),
                end: $('#end_time').val(),
                days: selectedDays
            },
            success: function () {
                alert('Roster updated!');
                location.reload();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/roster-details',
            eventDisplay: 'block',
            eventColor: '#dc3545',
            eventTextColor: '#fff',
            eventClick: function(info) {
                const event = info.event;
                const name = event.title.split(' - ')[1];
                const start = new Date(event.start);
                const end = new Date(event.end);

                showRosterForm();

                // Set values
                $('#username option').filter(function () {
                    return $(this).text() === name;
                }).prop('selected', true);
                $('#username').prop('disabled', true);

                $('#start_time').val(start.toISOString().slice(0, 16));
                $('#end_time').val(end.toISOString().slice(0, 16));

                // Save event ID for update
                $('.btn-success').text('Update').off('click').on('click', function () {
                    updateRoster(event.id);
                });
            }
        });
        calendar.render();
    });
</script>
@endsection
