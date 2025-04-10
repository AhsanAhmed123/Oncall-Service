@extends('layouts/layout')
@section('content')
<style>
    .input-group-append {
        margin-left: -1px;
    }

    .input-group {
        margin-top: 5px;
    }

    .btn-danger {
        border-radius: 0 5px 5px 0;
    }

    /* Custom Panel Styling */
    .custom-panel {
        position: fixed;
        right: -100%;
        top: 0;
        bottom: 0;
        width: 800px;
        height: 100%;
        background: white;
        box-shadow: -5px 0 10px rgba(0, 0, 0, 0.2);
        transition: right 0.4s ease-in-out;
        z-index: 1050;
    }

    /* When the panel is targeted, show it */
    #configuration:target {
        right: 0;
    }

    .custom-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background: #007bff;
        color: white;
    }

    .custom-body {
        padding: 15px;
    }

    .custom-footer {
        padding: 15px;
        text-align: right;
    }

    /* Close Button */
    .close-btn {
        text-decoration: none;
        font-size: 24px;
        color: white;
        font-weight: bold;
    }

    .close-btn:hover {
        color: #ddd;
    }

    body {
        padding: 20px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .button-group {
        margin-top: 20px;
    }

    .blue-button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px;
        width: 100%;
        text-align: left;
        margin-bottom: 10px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .blue-button span {
        background: white;
        color: black;
        padding: 5px;
        border-radius: 5px;
        margin-left: 10px;
    }
    .custom-panel {
        display: none;  /* Hide the panel initially */
        position: fixed;
        top: 50%;
        left: 70%;
        transform: translate(-50%, -50%);
        width: 60%;
        background: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        z-index: 1000;
    }


    
    @media (max-width: 768px) {
        .header {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .button-group .blue-button {
            font-size: 14px;
        }

        .container {
            padding: 10px;
        }

        .col-auto {
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
        }

        .col.text-center h2 {
            font-size: 1.5rem;
        }
    }

    @media (min-width: 768px) {

        .left-panel,
        .right-panel {
            width: 48%;
            /* Two columns on larger screens */
        }
    }

    @media (min-width: 1400px) {
        .container {
            max-width: 1031px;
        }
    }
</style>
</head>

<body>


    <!-- Custom Panel -->
    <div id="configuration" class="custom-panel" >
        <div class="custom-header">

            <a href="#" class="close-btn">&times;</a>
        </div>
        <div class="custom-body">

      <b> Department : <input type="text" disabled id="ivr-option-dep" style="border: none;"></b>
            <div class="container">
                <div class="container mt-5">
                    <div class="card">
                        <div class="card-header">
                        
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="audioGreeting">Audio Greeting</label>
                                        <div class="d-flex">
                                            <input type="hidden" name="ivr_id_config" id="ivr_id_config" >
                                            <input type="hidden" name="ivr_dept_id" id="ivr_dept_id">
                                            <input type="hidden" name="ivr_option_id" id="ivr_option_id">
                                            <input type="file" name="audioGreeting" class="form-control" id="audioGreeting">
                                           
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="link">Link</label>
                                        <button class="btn btn-link" id="addLink">Add link</button>
                                        <p class="link_send"></p>
                                        <input type="text" class="form-control" readonly id="link_send">
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="greeting">Greeting</label>
                                        <textarea class="form-control" name="greeting_text" id="greeting_option" rows="5">Please leave a detail message and we will contact our oncall sale representative to return your call immediately, Thanks</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="custom-footer">
            <a href="#" class="btn btn-secondary">Close</a>
            <button type="button" id="save_options" class="btn btn-primary">Save changes</button>
        </div>
    </div>

    <div class="page-content-wrapper">
        <!-- Form for Updating IVR Configuration -->
        <form id="ivrForm" action="{{ route('ivr.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <!-- Header Section -->
            <div class="row justify-content-between align-items-center mb-4 header">
                <div class="col text-left">
                    <h2>IVR Configuration</h2>
                </div>

                @if(Auth::user()->business_details && Auth::user()->business_details->schedule_greeting == 1)
                <div class="col-auto">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sheduledModal">Schedule Greeting</button>
                </div>
                @endif
            </div>
            <div class="row">
                <div class="col-2 text-center">
                    <label class="form-label">DID Number</label>
                </div>
                <div class="col-12 col-md-6">

                    <input type="hidden" name="ivr_config_id" value="{{$ivrConfig->id ??''}}" />
                    <input type="text" class="form-control" name="did_number" value="{{ $ivrConfig->did_number ??'' }}" required>
                </div>
                <div class="col-4">

                </div>

            </div>
            </br>
            <div class="row">
                <div class="col-2 text-center">
                    <label class="form-label">Business Phone</label>
                </div>
                <div class="col-12 col-md-6 mt-3 mt-md-0">
                    <input type="text" class="form-control" name="business_phone" value="{{ $ivrConfig->business_phone ??'' }}" required>
                </div>
                <div class="col-4">

                </div>
            </div>

            <div class="row mt-5">
                <div class="col-2 text-center">
                    <label class="form-label"><b>Ivr Type</b></label>
                </div>
                <div class="col-3">
                    <input class="form-check-input ivr-type" type="checkbox"  name="ivr_type" value="TTS"
                        {{ in_array('TTS', $ivrConfig->ivr_type) ? 'checked' : '' }}>
                    <label class="form-check-label">TTS</label>
                </div>
                <div class="col-5">
                    <input class="form-check-input ivr-type" type="checkbox" name="ivr_type" value="Recorded Voice"
                        {{ in_array('Recorded Voice', $ivrConfig->ivr_type) ? 'checked' : '' }}>
                    <label class="form-check-label">Recorded Voice</label>
                </div>
            </div>

            <div class="recorded_voice">
                <div class="row mt-5">
                    <div class="col-12">
                        <label class="form-label"><b>Main Greeting Text</b></label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check">
                                <input type="file" class="form-class" name="tts_audio" id="tts_audio">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="tts">
                <div class="row mt-5">
                    <div class="col-2 text-center">
                        <label class="form-label"><b>&nbsp;&nbsp;TTS Type</b></label>
                    </div>
                    <div class="col-sm-4 col-xs-4 col-md-4 col-xs-4">
                        <label>
                             <input type="radio" name="ttstype" id="john" value="john" {{ optional($ivrConfig)->ttstype == 'john' ? 'checked' : '' }} onchange="speak('John')"> John
                        </label>
                        <span id="johnAudio" class="audio-controls">
                            <button type="button" id="johnPlayButton" onclick="speak('John')"><i class="fa fa-play" aria-hidden="true"></i></button>
                            <button type="button" id="johnPauseButton" onclick="pauseSpeech('John')" disabled><i class="fa fa-pause" aria-hidden="true"></i></button>
                        </span>
                    </div>

                    <div class="col-sm-6 col-xs-6 col-md-6 col-xs-6">
                        <label>
                            <input type="radio" name="ttstype" id="sophia" value="sophia" {{ optional($ivrConfig)->ttstype == 'sophia' ? 'checked' : '' }} onchange="speak('Sophia')"> Sophia
                        </label>
                        <span id="sophiaAudio" class="audio-controls">
                            <button type="button" id="sophiaPlayButton" onclick="speak('Sophia')"><i class="fa fa-play" aria-hidden="true"></i></button>
                            <button type="button" id="sophiaPauseButton" onclick="pauseSpeech('Sophia')" disabled><i class="fa fa-pause" aria-hidden="true"></i></button>
                        </span>
                    </div>
                </div>

                <!-- Main Greeting Text -->
                <div class="row mt-5">
                    <div class="col-2 text-center">
                        <label class="form-label">Main Greeting Text</label>
                    </div>
                    <div class="col-12 col-md-6">
                        <textarea class="form-control" name="main_greeting" id="main_greeting" rows="4" required>{{ $ivrConfig->main_greeting ??'' }}</textarea>
                    </div>
                </div>
            </div>
            @foreach ($departments as $d)
            <div class="row mt-8 button-group">
                <div class="col-sm-12 col-xs-12 col-md-12 col-xs-12 text-center">
                    <button type="button" class="blue-button" 
                        data-ivr_id="{{$ivrConfig->id ?? ''}}" 
                        data-dep-id="{{$d->id}}" 
                        data-dep-name="{{$d->name}}"
                        data-option-text="{{$d->ivr_options[0]->text_greeting ??''}}"
                        data-option-id="{{$d->ivr_options[0]->id ??''}}"
                        data-option-link="{{$d->ivr_options[0]->link ??''}}"
                        onclick="handleButtonClick(event, this)">
                        Press {{$d->assigned_key}} for {{$d->name}} and then say
                        <input type="text" class="form-control" id="button_text" style="width: 242px;margin-right: 439px;" name="button_text" value="{{$d->ivr_options[0]->text_greeting ??''}}" >
                    </button>
                </div>
            </div>
            @endforeach
            <!-- Repeat Count -->
            <div class="row mt-3">
                <div class="col-12 col-md-6">
                    <label class="form-label">Repeat Count</label>
                    <input type="number" class="form-control" name="repeat_count" value="{{ $ivrConfig->repeat_count ??'' }}" required>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-2">
                    <button type="submit" class="btn btn-success w-100">Save</button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="press1Modal" tabindex="-1" aria-labelledby="press1ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="press1ModalLabel">Press 1 for Signup</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Please leave a detailed message and we will contact our orcall sale representative to return your call immediately. Thanks
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    

    <div class="modal fade" id="sheduledModal" tabindex="-1" aria-labelledby="sheduledModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <h3>Schedule greeting</h3>
                    <ul class="nav nav-tabs" style="justify-content: center;">
                        <li class="active"><a data-toggle="tab" href="#home">Schedule Greeting</a></li>
                        <li><a data-toggle="tab" href="#menu1">View Greeting</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <form action="{{ route('ivr.schedule_greeting') }}" method="POST">
                                @csrf
                                <div class="">
                                    <h5 class="text-center">Select Date & Time</h5>
                                    <div class="row justify-content-center">
                                        <div class="col-md-5">
                                            <input type="hidden" name="ivr_config_id" value="{{$ivrConfig->id ??''}}" />
                                            <label class="form-label">Start Date & Time</label>
                                            <input type="datetime-local" required name="start_date_time" class="form-control">
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">End Date & Time</label>
                                            <input type="datetime-local" required name="end_date_time" class="form-control">
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title" required placeholder="Enter Title">
                                    </div>

                                    <div class="mt-3">
                                        <label class="form-label">Greeting Text</label>
                                        <textarea class="form-control" name="greeting_text" required placeholder="Enter Greeting Text"></textarea>
                                    </div>
                                    <!-- 
                            <div class="mt-3 text-center">
                                <button class="btn btn-primary">Choose an audio file</button>
                            </div> -->

                                    <div class="mt-2 text-center">
                                        <button class="btn btn-dark">Save</button>
                                    </div>
                            </form>
                            <p class="mt-3 text-muted text-center">
                                You can add only 10 greetings. You need to delete or edit the greetings if you wish to add more than 10.
                            </p>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Action</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Greeting Text</th>
                                    <th>Recording</th>
                                    <th scope="col">Start Date & Time</th>
                                    <th scope="col">End Date & Time</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ivr_schedule_greeting as $greeting)
                                <tr>
                                    <td>

                                        <a href="javascript:void(0);"
                                            class="edit-schedule-btn"
                                            data-id="{{ $greeting->id }}"
                                            data-ivr="{{ $greeting->ivr_config_id }}"
                                            data-start="{{ $greeting->start_date_time }}"
                                            data-end="{{ $greeting->end_date_time }}"
                                            data-title="{{ $greeting->title }}"
                                            data-text="{{ $greeting->greeting_text }}"
                                            data-toggle="modal"
                                            data-target="#sheduledModaledit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ route('ivr.schedule_greeting.delete', $greeting->id) }}"><i class="fa fa-trash"></i></a>

                                    </td>
                                    <td>{{ $greeting->title }}</td>
                                    <td>{{ $greeting->greeting_text }}</td>
                                     <td>
                                        <button class="btn btn-primary btn-sm play-btn" data-text="{{ $greeting->greeting_text }}">
                                            <i class="fa fa-play"></i>
                                        </button>
                                    </td> 
                                    <td>{{ $greeting->start_date_time }}</td>
                                    <td>{{ $greeting->end_date_time }}</td>
                                </tr>

                                @empty

                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Schedule Modal -->
    <div class="modal fade" id="sheduledModaledit" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Edit Schedule Greeting</h5>
                </div>
                <form id="editScheduleForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">

                        <input type="hidden" name="ivr_config_id" id="ivr_config_id">

                        <label>Start Date & Time</label>
                        <input type="datetime-local" name="start_date_time" id="edit_start_date_time" class="form-control" required>

                        <label>End Date & Time</label>
                        <input type="datetime-local" name="end_date_time" id="edit_end_date_time" class="form-control">

                        <label>Title</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>

                        <label>Greeting Text</label>
                        <textarea name="greeting_text" id="edit_greeting_text" class="form-control"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- popup side -->



    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function handleButtonClick(event, button) {
            event.preventDefault();  
            debugger;
            let ivrConfigId = button.getAttribute("data-ivr_id");
            let ivrDepId = button.getAttribute("data-dep-id");
            let datadepname = button.getAttribute("data-dep-name");
            let dataoptiontext = button.getAttribute("data-option-text");
            let dataoptionid = button.getAttribute("data-option-id");
            let dataoptionlink = button.getAttribute("data-option-link");
             

            document.getElementById("ivr_id_config").value = ivrConfigId;
            document.getElementById("link_send").value = dataoptionlink;
            
            document.getElementById("ivr_dept_id").value = ivrDepId;
            document.getElementById("greeting_option").value = dataoptiontext;
            document.getElementById("ivr_option_id").value = dataoptionid;
            // document.getElementById("ivr_dept_id").value = ivrDepId;
            document.getElementById("ivr-option-dep").value = datadepname;


            document.getElementById("configuration").style.display = "block";
            
        }

        document.querySelector(".close-btn").addEventListener("click", function(event) {
            event.preventDefault();
            document.getElementById("configuration").style.display = "none";
        });

        document.querySelectorAll('.ivr-type').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    document.querySelectorAll('.ivr-type').forEach(cb => {
                        if (cb !== this) {
                            cb.checked = false;
                        }
                    });
                }
            });
        });

        $(document).ready(function() {
            function toggleSections() {
                var selectedValue = $(".ivr-type:checked").val();

                if (selectedValue === "TTS") {
                    $(".tts").show();
                    $(".recorded_voice").hide();
                } else if (selectedValue === "Recorded Voice") {
                    $(".recorded_voice").show();
                    $(".tts").hide();
                } else {
                    $(".tts, .recorded_voice").hide();
                }
            }

            // Initial state on page load
            toggleSections();

            $(".ivr-type").change(function() {
                $(".ivr-type").not(this).prop("checked", false); // Uncheck the other checkbox
                toggleSections();
            });
        });

        
        document.getElementById('ivrForm').addEventListener('submit', function(event) {
            let isValid = true;
            let errorMessage = '';

            // Check DID Number
            let didNumber = document.querySelector('input[name="did_number"]').value;
            if (!didNumber) {
                isValid = false;
                errorMessage += 'DID Number is required.\n';
            }

            // Check Business Phone
            let businessPhone = document.querySelector('input[name="business_phone"]').value;
            if (!businessPhone) {
                isValid = false;
                errorMessage += 'Business Phone is required.\n';
            }

            // Check IVR Type
            let ivrType = document.querySelectorAll('.ivr-type:checked').length;
            if (ivrType === 0) {
                isValid = false;
                errorMessage += 'Please select an IVR Type.\n';
            }

            // Check TTS Type if TTS is selected
            if (document.querySelector('.ivr-type[value="TTS"]:checked')) {
                let ttsType = document.querySelectorAll('input[name="ttstype"]:checked').length;
                if (ttsType === 0) {
                    isValid = false;
                    errorMessage += 'Please select a TTS Type.\n';
                }
            }

            // Check Main Greeting Text
            let mainGreeting = document.getElementById('main_greeting').value;
            if (!mainGreeting) {
                isValid = false;
                errorMessage += 'Main Greeting Text is required.\n';
            }

            // Check Repeat Count
            let repeatCount = document.querySelector('input[name="repeat_count"]').value;
            if (!repeatCount) {
                isValid = false;
                errorMessage += 'Repeat Count is required.\n';
            }

            if (!isValid) {
                alert(errorMessage);
                event.preventDefault();
            }
        });

        $(document).ready(function() {
            $('.edit-schedule-btn').click(function() {
                let id = $(this).data('id');
                let ivrConfigId = $(this).data('ivr');
                let startDate = $(this).data('start');
                let endDate = $(this).data('end');
                let title = $(this).data('title');
                let text = $(this).data('text');

                $('#edit_id').val(id);
                $('#ivr_config_id').val(ivrConfigId);
                $('#edit_start_date_time').val(startDate);
                $('#edit_end_date_time').val(endDate);
                $('#edit_title').val(title);
                $('#edit_greeting_text').val(text);

                // Set form action dynamically
                $('#editScheduleForm').attr('action', '/ivr/schedule_greeting_edit/' + id);
            });
        });
    </script>


    <script>
        let synth = window.speechSynthesis;
        let utterance;
        let isPlaying = false;
        let currentVoice = null; // Track the currently playing voice

        function speak(voiceName) {
            let mainGreetingText = document.getElementById('main_greeting').value;
            if (!mainGreetingText) {
                alert("Please enter some text in the Main Greeting Text field.");
                return;
            }

            if (isPlaying && currentVoice === voiceName) {
                // If the same voice is already playing, pause it
                pauseSpeech(voiceName);
                return;
            } else if (isPlaying) {
                // If another voice is playing, stop it
                synth.cancel();
            }

            utterance = new SpeechSynthesisUtterance(mainGreetingText);
            let voices = synth.getVoices();

            console.log(voices);

            // Set the voice based on the selected option
            if (voiceName === 'John') {
                utterance.voice = voices.find(voice => voice.name.includes('Male') || voice.name.includes('John')) || voices[0];
            } else if (voiceName === 'Sophia') {
                utterance.voice = voices.find(voice => voice.name.includes('Female') || voice.name.includes('Sophia')) || voices[0];
            }

            // Play the speech
            synth.speak(utterance);
            isPlaying = true;
            currentVoice = voiceName;

            // Update button states
            if (voiceName === 'John') {
                document.getElementById('johnPlayButton').disabled = true;
                document.getElementById('johnPauseButton').disabled = false;
                document.getElementById('sophiaPlayButton').disabled = false;
                document.getElementById('sophiaPauseButton').disabled = true;
            } else if (voiceName === 'Sophia') {
                document.getElementById('sophiaPlayButton').disabled = true;
                document.getElementById('sophiaPauseButton').disabled = false;
                document.getElementById('johnPlayButton').disabled = false;
                document.getElementById('johnPauseButton').disabled = true;
            }

            // Handle when speech ends
            utterance.onend = () => {
                isPlaying = false;
                currentVoice = null;
                document.getElementById('johnPlayButton').disabled = false;
                document.getElementById('johnPauseButton').disabled = true;
                document.getElementById('sophiaPlayButton').disabled = false;
                document.getElementById('sophiaPauseButton').disabled = true;
            };
        }

        // Pause functionality
        function pauseSpeech(voiceName) {
            if (isPlaying && currentVoice === voiceName) {
                synth.pause();
                isPlaying = false;
                if (voiceName === 'John') {
                    document.getElementById('johnPlayButton').disabled = false;
                    document.getElementById('johnPauseButton').disabled = true;
                } else if (voiceName === 'Sophia') {
                    document.getElementById('sophiaPlayButton').disabled = false;
                    document.getElementById('sophiaPauseButton').disabled = true;
                }
            }
        }

        // Load voices when the page loads
        window.speechSynthesis.onvoiceschanged = function() {
            synth.getVoices();
        };
    </script>

    <!-- Add this script section at the end of your existing code -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const linkContainer = document.createElement('div');
            linkContainer.id = 'linkContainer';
            document.querySelector('[for="link"]').insertAdjacentElement('afterend', linkContainer);

            document.getElementById('addLink').addEventListener('click', function(e) {
                e.preventDefault();

                const inputGroup = document.createElement('div');
                inputGroup.className = 'input-group mb-2';

                const input = document.createElement('input');
                input.type = 'text';
                input.className = 'form-control';
                input.name = 'link';
                input.placeholder = 'Enter link';

                const removeBtn = document.createElement('button');
                removeBtn.className = 'btn btn-danger';
                removeBtn.type = 'button';
                removeBtn.innerHTML = 'Remove';
                removeBtn.onclick = function() {
                    inputGroup.remove();
                };

                const inputGroupAppend = document.createElement('div');
                inputGroupAppend.className = 'input-group-append';
                inputGroupAppend.appendChild(removeBtn);

                document.getElementById('addLink').remove();

                inputGroup.appendChild(input);
                inputGroup.appendChild(inputGroupAppend);
                linkContainer.appendChild(inputGroup);
            });
        });

        // $(document).ready(function() {
        //     $('#button_text').val($('#greeting_option').val());

        //     $('#greeting_option').on('input', function() {
        //         $('#button_text').val($(this).val());
        //     });
        // });


    $(document).ready(function () {
       
  
    
    $("#save_options").click(function () {
        debugger;

      
            let formData = new FormData();

            let selectedIvrId = $("#ivr_id_config").val();
            let selectedDepId = $("#ivr_dept_id").val();
            let ivroptionId = $("#ivr_option_id").val();

            formData.append("ivrId", selectedIvrId);
            formData.append("depId", selectedDepId);
            formData.append("ivroptionId", ivroptionId);

            let greetingText = $("#greeting_option").val();
            formData.append("greeting", greetingText);
            

            let audioFile = $("#audioGreeting")[0].files[0];
            if (audioFile) {
                formData.append("audioGreeting", audioFile);
            }

            let links = $("#linkContainer input").val();
            formData.append("links", JSON.stringify(links));

            formData.append("_token", "{{ csrf_token() }}");

            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

          
            $.ajax({
                url: "/ivr/save-options",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    alert(response.message);
                    location.reload();
                },
                error: function (xhr) {
                    alert("Error: " + xhr.responseJSON.message);
                }
            });
        });
    });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".play-btn").forEach(button => {
            button.addEventListener("click", function() {
                let text = this.getAttribute("data-text");
                let speech = new SpeechSynthesisUtterance(text);
                speech.lang = "en-US"; // Change language if needed
                speech.rate = 1; // Adjust speed
                window.speechSynthesis.speak(speech);
            });
        });
    });
    </script>
    @endsection