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

    <script>
        // Show Add Form
        function showAddForm() {
            document.getElementById('formTitle').innerText = 'Add Department';
            document.getElementById('departmentId').value = '';
            document.getElementById('departmentName').value = '';
            document.getElementById('email').value = '';
            document.getElementById('phone_number').value = '';
            document.getElementById('assignedKey').value = '';
            document.querySelector('.form-container').style.display = 'block';
            
        }

        // Edit Record
        function editRecord(id, name, email, phone_number, assignedKey, color) {
            document.getElementById('formTitle').innerText = 'Edit Department';
            document.getElementById('departmentId').value = id;
            document.getElementById('departmentName').value = name;
            document.getElementById('email').value = email;
            document.getElementById('phone_number').value = phone_number;
            document.getElementById('assignedKey').value = assignedKey;
            document.getElementById('color').value = color; // Populate the color field
            document.querySelector('.form-container').style.display = 'block';
        }

        function saveForm() {
            const id = document.getElementById('departmentId').value;
            const name = document.getElementById('departmentName').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone_number = document.getElementById('phone_number').value.trim();
            const assignedKey = document.getElementById('assignedKey').value;
            const color = document.getElementById('color').value;

            // Basic Validations
            if (name === "") {
                alert("Department Name is required.");
                return;
            }
            if (email === "" || !validateEmail(email)) {
                alert("Enter a valid Email.");
                return;
            }
            if (phone_number === "") {
                alert("phone number is required.");
                return;
            }
            if (assignedKey === "") {
                alert("Please select an Assigned Key.");
                return;
            }
        

            const url = id ? `/departments/${id}` : '/departments';
            const method = id ? 'PUT' : 'POST';
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/departments/${id}`, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        name: name,
                        email: email,
                        phone_number: phone_number,
                        assigned_key: assignedKey,
                        colour: color
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => { throw new Error(text); });
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Saved successfully!');
                    window.location.reload();
                })
                .catch(error => console.error('Error:', error));

            }
        
            function validateEmail(email) {
            const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return re.test(email);
        }


        function deleteRecord(event, id) {
            event.stopPropagation();
            if (confirm('Are you sure you want to delete this record?')) {
                fetch(`/departments/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Retrieve CSRF token
                    }
                })
                .then(response => {
                    if (response.status === 204) {
                        alert('Deleted successfully!');
                        window.location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
@endsection