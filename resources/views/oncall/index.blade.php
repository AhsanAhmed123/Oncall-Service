@extends('layouts.layout')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }
        .left-panel, .right-panel {
            width: 100%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: #f9f9f9;
            margin-bottom: 20px;
        }
        .record {
            padding: 10px;
            background: white;
            margin: 10px 0;
            border-radius: 5px;
            cursor: pointer;
            border: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .record:hover {
            background: #eef;
        }
        .buttons {
            margin-bottom: 10px;
            display: flex;
            gap: 10px;
        }
        .form-container {
            padding: 20px;
            background: white;
            border-radius: 5px;
            display: none;
        }
        input, select, button {
            display: block;
            width: 100%;
            margin: 15px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .action-btn {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }
        .action-btn.delete {
            background-color: #dc3545;
        }
        .action-btn:hover {
            opacity: 0.8;
        }
        @media (min-width: 768px) {
            .left-panel, .right-panel {
                width: 48%;
                margin-bottom: 0;
            }
        }

        .communication-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .communication-buttons .action-btn {
            flex: 1;
            padding: 10px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            color: white;
            border-radius: 5px;
        }

        .communication-buttons .action-btn:hover {
            opacity: 0.8;
        }
    </style>

<h2>On Call Person Details</h2>
    <br><br>

    <div class="page-content-wrapper container">
        <!-- Left Panel -->
        <div class="left-panel">
            <div class="buttons">
                <button onclick="showAddForm()" class="action-btn" style="width: 120px;">ADD</button>
            </div>
            <hr>
            <br>
            <div id="oncall-list">
                @foreach ($oncallPersons as $person)
                    <div class="record" data-id="{{ $person->id }}" onclick="editRecord({{ $person->id }})">
                        <span>
                            <strong>{{ $person->name }}</strong><br>
                            <p>Dept: {{ $person->department->name ?? 'N/A' }}</p>
                            <p>Modified on: {{ $person->updated_at }}</p>
                        </span>
                        @if($person->id !=2)
                        <i class="fas fa-trash" onclick="deleteRecord(event, {{ $person->id }})"></i>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right Panel (Form) -->
        <div class="right-panel" id="formContainer">
            <h3 id="formTitle">Add On Call Person</h3>
            <hr>
            <br>
            <div class="form-container">
                <form id="onCallForm">
                    @csrf
                    <input type="hidden" id="personId" name="id">

                    <label>Role</label>
                    <select name="role_id" id="role" class="form-control">
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>

                    <label>Name</label>
                    <input type="text" id="name" name="name" placeholder="Name" required>

                    <label>Department</label>
                    <select id="department_id" name="department_id" class="form-control">
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>

                    <label>Contact</label>
                    <input type="text" id="contact" name="contact" placeholder="Contact" required>

                    <label>Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>

                    <label>Location</label>
                    <input type="text" id="location" name="location" placeholder="Location" required>

                    </br>

                    <div class="communication-buttons">
                        <button type="button" id="emailButton" onclick="toggleButtonColor('emailButton')" class="action-btn" style="background-color:rgb(159, 0, 5);">Email</button>
                        <button type="button" id="smsButton" onclick="toggleButtonColor('smsButton')" class="action-btn" style="background-color:rgb(159, 0, 5);">SMS</button>
                        <button type="button" id="reminderCallButton" onclick="toggleButtonColor('reminderCallButton')" class="action-btn" style="background-color:rgb(159, 0, 5);">Reminder Call</button>
                        <button type="button" id="directCallButton" onclick="toggleButtonColor('directCallButton')" class="action-btn" style="background-color:rgb(159, 0, 5);">Direct Call</button>
                    </div>

                    <button type="button" onclick="saveRecord()" class="action-btn" style="width: 100px;">SAVE</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showAddForm() {
            $('#formTitle').text('Add On Call Person');
            $('#onCallForm')[0].reset();
            $('#personId').val('');
            $('.form-container').show();
        }

        function editRecord(id) {
            $.get(`/oncall-persons/${id}/edit`, function(data) {
                $('#formTitle').text('Edit On Call Person');
                $('#personId').val(data.id);
                $('#name').val(data.name);
                $('#role').val(data.role_id).change();
                $('#department_id').val(data.department_id).change();
                $('#contact').val(data.contact);
                $('#email').val(data.email);
                $('#location').val(data.location);

                console.log(data);

                // Set button colors based on data
                if (data.is_email == 0) {
                    document.getElementById('emailButton').style.backgroundColor = 'red';
                } else {
                    document.getElementById('emailButton').style.backgroundColor = 'green';
                }

                if (data.is_sms == 0) {
                    document.getElementById('smsButton').style.backgroundColor = 'red';
                } else {
                    document.getElementById('smsButton').style.backgroundColor = 'green';
                }

                if (data.is_reminder_call == 0) {
                    document.getElementById('reminderCallButton').style.backgroundColor = 'red';
                } else {
                    document.getElementById('reminderCallButton').style.backgroundColor = 'green';
                }

                if (data.is_direct_call == 0) {
                    document.getElementById('directCallButton').style.backgroundColor = 'red';
                } else {
                    document.getElementById('directCallButton').style.backgroundColor = 'green';
                }

                $('.form-container').show();
            });
        }

        function saveRecord() {
            let formData = $('#onCallForm').serialize();
            let id = $('#personId').val();
            let url = id ? `/oncall-persons/${id}` : `/oncall-persons`;
            let method = id ? 'PUT' : 'POST';

            Swal.fire({
                title: 'Please wait...',
                html: 'Saving data...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });


            // Add button states to form data
            formData += `&email_enabled=${document.getElementById('emailButton').style.backgroundColor === 'green' ? 1 : 0}`;
            formData += `&sms_enabled=${document.getElementById('smsButton').style.backgroundColor === 'green' ? 1 : 0}`;
            formData += `&reminder_call_enabled=${document.getElementById('reminderCallButton').style.backgroundColor === 'green' ? 1 : 0}`;
            formData += `&direct_call_enabled=${document.getElementById('directCallButton').style.backgroundColor === 'green' ? 1 : 0}`;

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    Swal.close();

                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                }).then(() => {
                    updateList();
                    $('.form-container').hide();
                    window.location.reload();
                });
                    $('.form-container').hide();
                    window.location.reload();
                },
                error: function(error) {
                    Swal.close();

                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred. Please try again.',
                });

                }
            });
        }

        function deleteRecord(event, id) {
            event.stopPropagation();
            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    url: `/oncall-persons/${id}`,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        window.location.reload();
                       
                       
                    },
                    error: function(error) {
                        console.log(error);
                        window.location.reload();
                    }
                });
            }
        }

        function updateList() {
            $.get('/oncall-persons', function(data) {
                let list = '';
                data.forEach(person => {
                    list += `
                        <div class="record" data-id="${person.id}" onclick="editRecord(${person.id})">
                            <span>
                                <strong>${person.name}</strong><br>
                                <p>Dept: ${person.department.name ?? 'N/A'}</p>
                                <p>Modified on: ${person.updated_at}</p>
                            </span>
                            <i class="fas fa-trash" onclick="deleteRecord(event, ${person.id})"></i>
                        </div>`;
                });
                $('#oncall-list').html(list);
            });
        }

        function toggleButtonColor(buttonId) {
            let button = document.getElementById(buttonId);

            // Check current background color
            if (button.style.backgroundColor === 'green' || button.style.backgroundColor === '') {
                button.style.backgroundColor = 'red'; // Change to red
            } else {
                button.style.backgroundColor = 'green'; // Change back to green
            }
        }
    </script>
@endsection