@extends('layouts/layout')
@section('content')
<style>
    body {
        padding: 20px;
        font-family: Arial, sans-serif;
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .header h1 {
        margin: 0;
        font-size: 24px;
    }
    .form-label {
        font-weight: bold;
    }
    .form-control {
        margin-bottom: 15px;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 10px 20px;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    footer {
        text-align: center;
        margin-top: 30px;
        padding: 10px;
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }
    .alert {
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>
</head>
<body>
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <!-- Header -->
        <div class="header">
            <h1>Server Configuration</h1>
        </div>

        <!-- Display success/error messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- SMS Message Form -->
        <form action="{{ route('send.sms') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="sendTo" class="form-label">Send to</label>
                <input type="text" class="form-control" id="sendTo" name="sendTo" placeholder="The number you are sending the message to.">
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="4" placeholder="The message to send."></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send</button>
        </form>

        <!-- Footer -->
        <footer>
            Copyright &copy; 2021 OCAS Platform
        </footer>
    </div>
</div>
@endsection