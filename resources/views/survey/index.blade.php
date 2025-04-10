@extends('layouts.layout')
@section('content')
    <style>
        body {
            padding: 20px;
        }
        .btn-remove {
            margin-top: 8px;
        }
        .audio-upload {
            width: 100%;
        }
    </style>
</head>
<body>
<div class="page-content-wrapper">
    <div class="page-content">
        <h2 class="mt-3">Survey Configuration</h2>

        <div class="d-flex mb-3">
            @foreach($departments as $department)
                <button class="btn btn-primary me-2 department-btn" data-id="{{ $department->id }}">
                    {{ $department->name }}
                </button>
            @endforeach
        </div>

        <!-- Department Selection -->
        <form action="{{ route('survey.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="departmentSelect">Select Department</label>
                <select id="departmentSelect" name="department_id" class="form-select" required>
                    <option value="">-- Select Department --</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Question Container -->
            <div id="questionSection" style="display: none;">
                <button type="button" class="btn btn-primary mt-2" id="addQuestion">Add Question</button>
                <div id="questionContainer"></div>
                <button type="submit" class="btn btn-success mt-3">Save</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        // Department Button Click -> Select Dropdown Auto Change
        $('.department-btn').click(function () {
            var departmentId = $(this).data('id');
            $('#departmentSelect').val(departmentId).trigger('change');
        });

        // Ensure change event is triggered dynamically
        $(document).on("change", "#departmentSelect", function () {
            let departmentId = $(this).val();
            let questionSection = $("#questionSection");
            let questionContainer = $("#questionContainer");

            if (departmentId) {
                questionSection.show();
                questionContainer.html(""); // Purane questions clear karo

                // Fetch questions via AJAX
                $.ajax({
                    url: `/survey/${departmentId}/questions`,
                    method: "GET",
                    dataType: "json",
                    success: function (data) {
                        if (data.questions.length > 0) {
                            data.questions.forEach(function (question) {
                                let newQuestion = `
                                    <div class="question-group mb-3">
                                        <input type="text" name="questions[]" class="form-control" value="${question.question}" required>
                                        <div class="d-flex mt-2">
                                            <input type="file" name="files[]" class="form-control audio-upload">
                                            <button type="button" class="btn btn-danger btn-remove ms-2">Remove</button>
                                        </div>
                                    </div>
                                `;
                                questionContainer.append(newQuestion);
                            });
                        }
                    }
                });
            } else {
                questionSection.hide();
            }
        });

        // Remove question field
        $(document).on("click", ".btn-remove", function () {
            $(this).closest(".question-group").remove();
        });

        // Add New Question
        $("#addQuestion").click(function () {
            let newQuestion = `
                <div class="question-group mb-3">
                    <input type="text" name="questions[]" class="form-control" placeholder="Question" required>
                    <div class="d-flex mt-2">
                        <input type="file" name="files[]" class="form-control audio-upload">
                        <button type="button" class="btn btn-danger btn-remove ms-2">Remove</button>
                    </div>
                </div>
            `;
            $("#questionContainer").append(newQuestion);
        });
    });
</script>
    
@endsection
