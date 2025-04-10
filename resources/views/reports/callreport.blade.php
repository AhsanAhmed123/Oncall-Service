@extends('layouts.layout')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <style>
        .play-button {
            background-color: #3b82f6;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            cursor: pointer;
        }
    </style>

    <div class="page-content-wrapper container">
        <div class="container mx-auto">
            <h2 class="text-2xl font-bold mb-4">Voicemail Logs</h2>

            <!-- Filter Section -->
                      <!-- Filter Section -->
            <div class="mb-4">
                <input type="text" id="filterPhone" placeholder="Filter by Phone Number" class="p-2 border rounded">
                <input type="date" id="filterStartDate" placeholder="Filter by Start Date (YYYY-MM-DD)" class="p-2 border rounded">
                <input type="date" id="filterEndDate" placeholder="Filter by End Date (YYYY-MM-DD)" class="p-2 border rounded">
                <button id="applyFilter" class="bg-blue-500 text-white px-4 py-2 rounded">Apply Filter</button>
                <button id="clearFilter" class="bg-gray-500 text-white px-4 py-2 rounded">Clear Filter</button>
            </div>


            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table id="voicemailTable" class="table-auto w-full border-collapse border border-gray-400">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th><input type="checkbox" id="checkAll"></th>
                            <th class="p-3 text-left">Date</th>
                            <th class="p-3 text-left">Call Start Time</th>
                            <th class="p-3 text-left">Phone No</th>
                            <th class="p-3 text-left">Voicemail</th>
                            <th class="p-3 text-left">Voicemail Transcription</th>
                            <th class="p-3 text-left">On-Call Person</th>
                            <th class="p-3 text-left">Acknowledged</th>
                            <th class="p-3 text-left">Callback Count</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($voicemail_details as $recording)
                            <tr>
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
                                <td class="p-3"></td>
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
            </div>
            <audio id="voicemailPlayer" controls style="display: none;"></audio>
        </div>
    </div>

    <script>
     $(document).ready(function() {
    // Initialize DataTable
        const table = $('#voicemailTable').DataTable();
    
        // Apply filter
        $('#applyFilter').on('click', function() {
            const phoneFilter = $('#filterPhone').val();
            const startDateFilter = $('#filterStartDate').val();
            const endDateFilter = $('#filterEndDate').val();
    
            // Filter by Phone Number (column 3)
            table.columns(3).search(phoneFilter).draw();
    
            // Filter by Start Date (column 1)
            table.columns(1).search(startDateFilter).draw(); // Apply filter on start date (column 1)
    
            // Filter by End Date (column 2) - assuming the end date is stored in the same format
            table.rows().every(function() {
                const row = this.data();
                const startDate = row[1]; // Assuming start date is in the 2nd column
                const endDate = row[2]; // Assuming end date is in the 3rd column
                
                if (
                    (startDateFilter && startDate < startDateFilter) || 
                    (endDateFilter && endDate > endDateFilter)
                ) {
                    this.node().style.display = 'none'; // Hide rows not matching date range
                } else {
                    this.node().style.display = ''; // Show rows that match
                }
            });
        });
    
        // Clear filter
        $('#clearFilter').on('click', function() {
            $('#filterPhone').val('');
            $('#filterStartDate').val('');
            $('#filterEndDate').val('');
            table.columns().search('').draw(); // Clear all filters
        });
    
        // Select all checkboxes
        $('#checkAll').on('change', function() {
            $('input[name="check[]"]').prop('checked', this.checked);
        });
    });

        function playVoicemail(url) {
            let audio = new Audio(url);
            audio.play();
        }
    </script>
@endsection