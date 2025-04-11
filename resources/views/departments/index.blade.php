@extends('layouts/layout')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px; /* Added gap for better spacing */
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
            display: none;
            padding: 10px;
            background: white;
            border-radius: 5px;
        }
        input, select, button {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 8px;
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
    </style>

    <h2>Departments</h2>
    <br>
    <br>

    <div class="page-content-wrapper container">

        <!-- Left Panel -->
        <div class="left-panel">
            <div class="buttons">
                <button onclick="showAddForm()" class="action-btn" style="width: 120px;">ADD</button>
                  <!-- <button onclick="removeRecord()" class="action-btn delete">REMOVE</button> -->
            </div>
            <hr>
            <br>
            <div id="departments-list">
                <!-- Departments will be dynamically loaded here -->
                @foreach ($departments as $department)
                    <div class="record" data-id="{{ $department->id }}" onclick="editRecord({{ $department->id }},'{{ $department->name }}', '{{ $department->email }}', '{{ $department->phone_number }}', '{{ $department->assigned_key }}', '{{ $department->colour }}')">
                        <span>{{ $department->name }}
                        </br>
                        <p>Modified at:{{ $department->updated_at }}</p>
                        </span>
 
                        
                        <i class="fas fa-trash" onclick="deleteRecord(event, {{ $department->id }})"></i>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right Panel -->
        <div class="right-panel" id="formContainer">
            <h3 id="formTitle">Add Department</h3>
            <hr>
            <br>
            <input type="color" id="color" placeholder="Color" style="height: 37px;border-radius: 31px;width: 6%;"> <!-- Add this input field -->
            <div class="form-container">
                <input type="hidden" id="departmentId">
            </br>
                <input type="text" id="departmentName" placeholder="Department Name">
            </br>
                <input type="email" id="email" placeholder="Email">
            </br>
                <input type="text" id="phone_number" placeholder="phone Number">
            </br>
                <select id="assignedKey">
                    <option value="">Select...</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                </br>
                <button onclick="saveForm()" class="action-btn" style="width: 100px;">SAVE</button>
            </div>
        </div>
    </div>

@section('scripts')
   <script>
    $(document).ready(function () {

        // Show Add Form
        window.showAddForm = function () {
            $('#formTitle').text('Add Department');
            $('#departmentId').val('');
            $('#departmentName').val('');
            $('#email').val('');
            $('#phone_number').val('');
            $('#assignedKey').val('');
            $('#color').val('');
            $('.form-container').show();
        }

        // Edit Record
        window.editRecord = function (id, name, email, phone_number, assignedKey, color) {
            $('#formTitle').text('Edit Department');
            $('#departmentId').val(id);
            $('#departmentName').val(name);
            $('#email').val(email);
            $('#phone_number').val(phone_number);
            $('#assignedKey').val(assignedKey);
            $('#color').val(color);
            $('.form-container').show();
        }

        // Save Form
        window.saveForm = function () {
            const id = $('#departmentId').val();
            const name = $('#departmentName').val().trim();
            const email = $('#email').val().trim();
            const phone_number = $('#phone_number').val().trim();
            const assignedKey = $('#assignedKey').val();
            const color = $('#color').val();

            if (name === '') {
                alert('Department Name is required.');
                return;
            }
            if (email === '' || !validateEmail(email)) {
                alert('Enter a valid Email.');
                return;
            }
            if (phone_number === '') {
                alert('Phone number is required.');
                return;
            }
            if (assignedKey === '') {
                alert('Please select an Assigned Key.');
                return;
            }

            const url = id ? `/departments/${id}` : '/departments';
            const method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    name: name,
                    email: email,
                    phone_number: phone_number,
                    assigned_key: assignedKey,
                    colour: color
                }),
                success: function (response) {
                    alert('Saved successfully!');
                    location.reload();
                },
                error: function (xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        }

        // Delete Record
        window.deleteRecord = function (event, id) {
            event.stopPropagation();
            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    url: `/departments/${id}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        alert('Deleted successfully!');
                        location.reload();
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            }
        }

        // Email Validation
        function validateEmail(email) {
            const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return re.test(email);
        }

    });
</script>
@endsection
@endsection