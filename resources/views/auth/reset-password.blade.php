
@section('content')
<main class="py-5" style="background-color: #f7f9fc; min-height: 100vh;">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card shadow-lg rounded-3 p-4" style="width: 100%; max-width: 500px;">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h4 class="fw-bold">Reset Your Password</h4>
                    <p class="text-muted small">Enter your new password below to reset your account.</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required placeholder="you@example.com">
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control" required placeholder="••••••••">
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="••••••••">
                    </div>

                    <button type="submit" class="btn btn-success w-100">Reset Password</button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none text-primary small">← Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
