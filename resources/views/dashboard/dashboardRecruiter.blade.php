@extends('layouts.dashboardLayouts')

@section('ADIDATA', 'Dashboard Recruiter')

@section('username', Auth::user()->name)
@section('userid', Auth::user()->id)

@section('styles')
    <style>
        .scrollable-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .scrollable-list::-webkit-scrollbar {
            width: 6px;
        }

        .scrollable-list::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }

        .scrollable-list::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        .list-group-item:hover {
            transform: translateY(-5px);
            background-color: #f1f1f1;
            cursor: pointer;
        }
    </style>

@endsection

@section('title-content', 'Dashboard Recruiter')

@section('content')
    <!-- Container for chat and candidate list -->
    <div class="row bg-white p-3 g-3" style="height:100vh; border-radius: 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
        <div class="col-md-8">
            <div class="card" style="height: 400px; border-radius: 10px;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Permintaan SDM</span>
                    <select id="requestDropdown" class="form-select" style="width: auto;">
                        <option disabled>Pilih Permintaan</option>
                    </select>
                </div>
                <div class="card-body" style="height: 100%; overflow: hidden;">
                    <canvas id="recruiterChart" style="height: 100%; width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" style="height: 400px; border-radius: 10px;">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="bi bi-list-task me-2" style="font-size: 24px;"></i>
                    Tugas Hari Ini
                </div>
                <div class="card-body overflow-auto">
                    <ul class="list-group">

                        @if ($assignTodo->isEmpty())
                            <div style="text-align: center; margin-top: 20px;">
                                <img src="{{ asset('images/no_data2.jpg') }}" alt="No Data"
                                    style="width: 150px; height: 130px; margin-bottom: 10px;">
                                <p style="font-size: 16px; color: #666;">Belum ada Tugas Baru yang tersedia</p>
                            </div>
                        @else
                            @foreach ($assignTodo as $data)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-people text-success me-2" style="font-size: 20px;"></i>
                                        <div>
                                            <div class="fw-bold">{{ $data->name }}</div>
                                            <small>{{ $data->interview_progress }}</small>
                                            <br>
                                            <small>Posisi: <span class="text-muted">{{ $data->position }}</span></small>
                                            <br>
                                            <small>Jam Interview: <span
                                                    class="text-muted">{{ \Carbon\Carbon::parse($data->interview_detail->interview_time)->format('H:i') }}</span></small>
                                        </div>
                                    </div>

                                    <a href="{{ route('detailInterview', [$data->id]) }}"
                                        class="d-flex align-items-center text-primary">
                                        <i class="bi bi-arrow-right-circle" style="font-size: 20px;"></i>
                                    </a>
                                </li>
                            @endforeach
                        @endif

                    </ul>
                </div>
            </div>
        </div>

        <div class="col-8">
            <div class="card list-group scrollable-list"
                style="height: 200px; overflow-y: auto; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                @foreach ($resource as $data)
                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 shadow-sm mb-3"
                        style="transition: transform 0.2s ease; border-radius: 8px; padding: 15px;">

                        <div class="d-flex align-items-center">
                            <img src="https://picsum.photos/id/1/200/300" alt="Profile Picture" class="rounded-circle"
                                width="50" height="50" style="margin-right: 15px;">
                            <div class="text-left">
                                <h5 class="mb-1" style="font-size: 16px; font-weight: bold;">{{ $data->name }}</h5>
                                <p class="mb-0" style="font-size: 12px; color: #666;">Posisi: <span
                                        style="font-weight: 600;">{{ $data->resource_detail->position }}</span></p>
                            </div>
                        </div>

                        <div class="text-center">
                            <p class="mb-0" style="font-size: 14px; color: #666;">
                                Klien : <span style="font-weight: 600;">{{ $data->client }}</span>
                            </p>
                            <p class="mb-0" style="font-size: 14px; color: #666;">
                                Proyek : <span style="font-weight: 600;">{{ $data->project }}</span>
                            </p>
                        </div>

                        <!-- Bagian Kanan: Quantity -->
                        <span
                            class="badge {{ $data->resource_detail->quantity < 5 ? 'bg-primary' : 'bg-success' }} rounded-pill"
                            style="font-size: 14px; padding: 6px 12px;">{{ $data->resource_detail->quantity }}</span>
                    </div>
                @endforeach
            </div>
        </div>


        <div class="col-md-4">
            <div class="card" style="height: 200px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <div class="card-header"
                    style="background-color: #2DAA9E; color: white; font-weight: bold; border-radius: 10px 10px 0 0;">
                    Kandidat Baru Bergabung
                </div>

                <div class="card-body" style="overflow-y: auto; padding: 15px;">
                    <ul id="newCandidatesList" style="list-style: none; padding: 0; margin: 0;">
                        @if ($newCandidate->isEmpty())
                            <div style="text-align: center; margin-top: 20px;">
                                <img src="{{ asset('images/no_data1.jpg') }}" alt="No Data"
                                    style="width: 60px; height: 60px; margin-bottom: 10px;">
                                <p style="font-size: 16px; color: #666;">Belum ada kandidat baru yang tersedia</p>
                            </div>
                        @else
                            @foreach ($newCandidate as $data)
                                <li class="candidate-item"
                                    style="display: flex; align-items: center; justify-content:center;margin-bottom: 15px; gap:10px;">
                                    <img src="https://picsum.photos/id/{{ $data->candidate_id }}/50/50"
                                        alt="Profile Picture" class="profile-img"
                                        style="border-radius: 50%; margin-right: 15px;">
                                    <div class="candidate-details">
                                        <h6 style="margin: 0; font-size: 14px; font-weight: bold;">{{ $data->name }}</h6>
                                        <p class="job-position" style="margin: 2px 0; font-size: 12px; color: #666;">
                                            {{ $data->resourceDetail->position }}</p>
                                        <p class="join-date" style="margin: 0; font-size: 12px; color: #999;">Bergabung
                                            pada:
                                            {{ Carbon\Carbon::parse($data->join_date)->translatedFormat('d M Y') }}</p>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>


    </div>



@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dropdown = document.getElementById("requestDropdown");
            const ctx = document.getElementById("recruiterChart").getContext("2d");
            let recruiterChart;

            fetch('/dashboard/recruiter/getResource')
                .then(response => response.json())
                .then(data => {
                    const last = data.lastId.id;
                    console.log('Last ID:', last);

                    data.requests.forEach(request => {
                        const option = document.createElement("option");
                        option.value = request.id;
                        option.textContent = request.name;

                        if (request.id == last) {
                            option.selected = true;
                            option.value = request.id;
                        }

                        dropdown.appendChild(option);
                    });

                    dropdown.dispatchEvent(new Event("change"));
                });

            dropdown.addEventListener("change", function() {
                const selectedId = dropdown.value;
                if (selectedId) {
                    fetch(`/dashboard/positon/${selectedId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(requestData => {
                            const labels = [requestData.labels];
                            const data = [requestData.data];
                            const data2 = [requestData.max - requestData.data];
                            const max = requestData.max;

                            // Perbarui chart
                            if (recruiterChart) {
                                recruiterChart.destroy();
                            }

                            recruiterChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                            label: 'Sudah Terpenuhi',
                                            data: data,
                                            backgroundColor: '#007bff',
                                            borderColor: '#007bff',
                                            borderWidth: 1,
                                            barThickness: 50
                                        },
                                        {
                                            label: 'Belum Terpenuhi',
                                            data: data2,
                                            backgroundColor: '#C0C0C0',
                                            borderColor: '#C0C0C0',
                                            borderWidth: 1,
                                            barThickness: 50
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        x: {
                                            grid: {
                                                display: false
                                            },
                                        },
                                        y: {
                                            grid: {
                                                display: false
                                            },
                                            beginAtZero: true,
                                            min: 0,
                                            max: max,
                                            ticks: {
                                                stepSize: 1
                                            }
                                        }
                                    }
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching recruiter data:', error);
                            alert(`Error fetching recruiter data: ${error.message}`);
                        });
                }
            });

        });
    </script>


@endsection
