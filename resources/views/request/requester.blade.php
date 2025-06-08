@extends('layouts.dashboardLayouts')

@section('ADIDATA', 'Requester')

@section('username', Auth::user()->name)
@section('userid', Auth::user()->id)

@section('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        /* Hilangkan border pada tab aktif */
        .nav-tabs .nav-link.active {
            border: none;
            box-shadow: none;
            background-color: transparent;
            /* Opsional untuk membuat latar belakang lebih bersih */
        }

        /* Atur hover untuk tab */
        .nav-tabs .nav-link:hover {
            color: #0056b3;
            /* Ubah warna teks saat hover */
        }

        .actions-column {
            position: sticky;
            right: 0;
            background-color: white;
            z-index: 1;
        }

        .nowrap {
            white-space: nowrap;
            /* Prevent text wrapping in table cells */
        }

        .custom-select-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .custom-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 30px;
            /* Memberikan ruang untuk ikon */
        }

        .select-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            pointer-events: none;
            /* Agar ikon tidak menghalangi dropdown */
        }
    </style>
@endsection

@section('title-content', 'Permintaan SDM')

@section('content')
    <div class="row bg-white p-3" style="border-radius: 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
        <div class="col-12 d-flex justify-content-between align-items-center py-3 border-bottom">
            <div class="d-flex align-items-center">
                <i class="fas fa-users text-primary me-2" style="font-size: 1.5rem;"></i>
                <h5 class="mb-0">Permintaan SDM</h5>
            </div>

            {{-- tampilan konfirmasi --}}
            @if (session('message'))
                <div class="alert alert-success alert-dismissible fade show w-40 m-2" id="successAlert" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                data-bs-target="#addRequestModal">
                <i class="fas fa-plus me-2"></i> Tambah Permintaan
            </button>
        </div>

        {{-- header tabel --}}
        <div class="col-12 mt-3">
            <div class="d-flex justify-content-end align-items-center">
                <form method="GET" action="{{ route('requester') }}">
                    <input type="text" name="search" id="searchBox" class="form-control" placeholder="Search..."
                           style="width: 300px;" value="{{ request('search') }}" onchange="this.form.submit()">
                </form>
            </div>
        </div>

        {{-- tabel --}}
        <div class="mt-3" style="width:160vh; height: 360px; overflow: auto;">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="nowrap">No</th>
                        <th class="nowrap">Nama Permintaan</th>
                        <th class="nowrap">Peminta</th>
                        <th class="nowrap">Klien</th>
                        <th class="nowrap">Proyek</th>
                        <th class="nowrap text-center">Recruiter</th>
                        <th class="nowrap">Level Prioritas</th>
                        <th class="nowrap">Deadline</th>
                        <th class="nowrap">Status</th>
                        <th class="actions-column text-center bg-white" style="min-width: 20px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resource as $key => $data)
                        <tr>
                            <td class="nowrap align-middle text-center">
                                {{ ($resource->currentPage() - 1) * $resource->perPage() + $key + 1 }}</td>
                            <td class="nowrap align-middle ">{{ $data->name }}</td>
                            <td class="nowrap align-middle text-center">{{ $data->created_by }}</td>
                            <td class="nowrap align-middle text-wrap">{{ $data->client }}</td>
                            <td class="align-middle"
                                style="max-width: 200px; break-word; word-wrap: break-word; white-space: normal;">
                                {{ $data->project }}
                            </td>
                            <td class="nowrap align-middle text-center text-wrap">
                                @php
                                    $found = false;
                                @endphp
                                @foreach ($recruiter as $user)
                                    @if ($user->resource_id == $data->id)
                                        @if ($found)
                                            ,
                                        @endif
                                        {{ $user->username }}
                                        @php
                                            $found = true;
                                        @endphp
                                    @endif
                                @endforeach
                                @if (!$found)
                                    -
                                @endif
                            </td>
                            <td class="nowrap align-middle text-center">{{ $data->level_priority }}</td>
                            <td class="nowrap align-middle text-center">
                                {{ optional($data->target_date)->format('d M y') ?: '-' }}</td>
                            <th class="align-middle text-center">
                                @if ($data->status == 'Baru')
                                    <button class="btn btn-primary btn-md text-white shadow-sm"
                                        style="width: 100px; font-size: 0.875rem;">Baru</button>
                                @elseif($data->status == 'Penugasan' && $data->resource_detail?->quantity == $data->resource_detail?->fulfilled)
                                    <button class="btn btn-success btn-md text-white shadow-sm"
                                        style="background-color: #155724; width: 100px; font-size: 0.875rem;">Selesai</button>
                                @elseif($data->status == 'Penugasan')
                                    <button class="btn btn-warning btn-md text-white shadow-sm"
                                        style="width: 100px; font-size: 0.875rem;">Penugasan</button>
                                @elseif($data->status == 'Diproses')
                                    <button class="btn btn-warning btn-md text-white shadow-sm"
                                        style="width: 100px; font-size: 0.875rem;">Diproses</button>
                                @else
                                    <button class="btn btn-secondary btn-md text-white shadow-sm"
                                        style="width: 100px; font-size: 0.875rem;">Unknown</button>
                                @endif
                            </th>

                            <td class="actions-column align-middle text-center bg-white">
                                <div class="dropdown" style="position: relative;">
                                    <i class="bi bi-three-dots hover icon-behind" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                        style="position: absolute; left: -100%; min-width: 200px;">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('detailRequester', [$data->id]) }}">
                                                <i class="bi bi-eye me-2"></i>Lihat data detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('updateRequester', [$data->id]) }}">
                                                <i class="bi bi-pencil me-2"></i>Edit data
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-12 mt-3">
            {{ $resource->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

    <!-- Modal Tambah Permintaan -->
    <div class="modal fade" id="addRequestModal" tabindex="-1" aria-labelledby="addRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 900px;">
            <div class="modal-content" style="height: 600px; display: flex; flex-direction: column;">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRequestModalLabel">Tambah Permintaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="overflow-y: auto; flex: 1;">

                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs" id="requestTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="details-tab" data-bs-toggle="tab"
                                data-bs-target="#details" type="button" role="tab" aria-controls="details"
                                aria-selected="true">Umum</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="positions-tab" data-bs-toggle="tab" data-bs-target="#positions"
                                type="button" role="tab" aria-controls="positions" aria-selected="true">Kebutuhan
                                Posisi</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="interview-tab" data-bs-toggle="tab" data-bs-target="#interview"
                                type="button" role="tab" aria-controls="interview"
                                aria-selected="true">Wawancara</button>
                        </li>


                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="additional-tab" data-bs-toggle="tab"
                                data-bs-target="#additional" type="button" role="tab" aria-controls="additional"
                                aria-selected="false">Verifikasi
                                Informasi</button>
                        </li>
                    </ul>

                    <form id="addRequestForm" action="{{ route('addResource') }}" method="POST">
                        @csrf

                        <!-- Tab Content -->
                        <div class="tab-content" id="requestTabsContent">
                            <!-- Tab 1: Detail -->
                            <div class="tab-pane fade show active" id="details" role="tabpanel"
                                aria-labelledby="details-tab">
                                <div class="mb-3 mt-3">
                                    <label for="name" class="form-label">Nama Permintaan</label>
                                    <textarea class="form-control" id="name" name="name" rows="3" style="padding-top: 10px;" required
                                        placeholder="Masukan nama permintaan" autocomplete></textarea>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="client" class="form-label">Klien</label>
                                        <input type="text" class="form-control" id="client" name="client"
                                            required placeholder="Masukan klien">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="project" class="form-label">Proyek</label>
                                        <input type="text" class="form-control" id="project" name="project"
                                            required placeholder="Masukan proyek">
                                    </div>
                                </div>
                                <div class="row mb-3 mt-3">
                                    <div class="col-md-4">
                                        <label for="level_priority" class="form-label">Level Prioritas</label>
                                        <div class="custom-select-wrapper">
                                            <select class="form-control" id="level_priority" name="level_priority"
                                                required>
                                                <option value="">Pilih Prioritas</option>
                                                <option value="Biasa">Biasa</option>
                                                <option value="Urgent">Urgent</option>
                                                <option value="Sangat Urgent">Sangat Urgent</option>
                                            </select>
                                            <i class="fas fa-chevron-down select-icon"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="target_date" class="form-label">Tanggal Target</label>
                                        <input type="date" class="form-control" id="target_date" name="target_date"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="requirment" class="form-label">Jenis Kebutuhan</label>
                                        <div class="custom-select-wrapper">
                                            <select class="form-control" id="requirment" name="requirment" required>
                                                <option value="">Pilih Kebutuhan</option>
                                                <option value="Recruitment">Internal</option>
                                                <option value="Client">Client</option>
                                            </select>
                                            <i class="fas fa-chevron-down select-icon"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Tab 2: Position -->
                            <div class="tab-pane fade show" id="positions" role="tabpanel"
                                aria-labelledby="positions-tab">

                                <div class="row mb-3 mt-3">
                                    <div class="col-md-4">
                                        <label for="position" class="form-label">Posisi yang Dibutuhkan</label>
                                        <div class="custom-select-wrapper">
                                            <select class="form-control" id="position" name="position" required>
                                                <option value="" disabled selected>Pilih Posisi</option>
                                                <option value="Software Developer">Software Developer</option>
                                                <option value="Web Developer">Web Developer</option>
                                                <option value="Mobile Developer">Mobile Developer</option>
                                                <option value="Data Scientist">Data Scientist</option>
                                                <option value="UI/UX Designer">UI/UX Designer</option>
                                                <option value="Network Engineer">Network Engineer</option>
                                                <option value="System Administrator">System Administrator</option>
                                                <option value="DevOps Engineer">DevOps Engineer</option>
                                                <option value="Product Manager">Product Manager</option>
                                                <option value="Project Manager">Project Manager</option>
                                                <option value="QA Engineer">QA Engineer</option>
                                                <option value="Cybersecurity Analyst">Cybersecurity Analyst</option>
                                            </select>
                                            <i class="fas fa-chevron-down select-icon"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="skill" class="form-label">Skill yang dibutuhkan</label>
                                        <input type="text" class="form-control" id="skill" name="skill"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="quantity" class="form-label">Jumlah</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity"
                                            required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="education" class="form-label">Jenjang Pendidikan</label>
                                        <div class="custom-select-wrapper">
                                            <select class="form-control" id="education" name="education" required>
                                                <option value="" disabled selected>Pilih Jenjang Pendidikan</option>
                                                <option value="D3">Diploma 3 (D3)</option>
                                                <option value="S1">Sarjana (S1)</option>
                                                <option value="S2">Magister (S2)</option>
                                                <option value="S3">Doktor (S3)</option>
                                            </select>
                                            <i class="fas fa-chevron-down select-icon"></i>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="qualification" class="form-label">Kualifikasi</label>
                                        <input type="text" class="form-control" id="qualification"
                                            name="qualification" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="experience" class="form-label">Pengalaman(tahun)</label>
                                        <input type="number" class="form-control" id="experience" name="experience"
                                            required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="contract" class="form-label">Durasi Kontrak (Bulan)</label>
                                    <input type="number" class="form-control" id="contract" name="contract" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Keterangan</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                </div>

                            </div>

                            <!-- Tab 3: Wawancara -->
                            <div class="tab-pane fade show" id="interview" role="tabpanel"
                                aria-labelledby="interview-tab">
                                <div class="p-3">
                                    <h3>Wawancara</h3>
                                    <p>Tahapan yang akan dilalui kandidat</p>
                                </div>

                                <!-- Tombol Tambah dan Hapus -->
                                <div class="d-flex justify-content-end mb-3">
                                    <button type="button" id="addInterviewStageButton"
                                        class="btn btn-primary mt-2">Tambah Tahap Wawancara</button>
                                </div>

                                <!-- Container untuk tahapan wawancara -->
                                <div id="interviewStagesContainer">

                                </div>

                            </div>

                            <!-- Tab 4: Verifikasi Informasi -->
                            <div class="tab-pane fade" id="additional" role="tabpanel" aria-labelledby="additional-tab">
                                <div class="mb-3 mt-3">
                                    <label for="verifikasi_name" class="form-label">Nama Permintaan</label>
                                    <input type="text" class="form-control" id="verifikasi_name" disabled>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="verifikasi_client" class="form-label">Klien</label>
                                        <input type="text" class="form-control" id="verifikasi_client" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="verifikasi_project" class="form-label">Proyek</label>
                                        <input type="text" class="form-control" id="verifikasi_project" disabled>
                                    </div>
                                </div>
                                <div class="row mb-3 mt-3">
                                    <div class="col-md-4">
                                        <label for="verifikasi_priority" class="form-label">Level Prioritas</label>
                                        <input type="text" class="form-control" id="verifikasi_priority" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="verifikasi_target_date" class="form-label">Tanggal Target</label>
                                        <input type="text" class="form-control" id="verifikasi_target_date" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="verifikasi_requirment" class="form-label">Jenis Kebutuhan</label>
                                        <input type="text" class="form-control" id="verifikasi_requirment" disabled>
                                    </div>
                                </div>

                                <h3>Kebutuhan Posisi</h3>
                                <div class="row mb-3 mt-3">
                                    <div class="col-md-4">
                                        <label for="verifikasi_position" class="form-label">Posisi yang
                                            dibutuhkan</label>
                                        <input type="text" class="form-control" id="verifikasi_position" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="verifikasi_skill" class="form-label">Skill yang dibutuhkan</label>
                                        <input type="text" class="form-control" id="verifikasi_skill" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="verifikasi_quantity" class="form-label">Jumlah</label>
                                        <input type="number" class="form-control" id="verifikasi_quantity" disabled>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="verifikasi_education" class="form-label">Jenjang
                                            Pendidikan</label>
                                        <input type="text" class="form-control" id="verifikasi_education" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="verifikasi_qualification" class="form-label">Kualifikasi</label>
                                        <input type="text" class="form-control" id="verifikasi_qualification"
                                            disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="verifikasi_experience" class="form-label">Pengalaman(tahun)</label>
                                        <input type="number" class="form-control" id="verifikasi_experience" disabled>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="verifikasi_contract" class="form-label">Durasi Kontrak (Bulan)</label>
                                    <input type="text" class="form-control" id="verifikasi_contract" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="verifikasi_description" class="form-label">Keterangan</label>
                                    <textarea class="form-control" id="verifikasi_description" rows="3" disabled></textarea>
                                </div>

                                <h3>Wawancara</h3>
                                <div id="verificationContainer" class="mt-3"></div>

                            </div>
                        </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="backButton"
                        style="display: none;">Kembali</button>
                    <button type="button" class="btn btn-primary" id="nextButton">Lanjut</button>
                    <button type="submit" class="btn btn-success" form="addRequestForm" id="saveButton"
                        style="display: none;">Simpan</button>
                </div>

                </form>

            </div>
        </div>
    </div>



@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nextButton = document.getElementById('nextButton');
            const backButton = document.getElementById('backButton');
            const saveButton = document.getElementById('saveButton');
            const tabs = document.querySelectorAll('#requestTabs .nav-link');
            const detailsForm = document.getElementById('addRequestForm');
            const verificationForm = document.getElementById('additionalForm');

            let currentTab = 0;

            function updateFooter() {
                if (currentTab === 0) {
                    backButton.style.display = 'none';
                    nextButton.style.display = 'inline-block';
                    saveButton.style.display = 'none';
                } else if (currentTab === tabs.length - 1) {
                    backButton.style.display = 'inline-block';
                    nextButton.style.display = 'none';
                    saveButton.style.display = 'inline-block';
                    document.getElementById('verifikasi_name').value = document.getElementById('name').value;
                    document.getElementById('verifikasi_client').value = document.getElementById('client').value;
                    document.getElementById('verifikasi_project').value = document.getElementById('project').value;
                    document.getElementById('verifikasi_priority').value = document.getElementById('level_priority')
                        .value;
                    document.getElementById('verifikasi_target_date').value = document.getElementById('target_date')
                        .value;
                    document.getElementById('verifikasi_requirment').value = document.getElementById('requirment')
                        .value;

                    // kebutuhan posisi verifikasi
                    document.getElementById('verifikasi_position').value = document.getElementById('position')
                        .value;
                    document.getElementById('verifikasi_skill').value = document.getElementById('skill').value;
                    document.getElementById('verifikasi_quantity').value = document.getElementById('quantity')
                        .value;

                    document.getElementById('verifikasi_education').value = document.getElementById('education')
                        .value;

                    document.getElementById('verifikasi_qualification').value = document.getElementById(
                            'qualification')
                        .value;

                    document.getElementById('verifikasi_experience').value = document.getElementById('experience')
                        .value;

                    document.getElementById('verifikasi_contract').value = document.getElementById('contract')
                        .value;

                    document.getElementById('verifikasi_description').value = document.getElementById('description')
                        .value;


                    //verifikasi wawancara 
                    const stages = document.getElementsByClassName('interview-stage');
                    const verificationContainer = document.getElementById('verificationContainer');
                    const data = [];

                    verificationContainer.innerHTML = ''; // Reset konten

                    Array.from(stages).forEach((stage, index) => {
                        const interviewStage = stage.querySelector('select[name="interview_stage[]"]')
                            .value;
                        const clientCheckbox = stage.querySelector('select[name="isClient[]"]').value;
                        const valueClient = clientCheckbox == "1" ? "Ya" : "Tidak";
                        const description = stage.querySelector('textarea[name="isDescription[]"]').value;

                        verificationContainer.insertAdjacentHTML('beforeend', `
                        <div class="d-flex align-items-center mb-3 interview-stage">
                                    <!-- Tahapan Wawancara -->
                                    <div class="flex-grow-1 me-2">
                                        <div class="text-start mb-2 border-bottom">
                                            <label class="form-label">Tahap Wawancara</label>
                                        </div>
                                        <select class="form-select" name="interview_stage[]" style="width: 200px;" disabled>
                                            <option value="${interviewStage}">${interviewStage}</option>
                                        </select>
                                    </div>

                                    <!-- Klien -->
                                    <div class="flex-grow-1 me-2">
                                        <div class="text-start mb-2 border-bottom">
                                            <label class="form-label">Klien</label>
                                        </div>
                                        <div class="form-check d-flex align-items-center  justify-content-start p-0 m-0">
                                            <select class="form-select" name="isClient[]" style="width: 150px;" disabled>
                                                <option value="${clientCheckbox}">${valueClient}</option>
                                            </select>
                                            <label class="form-check-label ms-2">Terlibat Client?</label>
                                        </div>
                                    </div>

                                    <!-- Keterangan -->
                                    <div class="flex-grow-1 me-2">
                                        <div class="text-start mb-2 border-bottom">
                                            <label class="form-label">Keterangan</label>
                                        </div>
                                        <textarea class="form-control" name="isDescription[]" rows="1" placeholder="Masukkan keterangan" disabled>${description}</textarea>
                                    </div>
                                </div>                            
                        `);

                    });

                } else {
                    backButton.style.display = 'inline-block';
                    nextButton.style.display = 'inline-block';
                    saveButton.style.display = 'none';
                }
            }

            // Add event listener to each tab to change footer when clicked
            tabs.forEach((tab, index) => {
                tab.addEventListener('click', function() {
                    currentTab = index;
                    updateFooter();
                });
            });

            nextButton.addEventListener('click', function() {
                if (currentTab < tabs.length - 1) {
                    currentTab++;
                    // Activate the next tab
                    tabs[currentTab].click();
                    updateFooter();
                }
            });

            backButton.addEventListener('click', function() {
                if (currentTab > 0) {
                    currentTab--;
                    // Activate the previous tab
                    tabs[currentTab].click();
                    updateFooter();
                }
            });

            updateFooter();


        });
    </script>

    <script>
        document.getElementById('addInterviewStageButton').addEventListener('click', function() {
            const container = document.getElementById('interviewStagesContainer');

            const newStage = `
            <div class="d-flex align-items-center mb-3 interview-stage">
                <div class="flex-grow-1">
                    <div class="text-start mb-2 border-bottom">
                        <label class="form-label">Tahap Wawancara</label>
                    </div>
                    <select class="form-select" name="interview_stage[]" style="width: 200px;">
                        <option value="Wawancara Hr">Wawancara Hr</option>
                        <option value="Wawancara User">Wawancara User</option>
                        <option value="Wawancara Technical">Wawancara Technical</option>
                    </select>
                </div>

               <div class="flex-grow-1 me-2">
                    <div class="text-start mb-2 border-bottom">
                        <label class="form-label">Klien</label>
                    </div>
                    <div class="form-check d-flex align-items-center  justify-content-start p-0 m-0">
                        <select class="form-select" name="isClient[]" style="width: 150px;">
                            <option value="1">Ya</option>
                            <option value="0" selected>Tidak</option>
                        </select>
                        <label class="form-check-label ms-2">Terlibat Client?</label>
                    </div>
                </div>

                <div class="flex-grow-1 me-2">
                   <div class="text-start mb-2 border-bottom">
                        <label class="form-label">Keterangan</label>
                    </div>
                    <textarea class="form-control" name="isDescription[]" rows="1"
                        placeholder="Masukkan keterangan"></textarea>
                </div>
                <div class="flex-grow-1 me-2">
                    <div class="text-center align-middle mb-2 border-bottom">
                        <label class="form-label">Aksi</label>
                    </div>
                    <div class="text-center align-middle">
                        <button type="button"
                        class="btn btn-danger removeStageButton">
                            <i class="fas fa-trash-alt removeStageButton"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
            container.insertAdjacentHTML('beforeend', newStage);
        });

        // Hapus Tahapan Wawancara
        document.getElementById('interviewStagesContainer').addEventListener('click', function(e) {
            if (e.target.classList.contains('removeStageButton')) {
                e.target.closest('.interview-stage').remove();
            }
        });
    </script>


@endsection
