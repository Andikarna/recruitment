@extends('layouts.dashboardLayouts')

@section('ADIDATA', 'Dashboard Management')

@section('username', Auth::user()->name)
@section('userid', Auth::user()->id)

@section('styles')
    <style>

    </style>

@endsection

@section('title-content', 'Dashboard Management')

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
                                <p style="font-size: 16px; color: #666;">Belum ada Tugas baru yang tersedia</p>
                            </div>
                        @else
                            @foreach ($assignTodo as $data)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-person-check text-warning me-2" style="font-size: 20px;"></i>

                                        <div>
                                            <div class="fw-bold">{{ $data->title }}</div>
                                            <small>{{ $data->description }}</small>
                                        </div>
                                    </div>

                                    <a href="{{ route('updateOfferingManagement', [$data->action_id]) }}"
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

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-3">
                    <div class="card text-white bg-primary dashboard-card" style="height: 200px; border-radius: 10px;">
                        <div class="card-header">Baru</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $interviewNew }}</h5>
                            <p class="card-text">Kandidat Interview Baru</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info dashboard-card" style="height: 200px; border-radius: 10px;">
                        <div class="card-header">Interview</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $interview }}</h5>
                            <p class="card-text">Kandidat Sedang Interview</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning dashboard-card" style="height: 200px; border-radius: 10px;">
                        <div class="card-header">Offering</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $offering }}</h5>
                            <p class="card-text">Sedang Dalam Penawaran</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success dashboard-card" style="height: 200px; border-radius: 10px;">
                        <div class="card-header">Onboarding</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $onboarding }}</h5>
                            <p class="card-text">Kandidat Onboard</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" style="height: 200px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <div class="card-header"
                    style="background-color: #2DAA9E; color: white; font-weight: bold; border-radius: 10px 10px 0 0;">
                    Kandidat Baru Bergabung
                </div>

                <div class="card-body" style="overflow-y: auto; padding: 15px;">
                    @if ($newCandidate->isEmpty())
                        <div style="text-align: center; margin-top: 20px;">
                            <img src="{{ asset('images/no_data1.jpg') }}" alt="No Data"
                                style="width: 60px; height: 60px; margin-bottom: 10px;">
                            <p style="font-size: 16px; color: #666;">Belum ada kandidat baru yang tersedia</p>
                        </div>
                    @else
                        @foreach ($newCandidate as $data)
                            <div style="display: flex; align-items: center; margin-bottom: 15px; gap: 10px;">
                                <img src="https://picsum.photos/id/{{ $data->candidate_id }}/50/50" alt="Profile Picture"
                                    class="profile-img" style="border-radius: 50%; margin-right: 15px;">
                                <div class="candidate-details">
                                    <h6 style="margin: 0; font-size: 14px; font-weight: bold;">{{ $data->name }}</h6>
                                    <p class="job-position" style="margin: 2px 0; font-size: 12px; color: #666;">
                                        {{ $data->resourceDetail->position }}</p>
                                    <p class="join-date" style="margin: 0; font-size: 12px; color: #999;">Bergabung pada:
                                        {{ Carbon\Carbon::parse($data->join_date)->translatedFormat('d M Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
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

            fetch('/dashboardhr/getResource')
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
                    fetch(`/dashboardhr/getRecruiter/${selectedId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(requestData => {
                            const labels = requestData.labels;
                            const data = requestData.data;
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
                                        label: 'Pemenuhan',
                                        data: data,
                                        backgroundColor: '#2DAA9E',
                                        borderColor: '#2DAA9E',
                                        borderWidth: 1,
                                        barThickness: 50
                                    }]
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
                                            // title: {
                                            //     display: true,
                                            //     text: 'Jumlah Permintaan',
                                            //     font: {
                                            //         size: 14
                                            //     },
                                            //     color: '#000'
                                            // },
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
