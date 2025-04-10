@extends('layouts/layout')

@section('content')
    <style>
        body {
            padding: 20px;
        }
        .profile-header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .profile-details {
            margin-top: 20px;
        }
        .profile-details dt {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="page-content-wrapper container">
        <!-- Left Panel -->
        <div class="left-panel">
    <div class="container">
        <div class="profile-header text-center">
            <h1>My Profile</h1>
            <p>OCAS</p>
        </div>

        <div class="profile-details">
            <dl class="row">
                <dt class="col-sm-3">Business Name:</dt>
                <dd class="col-sm-9">On Call Answering Service</dd>

                <dt class="col-sm-3">Title:</dt>
                <dd class="col-sm-9">OCAS</dd>

                <dt class="col-sm-3">Email:</dt>
                <dd class="col-sm-9">rlpinkney@msn.com</dd>

                <dt class="col-sm-3">Phone:</dt>
                <dd class="col-sm-9">318-525-5756</dd>

                <dt class="col-sm-3">Country:</dt>
                <dd class="col-sm-9">United States</dd>

                <dt class="col-sm-3">Timezone:</dt>
                <dd class="col-sm-9">America/Chicago</dd>

                <dt class="col-sm-3">Address:</dt>
                <dd class="col-sm-9">2800 Youree Drive, Suite 363<br>Shreveport, LA 71104</dd>

                <dt class="col-sm-3">Registered On:</dt>
                <dd class="col-sm-9">May 18, 2022, at 2:13 AM</dd>
            </dl>
        </div>

    </div>
    </div>

</div>
@endsection