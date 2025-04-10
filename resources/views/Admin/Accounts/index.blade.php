@extends('Admin.layout.layout')
@section('content')

<style>
    body {
        background-color: #f8f9fa;
    }

    .sidebar {
        height: 100vh;
        overflow-y: auto;
        background: #fff;
        border-right: 1px solid #ddd;
        padding: 20px;
    }

    .account-item {
        padding: 10px;
        border: 1px solid #ddd;
        margin-bottom: 10px;
        background: #f9f9f9;
        cursor: pointer;
    }

    .account-item.active {
        background: #e9ecef;
        border-left: 3px solid #007bff;
    }

    .account-item:hover {
        background: #e9ecef;
    }

    .form-container {
        background: #fff;
        padding: 20px;
        border-radius: 5px;
    }

    .form-control {
        margin-bottom: 10px;
        border: 1px solid #929191;
        margin-bottom: 10px;
    }

    .action-buttons .btn {
        margin-right: 5px;
    }

    #deleteBtn {
        margin-right: 5px;
        background-color: #dc3545;
        border-color: #dc3545;
    }

    #deleteBtn:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
</style>


<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar">
            <h4>Accounts</h4>
            <br>
            <button class="btn btn-primary" id="addNewBtn">Add</button>
            <button id="showAgents" class="btn btn-primary" >View Agents</button>
            <button id="showVendors" class="btn btn-primary" style=" visibility: hidden;position: absolute;">View Vendors</button>

            <input type="text" id="accountSearch" class="form-control mb-3" placeholder="Search">

            <div id="accountsList">
                @forelse ($users as $u)
                <div class="account-item" data-id="{{$u->id}}">
                    {{$u->name}} <br>
                    <small>{{$u->business_details->updated_at ?? 'N/A'}}</small>
                    <br>
                    <button class="toggle-status btn btn-sm {{ $u->is_active ? 'btn-success' : 'btn-danger' }}"
                        data-id="{{ $u->id }}"
                        data-status="{{ $u->is_active }}">
                        {{ $u->is_active ? 'Active' : 'Inactive' }}
                    </button>
                </div>
                @empty
                <p>No data Available</p>
                @endforelse
            </div>

        </div>

        <div class="col-md-9" id="vendorsView">

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}" id="userForm">
                @csrf
                <input type="hidden" name="id" id="userId">
                <div class="form-container">
                    <h4>Details of Service Provider</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="business_name" id="business_name" class="form-control" placeholder="Business Name">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="designation" id="designation" class="form-control" placeholder="Designation">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="address" id="address" class="form-control" placeholder="Address">
                        </div>
                        <div class="col-md-6">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password (leave blank to keep current)">
                        </div>
                        <div class="col-md-6">
                            <input type="number" name="contact" id="contact" class="form-control" placeholder="Contact">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="agent_greeting" id="agent_greeting" class="form-control" placeholder="Agent Greeting">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="website" id="website" class="form-control" placeholder="Website">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="obituary_link" id="obituary_link" class="form-control" placeholder="Obituary Link">
                        </div>
                        <div class="col-md-12">
                            <textarea class="form-control" name="directions_link" id="directions_link" rows="2" placeholder="Directions Link"></textarea>
                        </div>

                        <!-- Additional Fields -->
                        <div class="col-md-3">
                            <textarea class="form-control" rows="2" name="agent_notes" id="agent_notes" placeholder="Agent Notes"></textarea>
                        </div>
                        <div class="col-md-3">
                            <textarea class="form-control" name="fax_numbers" id="fax_numbers" rows="2" placeholder="Fax Numbers"></textarea>
                        </div>
                        <div class="col-md-3">
                            <textarea class="form-control" name="bulk_emails" id="bulk_emails" rows="2" placeholder="Bulk Emails"></textarea>
                        </div>
                        <div class="col-md-3">
                            <textarea class="form-control" name="bulk_sms" id="bulk_sms" rows="2" placeholder="Bulk SMS"></textarea>
                        </div>

                        <div class="col-md-12">
                            <input type="number" class="form-control" name="business_phone" id="business_phone" placeholder="Business Phone">
                        </div>

                        <div class="col-md-6">
                            <input type="checkbox" id="did-config" name="did_config" value="1">
                            <label for="did-config">DID will be configured for this number.</label>
                            <input type="number" name="did_number" id="did_number" class="form-control mt-2" placeholder="DID Number">
                        </div>

                        <div class="col-md-6">
                            <input type="checkbox" id="callback-required" name="callback_required" value="1">
                            <label for="callback-required">Is callback required?</label>
                            <input type="text" name="call_person_name" id="call_person_name" class="form-control mt-2" placeholder="Name of call person">
                        </div>

                        <div class="col-md-6">
                            <label>Send Reminder TX:</label>
                            <input type="radio" name="reminder" value="yes" id="reminder_yes"> Yes
                            <input type="radio" name="reminder" value="no" id="reminder_no"> No
                            <input type="number" name="second_past" id="second_past" class="form-control mt-2" placeholder="Seconds Past">
                        </div>

                        <div class="col-md-6">
                            <label>Timezone</label>
                            <select class="form-control" name="timezone" id="timezone">
                                <option value="">Select Timezone</option>
                                <option value="UTC">UTC</option>
                                <option value="PST">PST</option>
                                <option value="EST">EST</option>
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <!-- Action Buttons -->
                <div class="action-buttons mt-3">
                    <button type="button" class="btn btn-danger toggle-feature" data-feature="active_agents" data-status="0">ACTIVATE ACTIVE AGENTS</button>
                    <button type="button" class="btn btn-danger toggle-feature" data-feature="notifications" data-status="0">ACTIVATE NOTIFICATIONS</button>
                    <button type="button" class="btn btn-danger toggle-feature" data-feature="survey" data-status="0">ACTIVATE SURVEY</button>
                    <button type="button" class="btn btn-danger toggle-feature" data-feature="join_calls" data-status="0">ACTIVATE JOIN CALLS</button>
                    <button type="button" class="btn btn-danger toggle-feature" data-feature="schedule_greeting" data-status="0">ACTIVATE SCHEDULE GREETING</button>
                    <!-- Hidden inputs to store the values -->
                    <input type="hidden" name="active_agents" id="active_agents" value="0">
                    <input type="hidden" name="notifications" id="notifications" value="0">
                    <input type="hidden" name="survey" id="survey" value="0">
                    <input type="hidden" name="join_calls" id="join_calls" value="0">
                    <input type="hidden" name="schedule_greeting" id="schedule_greeting" value="0">
                </div>



                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" id="deleteBtn">Delete</button>
                        <button type="button" class="btn btn-danger" id="resetPasswordBtn" style="display: none;">Reset Password</button>
                        <button type="button" class="btn btn-secondary" id="clearFormBtn">Clear Form</button>
                    </div>
                </div>
            </form>
        </div>

        <div id="agentsView" class="col-md-9" style="display: none;">
            <div class="card">
                <div class="card-header">Active Agent</div>
                <div class="card-body">
                    <form>
                        <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="User Name">
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                               <button type="submit" class="btn btn-primary">Add new Agent</button>
                            </div>
                        </div>
                        
                        
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>


@section('scripts')
<script>
    $(document).ready(function() {
        // Toggle between agents and vendors
        $("#showAgents").click(function() {
            $('#showVendors').css({'visibility': 'visible', 'position': 'static'});
            $('#showAgents').css({'visibility': 'hidden', 'position': 'absolute'});
            $("#agentsView").show();
            $("#vendorsView").hide();
        });

        $("#showVendors").click(function() {
            $('#showAgents').css({'visibility': 'visible', 'position': 'static'});
            $('#showVendors').css({'visibility': 'hidden', 'position': 'absolute'});
            $("#vendorsView").show();
            $("#agentsView").hide();
        });


        // Search functionality
        $('#accountSearch').on('keyup', function() {
            const searchText = $(this).val().toLowerCase();

            $('.account-item').each(function() {
                const itemText = $(this).text().toLowerCase();
                $(this).toggle(itemText.includes(searchText));
            });
        });

        // Handle account item click
        $('.account-item').click(function() {
            const userId = $(this).data('id');
            loadUserData(userId);
            $('.account-item').removeClass('active');
            $(this).addClass('active');
        });

        // Add new button click
        $('#addNewBtn').click(function() {
            $('#userForm')[0].reset();
            $('#userId').val('');
            $('#userForm').attr('action', "{{ route('admin.users.store') }}");
            $('#userForm input[name="_method"]').remove();
            $('.account-item').removeClass('active');
        });

        // Clear form button
        $('#clearFormBtn').click(function() {
            $('#userForm')[0].reset();
            $('#userId').val('');
            $('#userForm').attr('action', "{{ route('admin.users.store') }}");
            $('#userForm input[name="_method"]').remove();
            $('.account-item').removeClass('active');
        });

        // Reset password button
        $('#resetPasswordBtn').click(function() {
            const userId = $('#userId').val();
            if (!userId) {
                alert('Please select a user first');
                return;
            }

            if (confirm('Are you sure you want to reset this user\'s password?')) {
                $.ajax({
                    url: "{{ route('admin.users.resetPassword') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: userId
                    },
                    success: function(response) {
                        alert('Password reset to default: 12345678');
                    },
                    error: function(xhr) {
                        alert('Error resetting password');
                    }
                });
            }
        });

        // Form submission handler
        $('#userForm').submit(function(e) {
            e.preventDefault();

            const formData = $(this).serialize();
            const url = $(this).attr('action');
            const method = $('#userId').val() ? 'POST' : 'POST'; // For update we'll add _method field

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    toastr.success('Successfully saved', 'Success', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 5000,
                        escapeHtml: false
                    });

                    window.location.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation errors
                        const errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        for (const field in errors) {
                            errorMessages += errors[field][0] + '\n';
                        }
                        toastr.error('Validation errors:<br>' + errorMessages, 'Error', {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 5000,
                            escapeHtml: false
                        });

                    } else {
                        alert('Error saving user data');
                    }
                }
            });
        });

        // Function to load user data
        function loadUserData(userId) {
            $.ajax({
                url: "{{ url('admin/users') }}/" + userId,
                type: "GET",
                success: function(response) {
                    const user = response.user;
                    const businessDetails = response.business_details || {};

                    $('#userForm').attr('action', "{{ route('admin.users.update', '') }}/" + userId);
                    $('#userId').val(user.id);

                    // Add method field for update
                    if ($('#userForm input[name="_method"]').length === 0) {
                        $('#userForm').append('<input type="hidden" name="_method" value="PUT">');
                    }

                    

                    // Fill form fields
                    $('#name').val(user.name);
                    $('#email').val(user.email);
                    $('#contact').val(businessDetails.contact);
                    $('#password').attr('readonly', true);

                    // Business details
                    $('#business_name').val(businessDetails.business_name || '');
                    $('#designation').val(businessDetails.designation || '');
                    $('#address').val(businessDetails.address || '');
                    $('#agent_greeting').val(businessDetails.agent_greeting || '');
                    $('#website').val(businessDetails.website || '');
                    $('#obituary_link').val(businessDetails.obituary_link || '');
                    $('#directions_link').val(businessDetails.directions_link || '');
                    $('#agent_notes').val(businessDetails.agent_notes || '');
                    $('#fax_numbers').val(businessDetails.fax_numbers || '');
                    $('#bulk_emails').val(businessDetails.bulk_emails || '');
                    $('#bulk_sms').val(businessDetails.bulk_sms || '');
                    $('#business_phone').val(businessDetails.business_phone || '');
                    $('#did_number').val(businessDetails.did_number || '');
                    $('#call_person_name').val(businessDetails.call_person_name || '');
                    $('#second_past').val(businessDetails.seconds_past || '');
                    $('#timezone').val(businessDetails.timezone || '');

                    // Checkboxes and radios
                    $('#did-config').prop('checked', businessDetails.did_config == 1);
                    $('#callback-required').prop('checked', businessDetails.callback_required == 1);

                    if (businessDetails.reminder === 'yes') {
                        $('#reminder_yes').prop('checked', true);
                    } else {
                        $('#reminder_no').prop('checked', true);
                    }

                    if (response.business_details) {
                        setFeatureButtons({
                            active_agents: response.business_details.active_agents || 0,
                            notifications: response.business_details.notifications || 0,
                            survey: response.business_details.survey || 0,
                            join_calls: response.business_details.join_calls || 0,
                            schedule_greeting: response.business_details.schedule_greeting || 0
                        });
                    }
                },
                error: function(xhr) {
                    alert('Error loading user data');
                }
            });
        }
    });

    // Delete button click handler
    $('#deleteBtn').click(function() {
        const userId = $('#userId').val();
        if (!userId) {
            toastr.warning('Please select a user first', 'Warning');
            return;
        }

        if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
            $.ajax({
                url: "{{ route('admin.users.delete') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: userId
                },
                success: function(response) {
                    toastr.success('User deleted successfully', 'Success');
                    window.location.reload(); // Refresh the page to update the list
                },
                error: function(xhr) {
                    toastr.error('Error deleting user', 'Error');
                }
            });
        }
    });

    $(document).on('click', '.toggle-status', function() {
        let button = $(this);
        let userId = button.data('id');
        let currentStatus = button.data('status');
        let newStatus = currentStatus == 1 ? 0 : 1; // Toggle status

        $.ajax({
            url: '/update-user-status', // Update this with your route
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: userId,
                is_active: newStatus
            },
            success: function(response) {
                if (response.success) {
                    button.data('status', newStatus);
                    button.text(newStatus ? 'Active' : 'Inactive');
                    button.removeClass(newStatus ? 'btn-danger' : 'btn-success')
                        .addClass(newStatus ? 'btn-success' : 'btn-danger');
                    toastr.success('Status updated successfully!');
                } else {
                    toastr.error('Failed to update status.');
                }
            },
            error: function() {
                toastr.error('An error occurred.');
            }
        });
    });


    // toggle status
    $(document).on('click', '.toggle-feature', function() {
        const button = $(this);
        const currentStatus = parseInt(button.data('status'));
        const newStatus = currentStatus ? 0 : 1;
        const feature = button.data('feature');

        // Update button appearance
        button.data('status', newStatus);
        button.toggleClass('btn-danger btn-success');
        button.text(newStatus ? button.text().replace('ACTIVATE', 'ACTIVATED') : button.text().replace('ACTIVATED', 'ACTIVATE'));

        // Update hidden input value
        $(`#${feature}`).val(newStatus);
    });

    // Function to set feature buttons based on loaded data
    function setFeatureButtons(features) {
        $('.toggle-feature').each(function() {
            const feature = $(this).data('feature');
            const status = features[feature] || 0;

            $(this).data('status', status);
            $(`#${feature}`).val(status);

            if (status) {
                $(this).removeClass('btn-danger').addClass('btn-success')
                    .text($(this).text().replace('ACTIVATE', 'ACTIVATED'));
            } else {
                $(this).removeClass('btn-success').addClass('btn-danger')
                    .text($(this).text().replace('ACTIVATED', 'ACTIVATE'));
            }
        });
    }
</script>
@endsection

@endsection