@extends('layouts.app')

@section('ADIDATA', 'Login')

@section('content')
    <style>
        body {
            /* background:
                url('{{ asset('images/bg_1.jpg') }}') no-repeat,
                url('{{ asset('images/bg_2.jpg') }}') no-repeat; */
            background-color: #ffffff;
            /* Warna latar belakang */
            background-size: 500px, 500px;
            /* Ukuran gambar */
            background-attachment: fixed;
            /* Latar tidak akan bergeser saat scroll */
            background-position: bottom left, bottom right;
            /* Atur posisi gambar */
            color: #333333;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
        }

        .btn-primary {
            background: #4facfe;
            border-color: #4facfe;
        }

        .btn-primary:hover {
            background: #00f2fe;
            border-color: #00f2fe;
        }
    </style>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow" style="width: 400px;">
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/adidata.png') }}" alt="Logo" style="width: 250px; height: auto;">
                </div>

                {{-- @if (session('success'))
                    <div class="alert alert-danger">
                        {{ session('success') }}
                    </div>
                @endif --}}

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter your password" required>
                            <button type="button" class="btn btn-outline-secondary" id="toggle-password"
                                onclick="togglePassword()">
                                <i class="bi bi-eye" id="eye-icon"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Function to toggle password visibility
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");

            // Toggle password visibility
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("bi-eye");
                eyeIcon.classList.add("bi-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("bi-eye-slash");
                eyeIcon.classList.add("bi-eye");
            }
        }
    </script>
@endsection
