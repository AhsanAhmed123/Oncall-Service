@extends('layouts/layout')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script
<script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
    #sidePopup {
        position: fixed;  /* Ensures it overlays content */
        top: 0;
        right: 0;
        height: 100vh;
        width: 840px;  /* Adjust as needed */
        background-color: white;
        box-shadow: -2px 0px 10px rgba(0, 0, 0, 0.3);
        transform: translateX(100%);
        transition: transform 0.3s ease-in-out;
        z-index: 1000; /* Ensure it's above other elements */
        padding: 20px;
    }

    #sidePopup.show {
        transform: translateX(0);  /* Moves it into view */
    }

    </style>
    <div class="page-content-wrapper">
      <div class="page-content">

        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
          <div class="breadcrumb-title pe-3">Dashboard</div>
          <div class="ps-3">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb mb-0 p-0 align-items-center">
                <li class="breadcrumb-item"><a href="javascript:;">
                    <ion-icon name="home-outline"></ion-icon>
                  </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Information</li>
              </ol>
            </nav>
          </div> 
          <div class="ms-auto">
            <div class="btn-group">
             
            </div>
          </div>
        </div>
        <!--end breadcrumb-->


        <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-4">
          <div class="col">
            <div class="card radius-10">
              <div class="card-body">
                <div class="d-flex align-items-start gap-2">
                  <div>
                    <p class="mb-0 fs-6">Voicemail recieved</p>
                  </div>
                  <div class="ms-auto widget-icon-small text-white bg-gradient-purple">
                    <ion-icon name="wallet-outline"></ion-icon>
                  </div>
                </div>
                <div class="d-flex align-items-center mt-3">
                  <div>
                    <h4 class="mb-0">{{ $voicemail }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card radius-10">
              <div class="card-body">
                <div class="d-flex align-items-start gap-2">
                  <div>
                    <p class="mb-0 fs-6">On-call person</p>
                  </div>
                  <div class="ms-auto widget-icon-small text-white bg-gradient-info">
                    <ion-icon name="people-outline"></ion-icon>
                  </div>
                </div>
                <div class="d-flex align-items-center mt-3">
                  <div>
                    <h4 class="mb-0">{{ $oncallperson }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card radius-10">
              <div class="card-body">
                <div class="d-flex align-items-start gap-2">
                  <div>
                    <p class="mb-0 fs-6">Callback made</p>
                  </div>
                  <div class="ms-auto widget-icon-small text-white bg-gradient-danger">
                    <ion-icon name="bag-handle-outline"></ion-icon>
                  </div>
                </div>
                <div class="d-flex align-items-center mt-3">
                  <div>
                    <h4 class="mb-0">0</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--end row-->
        </br>
        </br>
        
         <div id="chartContainer">
            <canvas id="incomingCallsChart"></canvas>
        </div>
            
        </br>
        </br>
        
         <div class="">
        <h2 class="text-2xl font-bold mb-4">Voicemail Logs</h2>
<button id="deleteSelected" class="bg-red-500 text-white px-4 py-2 rounded">Delete Selected</button>

        <div class="bg-white shadow-md rounded-lg overflow-hidden" id="voicemailTable">
          <table class="table-auto w-full border-collapse border border-gray-400">
        <thead>
            <tr class="bg-gray-200 text-gray-700">
                <th><input type="checkbox" name="check"></th>
                <th class="p-3 text-left">Date</th>
                <th class="p-3 text-left">Call Start Time</th>
                <th class="p-3 text-left">Phone No</th>
                <th class="p-3 text-left">Voicemail</th>
                <th class="p-3 text-left">Voicemail Transcription</th>
                <!--<th class="p-3 text-left">On-Call Person</th>-->
                <th class="p-3 text-left">Acknowledged</th>
                <th class="p-3 text-left">Callback Count</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach ($voicemail_details as $recording)
            <tr class="clickable-row cursor-pointer" 
                data-date="{{ \Carbon\Carbon::parse($recording->start_time)->format('Y-m-d') }}"
                data-time="{{ \Carbon\Carbon::parse($recording->start_time)->format('H:i:s') }}"
                data-phone="{{ $recording->from_number??'' }}"
                data-call-id="{{ $recording->id }}"
                data-department="{{ $recording->department->name??'' }}"
                data-voicemail="{{ $recording->recording_url??'' }}"
                data-transcription="{{ $recording->transcription ?? 'N/A' }}"
                data-oncall="John Doe, New York"
                data-acknowledged="Yes"
                data-callback="0">
             
                    <td>
                        <input type="checkbox" name="check[]" value="{{ $recording->call_sid }}">
                    </td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($recording->start_time)->format('Y-m-d') }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($recording->start_time)->format('H:i:s') }}</td>
                    <td class="p-3">{{ $recording->from_number }}</td>
                    <td class="p-3">
                        @if ($recording->recording_url)
                            <button onclick="playVoicemail('{{ $recording->recording_url }}')" class="bg-blue-500 text-white px-4 py-1 rounded">
                                <i class="fa fa-play" style="color:black;"></i>
                            </button>
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="p-3">
                        {{ $recording->transcription ?? 'N/A' }}
                    </td>
                    <!--<td class="p-3"></td>-->
                    <td class="p-3">
                        @if ($recording->acknowledged)
                            Yes
                        @else
                            No
                        @endif
                    </td>
                    <td class="p-3">{{ $recording->callback_count ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

  <!-- Side Popup -->
<div id="sidePopup" class="fixed right-0 top-0 h-full w-96 bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out p-5 overflow-y-auto">
    <button onclick="closePopup()" style="float: left !important;" class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 text-lg font-bold"><b> &times; </b></button>
  
    <div class="row">
        <div class="col-md-6" >
            <!-- Popup Header -->
            <h3 class="text-xl font-semibold mb-6 text-gray-800">Voicemail Details</h3>

            <!-- Oncall Person Section -->
            <!--<div class="mb-6" style="border: 1px solid;border-radius: 17px 17px 17px 17px;padding: 14px;">-->
            <!--    <h4 class="text-lg font-semibold text-gray-700 mb-2">Oncall Person</h4>-->
            <!--    <p class="text-sm text-gray-900" id="popupOnCall"></p>-->
            <!--</div>-->
            
            <div class="mb-6" style="border: 1px solid;border-radius: 17px 17px 17px 17px;padding: 14px;">
                <h4 class="text-lg font-semibold text-gray-700 mb-2" id="popupDepartment"></h4>
                
                <p><strong>Voicemail:</strong> <span id="popupVoicemail"></span></p>
               
            </div>
        </div>

        <div class="col-md-6">
           <form id="callbackForm">
    <div class="mb-6">
        <h4 class="text-lg font-semibold text-gray-700 mb-2">Callbacks</h4>
        <div class="bg-gray-100 p-4 rounded-lg">
            <h5 class="text-md font-semibold text-gray-700 mb-2">Caller</h5>
            <input type="text" name="name" placeholder="name" class="form-control">
            <br>
            <input type="text" name="dob" placeholder="Dob" class="form-control">
            <br>
            <input type="hidden" name="call_recording_id" class="form-control" id="call_recording_id">
            <textarea name="callback_notes" placeholder="notes" class="form-control"></textarea>
            <br>
            <div class="mt-4">
                <h6 class="text-sm font-semibold text-gray-700 mb-2">Notes</h6>
            <ul class="list-disc list-inside text-sm text-gray-900" 
            id="notesList">
              
            </ul>
            </div>
            <div class="mt-4 flex justify-between">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
                <button type="button" id="deleteBtn" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
            </div>
        </div>
    </div>
</form>


        </div>
    </div>
</div>   
    <!-- Audio Player (hidden) -->
    <audio id="voicemailPlayer" controls style="display: none;"></audio>



        </div>
    </div>  

              </div>
            </div>
          </div>
        </div> -->
        <!--end row-->
      </div>
      <!-- end page content-->
    </div>


    <!--Start Back To Top Button-->
    <a href="javaScript:;" class="back-to-top">
      <ion-icon name="arrow-up-outline"></ion-icon>
    </a>
    <!--End Back To Top Button-->


    <!--start overlay-->
    <div class="overlay nav-toggle-icon"></div>
    <!--end overlay-->

  </div>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        
 
        <script>
            $(document).ready(function(){
                var onCallCount = {{ $voicemail }}; // Pass the count from Blade to JS
        
                var ctx = $("#incomingCallsChart");
        
                var incomingCallsChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: Array.from({ length: onCallCount + 1 }, (_, i) => i.toString()),
                        datasets: [{
                            label: "Voice Mail",
                            data: Array.from({ length: onCallCount + 1 }, (_, i) => i), 
                            backgroundColor: "blue",
                            borderColor: "blue",
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1 // Only whole numbers
                                }
                            }
                        }
                    }
                });
            });
        </script>
        
        
        <script>
     $(document).ready(function() {
            $('#voicemailTable table').DataTable(); // Initialize on the table element inside the div
        });


    </script>
    <script>
            function playVoicemail(url) {
                let audio = new Audio(url);
                audio.play();
            }
        </script>
     
     <script>
      $(document).ready(function () {
          $(".clickable-row").on("click", function () {
             
              $("#sidePopup").addClass("show");

              // Extract data from the clicked row
              const date = $(this).data("date");
              const department = $(this).data("department");
              const time = $(this).data("time");
              const call_recording_id = $(this).data("call-id");
              const phone = $(this).data("phone");
              const voicemailUrl = $(this).data("voicemail");
              const transcription = $(this).data("transcription");
              const oncallPerson = $(this).data("oncall");
              const acknowledged = $(this).data("acknowledged");
              const callbackCount = $(this).data("callback");

              // Populate the popup with the extracted data
              $("#popupDate").text(date);
              $("#popupDepartment").text(department);
              $("#call_recording_id").val(call_recording_id);
              $("#popupTime").text(time);
              $("#popupPhone").text(phone);
              $("#popupVoicemail").html(voicemailUrl !== "N/A" ? 
                  `<a href="${voicemailUrl}" target="_blank" class="text-blue-500 hover:text-blue-700 underline">Play Voicemail</a>` : "N/A"
              );
              $("#popupTranscription").text(transcription);
              $("#popupOnCall").text(oncallPerson);
              $("#popupAcknowledged").text(acknowledged);
              $("#popupCallback").text(callbackCount);
              fetchNotes(call_recording_id);
          });

          // Close popup
          function closePopup() {
              $("#sidePopup").removeClass("show");
          }
          $("button[onclick='closePopup()']").on("click", function() {
              closePopup();
          });
      });
      </script>
        <script>
$(document).ready(function () {
    $(".clickable-row").on("click", function () {
        $("#sidePopup").addClass("show");  // Show popup

        // Extract Data
        let voicemailUrl = $(this).data("voicemail");
        let audioPlayer = voicemailUrl 
            ? `<audio controls>
                   <source src="${voicemailUrl}" type="audio/mpeg">
                   Your browser does not support the audio element.
               </audio>` 
            : "N/A";

        // Set Popup Content
        $("#popupDate").text($(this).data("date"));
        $("#popupTime").text($(this).data("time"));
        $("#popupPhone").text($(this).data("phone"));
        $("#popupVoicemail").html(audioPlayer);  // Inject Audio Player
        $("#popupTranscription").text($(this).data("transcription"));
        $("#popupOnCall").text($(this).data("oncall"));
        $("#popupAcknowledged").text($(this).data("acknowledged"));
        $("#popupCallback").text($(this).data("callback"));
        
    });

    // Close Popup
    $("button[onclick='closePopup()']").on("click", function() {
        $("#sidePopup").removeClass("show");
    });
});
function fetchNotes(callRecordingId) {
    console.log("Fetching notes for callRecordingId:", callRecordingId); // Debugging
    $.ajax({
        url: `/fetch-notes/${callRecordingId}`,
        type: "GET",
        success: function (response) {
            console.log("Notes fetched:", response); // Debugging

            // Clear existing notes
            $("#notesList").empty();

            // Check if response is an array
            if (Array.isArray(response)) {
                // Append new notes
                response.forEach(function (note) {
                    $("#notesList").append(`<li>${note.notes}</li>`);
                });
            } else {
                console.error("Invalid response format:", response);
                alert("Invalid response format. Expected an array.");
            }
        },
        error: function (xhr) {
            console.error("Error fetching notes:", xhr.responseText); // Debugging
            alert("Error fetching notes: " + xhr.responseText);
        }
    });
}
  
</script>


<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // 
            }
        });

        $("#callbackForm").on("submit", function (e) {
            e.preventDefault(); 

            $.ajax({
                url: "/submit-callback",
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    alert("Form submitted successfully!");
                    location.reload();
                },
                error: function (xhr) {
                    alert("Error submitting form: " + xhr.responseText);
                }
            });
        });

    $('#deleteSelected').click(function() {
        var selected = [];
        $('input[name="check[]"]:checked').each(function() {
            selected.push($(this).val());
        });

        if (selected.length === 0) {
            alert('Please select at least one record to delete.');
            return;
        }

        if (!confirm('Are you sure you want to delete selected records?')) {
            return;
        }

        $.ajax({
            url: '{{ route("voicemail.delete") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                call_sids: selected
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Error deleting records.');
                }
            }
        });
    });
});


  
</script>


@endsection