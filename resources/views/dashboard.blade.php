@extends('layouts.dashboardLayouts')

@section('ADIDATA', 'Dashboard')

@section('username', Auth::user()->name)
@section('userid', Auth::user()->id)

@section('styles')
    <style>
        /* Styling untuk daftar kandidat */
        #newCandidatesList {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        /* Styling untuk item kandidat */
        .candidate-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        /* Styling untuk gambar profil */
        .profile-img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        /* Styling untuk informasi kandidat */
        .candidate-info {
            display: flex;
            align-items: center;
        }

        .candidate-details {
            font-size: 14px;
        }

        .candidate-details h6 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .job-position {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }

        .join-date {
            margin: 0;
            font-size: 12px;
            color: #999;
        }

        /* Membatasi tinggi dan menambahkan scroll */
        .card-body {
            max-height: 350px;
            /* Atur tinggi maksimal agar scroll muncul jika konten lebih panjang */
            overflow-y: auto;
        }
    </style>

@endsection


@section('content')
    <!-- Container for chat and candidate list -->
    <div class="row mb-5">

        <div class="col-md-8">
            <div class="card" style="height: 400px;">
                <div class="card-header">
                    Permintaan
                </div>
                <div class="card-body" style="height: 100%; overflow: hidden;">
                    <canvas id="salesChart" style="height: 100%; width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" style="height: 400px;">
                <div class="card-header">
                    Kandidat Baru Bergabung
                </div>
                <div class="card-body" style="overflow-y: auto;">
                    <ul id="newCandidatesList">
                        <li class="candidate-item">
                            <div class="candidate-info">
                                <img src="https://via.placeholder.com/50" alt="Profile Picture" class="profile-img">
                                <div class="candidate-details">
                                    <h6>John Doe</h6>
                                    <p class="job-position">Software Engineer</p>
                                    <p class="join-date">Bergabung pada: 01 Januari 2024</p>
                                </div>
                            </div>
                        </li>
                        <li class="candidate-item">
                            <div class="candidate-info">
                                <img src="https://via.placeholder.com/50" alt="Profile Picture" class="profile-img">
                                <div class="candidate-details">
                                    <h6>Jane Smith</h6>
                                    <p class="job-position">Product Manager</p>
                                    <p class="join-date">Bergabung pada: 15 Januari 2024</p>
                                </div>
                            </div>
                        </li>
                        <li class="candidate-item">
                            <div class="candidate-info">
                                <img src="https://via.placeholder.com/50" alt="Profile Picture" class="profile-img">
                                <div class="candidate-details">
                                    <h6>Michael Johnson</h6>
                                    <p class="job-position">UX/UI Designer</p>
                                    <p class="join-date">Bergabung pada: 20 Januari 2024</p>
                                </div>
                            </div>
                        </li>
                        <!-- Tambahkan kandidat baru sesuai kebutuhan -->
                    </ul>
                </div>
            </div>
        </div>



    </div>


    <div class="row">
        <!-- Cards Section -->
        <div class="col-md-4">
            <div class="card text-white bg-primary dashboard-card">
                <div class="card-header">Users</div>
                <div class="card-body">
                    <h5 class="card-title">1200</h5>
                    <p class="card-text">Total registered users</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success dashboard-card">
                <div class="card-header">Sales</div>
                <div class="card-body">
                    <h5 class="card-title">$15,000</h5>
                    <p class="card-text">Total sales this month</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning dashboard-card">
                <div class="card-header">Orders</div>
                <div class="card-body">
                    <h5 class="card-title">350</h5>
                    <p class="card-text">Total orders this week</p>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                datasets: [{
                    label: 'Sales ($)',
                    data: [1200, 1900, 800, 1500, 2000, 1800, 2200], // Example sales data
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Bar color
                    borderColor: 'rgba(75, 192, 192, 1)', // Border color
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>


@endsection
