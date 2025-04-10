<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>oncall Service</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color:rgba(141, 136, 136, 0.82);
            background-size: cover;
            background-position: center;
            box-sizing: border-box;
        }

        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 2px 1000px rgba(0, 0, 0, 0.1);
            width: 360px;
            text-align: center;
        }

        .login-container h2 {
            font-size: 26px;
            color: #333;
            margin-bottom: 30px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .input-field {
            width: 100%;
            padding: 14px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        }

        .btn {
            width: 100%;
            padding: 15px;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .forgot-password {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .forgot-password a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .login-container img {
            width: 240px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <div class="login-container">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" >
    
        <form action="{{ route('admin.authenticate') }}" method="POST">
            @csrf
            <input type="email" name="email" class="input-field" placeholder="Enter your email"
                value="{{ old('email') }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <input type="password" name="password" class="input-field" placeholder="Enter your password" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <div><input type="checkbox"  required style="display: inline;"><div style="margin-bottom: 5px; display: inline;"><p style="margin-left: 5px; font-size: 12px; display: inline;">By checking the box you are opt in to receive sms messages from this platform.</p><p style="cursor: pointer; margin-left: 2px; font-size: 12px; color: blue; display: inline;">opt in agreement</p></div></div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if (session('success'))
            toastr.success('{{ session('success') }}', 'Success');
        @endif

        @if (session('error'))
            toastr.error('{{ session('error') }}', 'error');
        @endif

      toastr.options = {
        "closeButton": true, // Show close button
        "progressBar": true, // Show progress bar
        "positionClass": "toast-top-right", // Position the toast in the top right
        "timeOut": "5000", // Toast will disappear after 5 seconds
        "extendedTimeOut": "1000" // Extended time for closing the toast after hover
      };
  </script>

</body>

</html>
