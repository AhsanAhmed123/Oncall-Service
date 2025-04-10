@extends('layouts/layout')

@section('content')
<style>
        body {
            background-color:rgb(255, 255, 255);
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .main-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-top: 5px;
        }
        .btn-save {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        .btn-save:hover {
            background-color: #0056b3;
        }
        .footer-links {
            margin-top: 20px;
            text-align: center;
        }
        .footer-links a {
            margin: 0 10px;
            color: #007bff;
            text-decoration: none;
        }
        .footer-links a:hover {
            text-decoration: underline;
        }
        .copyright {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
        .help-section {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
        .help-section a {
            color: #007bff;
            text-decoration: none;
        }
        .help-section a:hover {
            text-decoration: underline;
        }
    </style>
 <div class="page-content-wrapper container">
    <!-- Left Panel -->
    <div class="left-panel">
        <h2>Reset User Password</h2>

        <!-- Reset Password Form -->
        <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="old_password">Old Password*</label>
                            <input type="password" id="old_password" name="old_password" required>
                            @if ($errors->has('old_password'))
                                <div class="text-danger">{{ $errors->first('old_password') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6"></div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="new_password">New Password*</label>
                            <input type="password" id="new_password" name="new_password" required>
                            @if ($errors->has('new_password'))
                                <div class="text-danger">{{ $errors->first('new_password') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6"></div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="new_password_confirmation">Confirm New Password*</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                            @if ($errors->has('new_password_confirmation'))
                                <div class="text-danger">{{ $errors->first('new_password_confirmation') }}</div>
                            @endif
                        </div>
                    </div>

                    <div style="padding-top: 20px;">
                        <div class="col-md-6"></div>
                        <div class="col-md-1">
                            <button type="submit" class="btn-save" style="border-radius: 18px">SAVE</button>
                        </div>
                    </div>
                </div>
            </form>

    </div>
    
@endsection