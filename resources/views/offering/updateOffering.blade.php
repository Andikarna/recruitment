@extends('layouts.dashboardLayouts')

@section('ADIDATA', 'Offering')

@section('username', Auth::user()->name)
@section('userid', Auth::user()->id)

@section('links')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
@endsection

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

        #tasklist {
            padding: 10px;
            transform: translateX(200px) min-height: 38px;
        }

        .table input[type="checkbox"] {
            width: auto;
        }
    </style>
@endsection

@section('content')

    <div class="modal-content" style="display: flex; flex-direction: column; p-0 m-0">
        <div class="modal-header d-flex justify-content-start align-items-center gap-2">
            <div>
                <a href="/requester" class="btn btn-link p-0" aria-label="Back">
                    <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem;"></i>
                </a>
                <h5 class="modal-title" id="addRequestModalLabel">Update Offering</h5>
            </div>
        </div>
        <div class="modal-body" style="overflow-y: auto; flex: 1;">

            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs" id="requestTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                        type="button" role="tab" aria-controls="details" aria-selected="true">Umum</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="positions-tab" data-bs-toggle="tab" data-bs-target="#positions"
                        type="button" role="tab" aria-controls="positions" aria-selected="true">Kebutuhan
                        Posisi</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="salary-tab" data-bs-toggle="tab" data-bs-target="#salary" type="button"
                        role="tab" aria-controls="salary" aria-selected="true">Gaji dan Fasilitas</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="interview-tab" data-bs-toggle="tab" data-bs-target="#interview"
                        type="button" role="tab" aria-controls="interview" aria-selected="true">Wawancara</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="additional-tab" data-bs-toggle="tab" data-bs-target="#additional"
                        type="button" role="tab" aria-controls="additional" aria-selected="false">Verifikasi
                        Informasi</button>
                </li>
            </ul>

            <form id="addRequestForm" action="{{ route('saveRequester', [$resourceDetail->id]) }}" method="POST">
                @csrf

                <!-- Tab Content -->
                <div class="tab-content" id="requestTabsContent">
                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                        <div class="mb-3 mt-3">
                            <label for="name" class="form-label">Nama Permintaan</label>
                            <textarea class="form-control" id="name" name="name">{{ $resourceDetail->name }}</textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="client" class="form-label">Klien</label>
                                <input type="text" class="form-control" id="client" name="client"
                                    value="{{ $resourceDetail->client }}">
                            </div>
                            <div class="col-md-6">
                                <label for="project" class="form-label">Proyek</label>
                                <input type="text" class="form-control" id="project" name="project"
                                    value="{{ $resourceDetail->project }}">
                            </div>
                        </div>

                        <div class="row mb-3 mt-3">
                            <div class="col-md-4">
                                <label for="level_priority" class="form-label">Level Prioritas</label>
                                <div class="custom-select-wrapper">
                                    <select class="form-control" id="level_priority" name="level_priority" required>
                                        <option value="Biasa"
                                            {{ $resourceDetail->level_priority == 'Biasa' ? 'selected' : '' }}>Biasa
                                        </option>
                                        <option value="Urgent"
                                            {{ $resourceDetail->level_priority == 'Urgent' ? 'selected' : '' }}>Urgent
                                        </option>
                                        <option value="Sangat Urgent"
                                            {{ $resourceDetail->level_priority == 'Sangat Urgent' ? 'selected' : '' }}>
                                            Sangat Urgent</option>
                                    </select>
                                    <i class="fas fa-chevron-down select-icon"></i>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="target_date" class="form-label">Tanggal Target</label>
                                <input type="date" class="form-control" id="target_date" name="target_date"
                                    value="{{ $resourceDetail->target_date ? \Carbon\Carbon::parse($resourceDetail->target_date)->format('Y-m-d') : '' }}">
                            </div>

                            <div class="col-md-4">
                                <label for="requirment" class="form-label">Jenis Kebutuhan</label>
                                <div class="custom-select-wrapper">
                                    <select class="form-control" id="requirment" name="requirment" required>
                                        <option value="Recruitment"
                                            {{ $resourceDetail->requirment == 'Recruitment' ? 'selected' : '' }}>Recruitment
                                        </option>
                                        <option value="Client"
                                            {{ $resourceDetail->requirment == 'Client' ? 'selected' : '' }}>Client</option>
                                    </select>
                                    <i class="fas fa-chevron-down select-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="document_file" class="form-label">Dokumen Pendukung</label>
                                <input type="file" class="form-control" id="document_file" name="document_file"
                                    accept=".pdf,.doc,.docx,.xlsx">
                            </div>

                            <div class="col-md-4">
                                <label for="requester" class="form-label">Peminta</label>
                                <input type="text" class="form-control" id="requester" name="requester" disabled
                                    value="{{ $resourceDetail->created_by }}">
                            </div>

                            <div class="col-md-4">
                                <label for="recruiter_assign" class="form-label">Recruiter</label>
                                <select class="tags form-control" id="tasklist" name="tasklist[]" multiple>
                                    @foreach ($user as $key => $data)
                                        <option value="{{ $data->id }}"
                                            @foreach ($tasklist as $task)
                                        @if ($task->user_id == $data->id)  
                                            selected
                                        @endif @endforeach>
                                            {{ $data->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                    </div>

                    <!-- Tab 2: Position -->
                    <div class="tab-pane fade show" id="positions" role="tabpanel" aria-labelledby="positions-tab">

                        <div class="row mb-3 mt-3">
                            <div class="col-md-4">
                                <label for="position" class="form-label">Posisi yang Dibutuhkan</label>
                                <div class="custom-select-wrapper">
                                    <select class="form-control" id="position" name="position">
                                        <option value="Software Developer"
                                            {{ $positionDetail->position == 'Software Developer' ? 'selected' : '' }}>
                                            Software Developer</option>
                                        <option value="Web Developer"
                                            {{ $positionDetail->position == 'Web Developer' ? 'selected' : '' }}>Web
                                            Developer</option>
                                        <option value="Mobile Developer"
                                            {{ $positionDetail->position == 'Mobile Developer' ? 'selected' : '' }}>Mobile
                                            Developer</option>
                                        <option value="Data Scientist"
                                            {{ $positionDetail->position == 'Data Scientist' ? 'selected' : '' }}>Data
                                            Scientist</option>
                                        <option value="UI/UX Designer"
                                            {{ $positionDetail->position == 'UI/UX Designer' ? 'selected' : '' }}>UI/UX
                                            Designer</option>
                                        <option value="Network Engineer"
                                            {{ $positionDetail->position == 'Network Engginer' ? 'selected' : '' }}>Network
                                            Engineer</option>
                                        <option value="System Administrator"
                                            {{ $positionDetail->position == 'System Administrator' ? 'selected' : '' }}>
                                            System Administrator</option>
                                        <option value="DevOps Engineer"
                                            {{ $positionDetail->position == 'DevOps Engineer' ? 'selected' : '' }}>DevOps
                                            Engineer</option>
                                        <option value="Product Manager"
                                            {{ $positionDetail->position == 'Product Manager' ? 'selected' : '' }}>Product
                                            Manager</option>
                                        <option value="Project Manager"
                                            {{ $positionDetail->position == 'Project Manager' ? 'selected' : '' }}>Project
                                            Manager</option>
                                        <option value="QA Engineer"
                                            {{ $positionDetail->position == 'QA Engineer' ? 'selected' : '' }}>QA Engineer
                                        </option>
                                        <option value="Cybersecurity Analyst"
                                            {{ $positionDetail->position == 'Cybersecurity Analyst' ? 'selected' : '' }}>
                                            Cybersecurity Analyst</option>
                                    </select>
                                    <i class="fas fa-chevron-down select-icon"></i>
                                </div>
                            </div>



                            <div class="col-md-4">
                                <label for="skill" class="form-label">Skill yang dibutuhkan</label>
                                <input type="text" class="form-control" id="skill" name="skill"
                                    value="{{ $positionDetail->skill }}">
                            </div>
                            <div class="col-md-4">
                                <label for="quantity" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="quantity" name="quantity"
                                    value="{{ $positionDetail->quantity }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="education" class="form-label">Jenjang Pendidikan</label>
                                <div class="custom-select-wrapper">
                                    <select class="form-control" id="education" name="education">
                                        <option value="SD" {{ $positionDetail->education == 'SD' ? 'selected' : '' }}>
                                            Sekolah Dasar (SD)</option>
                                        <option value="SMP"
                                            {{ $positionDetail->education == 'SMP' ? 'selected' : '' }}>Sekolah Menengah
                                            Pertama (SMP)</option>
                                        <option value="SMA"
                                            {{ $positionDetail->education == 'SMA' ? 'selected' : '' }}>Sekolah Menengah
                                            Atas (SMA)</option>
                                        <option value="D3" {{ $positionDetail->education == 'D3' ? 'selected' : '' }}>
                                            Diploma 3 (D3)</option>
                                        <option value="S1" {{ $positionDetail->education == 'S1' ? 'selected' : '' }}>
                                            Sarjana (S1)</option>
                                        <option value="S2" {{ $positionDetail->education == 'S2' ? 'selected' : '' }}>
                                            Magister (S2)</option>
                                        <option value="S3" {{ $positionDetail->education == 'S3' ? 'selected' : '' }}>
                                            Doktor (S3)</option>
                                    </select>
                                    <i class="fas fa-chevron-down select-icon"></i>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="qualification" class="form-label">Kualifikasi</label>
                                <input type="text" class="form-control" id="qualification" name="qualification"
                                    value="{{ $positionDetail->qualification }}">
                            </div>
                            <div class="col-md-4">
                                <label for="experience" class="form-label">Pengalaman(tahun)</label>
                                <input type="number" class="form-control" id="experience" name="experience"
                                    value="{{ $positionDetail->experience }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="contract" class="form-label">Durasi Kontrak</label>
                            <input type="number" class="form-control" id="contract" name="contract"
                                value={{ (int) $positionDetail->contract }}>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="description" name="description">{{ $positionDetail->description }}</textarea>
                        </div>

                    </div>

                    <!-- Tab 3: Wawancara -->
                    <div class="tab-pane fade show" id="interview" role="tabpanel" aria-labelledby="interview-tab">

                        <div class="p-3">
                            <h3>Wawancara</h3>
                            <p>Tahapan yang akan dilalui kandidat</p>
                        </div>

                        <div class="p-3">
                            <!-- Table Header -->
                            <!-- Tombol Tambah dan Hapus -->
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" id="addInterviewStageButton" class="btn btn-primary mt-2">Tambah
                                    Tahap Wawancara</button>
                            </div>

                            <div id="interviewStagesContainer">
                                @foreach ($interviewDetail as $data)
                                    <input class="resource-id" name="interviewProgress_id[]" value="{{ $data->id }}"
                                        hidden>

                                    <div class="d-flex align-items-center mb-3 interview-stage">
                                        <div class="flex-grow-1">
                                            <div class="text-start mb-2 border-bottom">
                                                <label class="form-label">Tahap Wawancara</label>
                                            </div>
                                            <select class="form-select" name="interview_stage[]" style="width: 200px;">
                                                <option value="Wawancara Hr"
                                                    {{ $data->name_progress == 'Wawancara Hr' ? 'selected' : '' }}>
                                                    Wawancara
                                                    Hr</option>
                                                <option value="Wawancara User"
                                                    {{ $data->name_progress == 'Wawancara User' ? 'selected' : '' }}>
                                                    Wawancara
                                                    User</option>
                                                <option value="Wawancara Technical"
                                                    {{ $data->name_progress == 'Wawancara Technical' ? 'selected' : '' }}>
                                                    Wawancara
                                                    Technical</option>
                                            </select>
                                        </div>

                                        <div class="flex-grow-1 me-2">
                                            <div class="text-start mb-2 border-bottom">
                                                <label class="form-label">Klien</label>
                                            </div>
                                            <div
                                                class="form-check d-flex align-items-center  justify-content-start p-0 m-0">
                                                <select class="form-select" name="isClient[]" style="width: 150px;">
                                                    <option value="1" {{ $data->isClient == 1 ? 'selected' : '' }}>Ya
                                                    </option>
                                                    <option value="0" {{ $data->isClient == 0 ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                                <label class="form-check-label ms-2">Terlibat Client?</label>
                                            </div>
                                        </div>

                                        <div class="flex-grow-1 me-2">
                                            <div class="text-start mb-2 border-bottom">
                                                <label class="form-label">Keterangan</label>
                                            </div>
                                            <input class="form-control" name="isDescription[]" rows="1"
                                                placeholder="Masukkan keterangan" value="{{ $data->description }}">
                                            </input>
                                        </div>
                                        <div class="flex-grow-1 me-2">
                                            <div class="text-center align-middle mb-2 border-bottom">
                                                <label class="form-label">Aksi</label>
                                            </div>
                                            <div class="text-center align-middle ">
                                                <button type="button" class="btn btn-danger removeStageButton">
                                                    <i class="fas fa-trash-alt removeStageButton"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                        </div>

                    </div>

                    <!-- Tab 4: salary -->
                    <div class="tab-pane fade show" id="salary" role="tabpanel" aria-labelledby="salary-tab">

                        <div class="p-3">
                            <h3>Gaji & Fasilitas</h3>
                            <p>Informasi Gaji & Fasilitas yang akan didapatkan kandidat jika direkrut</p>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ '' }}</th>
                                    <th class="text-center align-middle">Nominal</th>
                                    <th class="text-center align-middle">Gross|Nett</th>
                                    <th class="text-center align-middle">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle">Gaji Pokok</td>
                                    <td class="d-flex align-items-center justify-content-center gap-2">
                                        <!-- Input Minimal Nominal -->
                                        <div class="nominal-container">
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" id="minimalNominal" class="form-control"
                                                    name="min_salary" placeholder="Minimal Nominal"
                                                    value="{{ $salary->min_salary ?? '' }}">
                                            </div>
                                        </div>

                                        <!-- Tanda "-" -->
                                        <div>
                                            <span class="d-flex align-items-center justify-content-center">-</span>
                                        </div>

                                        <!-- Input Maximal Nominal -->
                                        <div class="nominal-container">
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" id="maximalNominal" class="form-control"
                                                    name="max_salary" placeholder="Maximal Nominal"
                                                    value="{{ $salary->max_salary ?? '' }}">
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center align-middle">{{ '' }}</td>
                                    <td class="text-center align-middle">
                                        <input type="text" name="ket_salary" id="ket_salary" class="form-control"
                                            placeholder="Masukan Catatan" value="{{ $salary->ket_salary ?? '' }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">PPH 21</td>
                                    <td>{{ '' }}</td>
                                    <td class="text-center align-middle">
                                        <div class="form-check form-switch d-flex justify-content-center"
                                            style="gap: 10px;">
                                            @if (isset($salary) && $salary->pph21 !== null)
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    {{ $salary->pph21 == 1 ? 'checked' : '' }}
                                                    style="width: 50px; height: 25px;" name="pph21" id="pph21">
                                            @else
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="pph21" id="pph21" style="width: 50px; height: 25px;">
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <input type="text" class="form-control" name="ket_pph21" id="ket_pph21"
                                            placeholder="Masukan Catatan" value="{{ $salary->ket_pph21 ?? '' }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">BPJS Ketenagakerjaan</td>
                                    <td class="text-center align-middle">{{ '' }}</td>
                                    <td class="text-center align-middle">
                                        <div class="form-check form-switch d-flex justify-content-center"
                                            style="gap: 10px;">
                                            @if (isset($salary) && $salary->bpjs_ket !== null)
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="bpjs_ket" id="bpjs_ket" style="width: 50px; height: 25px;"
                                                    {{ $salary->bpjs_ket == 1 ? 'checked' : '' }}>
                                            @else
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="bpjs_ket" id="bpjs_ket" style="width: 50px; height: 25px;">
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <input type="text" class="form-control" name="ket_bpjsket" id="ket_bpjsket"
                                            placeholder="Masukan Catatan" value="{{ $salary->ket_bpjsket ?? '' }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">BPJS Kesehatan</td>
                                    <td>{{ '' }}</td>
                                    <td class="text-center align-middle">
                                        <div class="form-check form-switch d-flex justify-content-center"
                                            style="gap: 10px;">
                                            @if (isset($salary) && $salary->bpjs_kes !== null)
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="bpjs_kes" id="bpjs_kes" style="width: 50px; height: 25px;"
                                                    {{ $salary->bpjs_kes == 1 ? 'checked' : '' }}>
                                            @else
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="bpjs_kes" id="bpjs_kes" style="width: 50px; height: 25px;">
                                            @endif
                                        </div>
                                    </td class="text-center align-middle">
                                    <td class="text-center align-middle">
                                        <input type="text" class="form-control" name="ket_bpjskes" id="ket_bpjskes"
                                            placeholder="Masukan Catatan" value="{{ $salary->ket_bpjskes ?? '' }}">
                                    </td>
                                </tr>
                            </tbody>

                        </table>

                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" id="addFasilitasStageButton" class="btn btn-primary mt-2">Tambah
                                Fasilitas</button>
                        </div>


                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">Fasilitas</th>
                                    <th class="text-center align-middle">Catatan</th>
                                    <th class="text-start align-middle">{{ '' }}</th>
                                </tr>
                            </thead>
                            <tbody id="fasilitasStageContainer">
                                @foreach ($fasilitas as $data)
                                    <tr class="fasilitas-stage">
                                        <input name="fasilitas_id[]" value="{{ $data->id }}" hidden>
                                        <td class="text-center align-middle ">
                                            <select class="form-control" name="fasilitas[]" required>
                                                <option value="Tunjangan Makan"
                                                    {{ $data->fasilitas_name == 'Tunjangan Makan' ? 'selected' : '' }}>
                                                    Tunjangan Makan</option>
                                                <option value="Tunjangan Lembur"
                                                    {{ $data->fasilitas_name == 'Tunjangan Lembur' ? 'selected' : '' }}>
                                                    Tunjangan Lembur</option>
                                                <option value="Tunjangan Cuti"
                                                    {{ $data->fasilitas_name == 'Tunjangan Cuti' ? 'selected' : '' }}>
                                                    Tunjangan Cuti</option>
                                                <option value="Tunjangan Kesehatan"
                                                    {{ $data->fasilitas_name == 'Tunjangan Kesehatan' ? 'selected' : '' }}>
                                                    Tunjangan Kesehatan</option>
                                                <option value="Tunjangan Kacamata"
                                                    {{ $data->fasilitas_name == 'Tunjangan Kacamata' ? 'selected' : '' }}>
                                                    Tunjangan Kaca Mata</option>
                                            </select>
                                        </td>
                                        <td class="text-center align-middle ">
                                            <input type="text" class="form-control" name="ket_fasilitas[]"
                                                placeholder="Masukkan keterangan" value="{{ $data->ket_fasilitas }}" />
                                        </td>
                                        <td class="text-center align-middle ">
                                            <button type="button" class="btn btn-danger removeStageButton">
                                                <i class="fas fa-trash-alt removeStageButton"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>

                    <!-- Tab 5: Verifikasi Informasi -->
                    <div class="tab-pane fade" id="additional" role="tabpanel" aria-labelledby="additional-tab">
                        {{-- umum --}}
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
                                <input type="text" class="form-control" id="verifikasi_qualification" disabled>
                            </div>
                            <div class="col-md-4">
                                <label for="verifikasi_experience" class="form-label">Pengalaman(tahun)</label>
                                <input type="number" class="form-control" id="verifikasi_experience" disabled>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="verifikasi_contract" class="form-label">Durasi Kontrak</label>
                            <input type="text" class="form-control" id="verifikasi_contract" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="verifikasi_description" class="form-label">Keterangan</label>
                            <input class="form-control" id="verifikasi_description" rows="3" disabled></input>
                        </div>

                        {{-- gaji fasilitas --}}
                        <div class="pt-3">
                            <h3>Gaji & Fasilitas</h3>
                            <p>Informasi Gaji & Fasilitas yang akan didapatkan kandidat jika direkrut</p>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ '' }}</th>
                                    <th class="text-center align-middle">Nominal</th>
                                    <th class="text-center align-middle">Gross|Nett</th>
                                    <th class="text-center align-middle">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle">Gaji Pokok</td>
                                    <td class="d-flex align-items-center justify-content-center gap-2">
                                        <!-- Input Minimal Nominal -->
                                        <div class="nominal-container">
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" id="verifikasi_minimalNominal" class="form-control"
                                                    placeholder="Minimal Nominal" disabled>
                                            </div>
                                        </div>

                                        <!-- Tanda "-" -->
                                        <div>
                                            <span class="d-flex align-items-center justify-content-center">-</span>
                                        </div>

                                        <!-- Input Maximal Nominal -->
                                        <div class="nominal-container">
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" id="verifikasi_maximalNominal" class="form-control"
                                                    placeholder="Maximal Nominal" disabled>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center align-middle">{{ '' }}</td>
                                    <td class="text-center align-middle">
                                        <input type="text" id="verifikasi_ket_salary" class="form-control"
                                            placeholder="Masukan Catatan" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">PPH 21</td>
                                    <td>{{ '' }}</td>
                                    <td class="text-center align-middle">
                                        <div class="form-check form-switch d-flex justify-content-center"
                                            style="gap: 10px;">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="verifikasi_pph21" style="width: 50px; height: 25px;" disabled>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <input type="text" class="form-control" id="verifikasi_ket_pph21"
                                            placeholder="Masukan Catatan" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">BPJS Ketenagakerjaan</td>
                                    <td class="text-center align-middle">{{ '' }}</td>
                                    <td class="text-center align-middle">
                                        <div class="form-check form-switch d-flex justify-content-center"
                                            style="gap: 10px;">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="verifikasi_bpjs_ket" style="width: 50px; height: 25px;" disabled>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <input type="text" class="form-control" id="verifikasi_ket_bpjsket"
                                            placeholder="Masukan Catatan" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">BPJS Kesehatan</td>
                                    <td>{{ '' }}</td>
                                    <td class="text-center align-middle">
                                        <div class="form-check form-switch d-flex justify-content-center"
                                            style="gap: 10px;">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="verifikasi_bpjs_kes" style="width: 50px; height: 25px;" disabled>
                                        </div>
                                    </td class="text-center align-middle">
                                    <td class="text-center align-middle">
                                        <input type="text" class="form-control" id="verifikasi_ket_bpjskes"
                                            placeholder="Masukan Catatan" disabled>
                                    </td>
                                </tr>
                            </tbody>

                        </table>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-start align-middle">Fasilitas</th>
                                    <th class="text-center align-middle">Catatan</th>
                                </tr>
                            </thead>
                            <tbody id="fasilitasStageContainerVerification">
                            </tbody>
                        </table>

                        {{-- interviewProgress --}}
                        <h3>Wawancara</h3>
                        <div id="verificationContainer" class="mt-3"></div>

                    </div>
                </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="backButton" style="display: none;">Kembali</button>
            <button type="button" class="btn btn-primary" id="nextButton">Lanjut</button>
            <button type="submit" class="btn btn-success" form="addRequestForm" id="saveButton"
                style="display: none;">Simpan</button>

        </div>

        </form>

    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nextButton = document.getElementById('nextButton');
            const backButton = document.getElementById('backButton');
            const saveButton = document.getElementById('saveButton');
            const tabs = document.querySelectorAll('#requestTabs .nav-link');
            const detailsForm = document.getElementById('addRequestForm');
            const verificationForm = document.getElementById('additionalForm');

            const stages = document.getElementsByClassName('interview-stage');
            const verificationContainer = document.getElementById('verificationContainer');

            const fStages = document.getElementsByClassName('fasilitas-stage');
            const fasilitasContainer = document.getElementById('fasilitasStageContainerVerification');

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


                    //salary
                    document.getElementById('verifikasi_minimalNominal').value = document.getElementById(
                            'minimalNominal')
                        .value;

                    document.getElementById('verifikasi_maximalNominal').value = document.getElementById(
                            'maximalNominal')
                        .value;

                    document.getElementById('verifikasi_ket_salary').value = document.getElementById(
                            'ket_salary')
                        .value;

                    document.getElementById('verifikasi_pph21').checked = document.getElementById(
                            'pph21')
                        .checked;

                    document.getElementById('verifikasi_ket_pph21').value = document.getElementById(
                            'ket_pph21')
                        .value;

                    document.getElementById('verifikasi_bpjs_ket').checked = document.getElementById(
                            'bpjs_ket')
                        .checked;

                    document.getElementById('verifikasi_ket_bpjsket').value = document.getElementById(
                            'ket_bpjsket')
                        .value;

                    document.getElementById('verifikasi_bpjs_kes').checked = document.getElementById(
                            'bpjs_kes')
                        .checked;

                    document.getElementById('verifikasi_ket_bpjskes').value = document.getElementById(
                            'ket_bpjskes')
                        .value;

                    //verifikasi wawancara 
                    verificationContainer.innerHTML = ''; // Reset konten

                    Array.from(stages).forEach((stage, index) => {

                        const interviewStage = stage.querySelector('select[name="interview_stage[]"]')
                            .value;

                        const clientCheckbox = stage.querySelector('select[name="isClient[]"]').value;
                        const valueClient = clientCheckbox == "1" ? "Ya" : "Tidak";
                        const description = stage.querySelector('input[name="isDescription[]"]').value;

                        verificationContainer.insertAdjacentHTML('beforeend', `
                            <div class="d-flex align-items-center mb-3 interview-stage">
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
                                            <input class="form-control" name="isDescription[]" rows="1" placeholder="Masukkan keterangan" disabled value="${description}"/>
                                        </div>
                                    </div>                            
                            `);

                    });

                    if (fStages.length === 2) {
                        fasilitasContainer.innerHTML = '<p>Tidak ada fasilitas yang tersedia.</p>';
                    }
                    fasilitasContainer.innerHTML = '';
                    Array.from(fStages).forEach((fStages, index) => {

                        const fasilitas_name = fStages.querySelector('select[name="fasilitas[]"]').value;
                        const ket_fasilitas = fStages.querySelector('input[name="ket_fasilitas[]"]').value;
                        fasilitasContainer.insertAdjacentHTML('beforeend', `
                            <tr class="fasilitas-stage">
                                <td class="col-4">
                                    <select class="form-control" name="fasilitas[]" disabled>
                                        <option value="Tunjangan Makan" ${fasilitas_name === 'Tunjangan Makan' ? 'selected' : ''}>
                                            Tunjangan Makan</option>
                                        <option value="Tunjangan Lembur" ${fasilitas_name === 'Tunjangan Lembur' ? 'selected' : ''}>
                                            Tunjangan Lembur</option>
                                        <option value="Tunjangan Cuti" ${fasilitas_name === 'Tunjangan Cuti' ? 'selected' : ''}>
                                            Tunjangan Cuti</option>
                                        <option value="Tunjangan Kesehatan" ${fasilitas_name === 'Tunjangan Kesehatan' ? 'selected' : ''}>
                                            Tunjangan Kesehatan</option>
                                        <option value="Tunjangan Kacamata" ${fasilitas_name === 'Tunjangan Kacamata' ? 'selected' : ''}>
                                            Tunjangan Kacamata</option>
                                    </select>
                                </td>
                                <td class="col-8">
                                    <input type="text" class="form-control" name="ket_fasilitas[]"
                                        placeholder="Masukkan keterangan"
                                        value="${ket_fasilitas}" disabled />
                                </td>
                            </tr>
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
                    <input class="resource-id" name="interviewProgress_id[]"
                                          value="0" hidden>
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
                        <input class="form-control" name="isDescription[]" rows="1"
                            placeholder="Masukkan keterangan"></input>
                    </div>
                    <div class="flex-grow-1 me-2">
                        <div class="text-center align-middle mb-2 border-bottom">
                            <label class="form-label">Aksi</label>
                        </div>
                        <div class="text-center align-middle"> 
                            <button type="button"
                            class="btn btn-danger removeStageButton">Hapus</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tasklist = new Choices('#tasklist', {
                removeItemButton: true,
                maxItemCount: 5,
                placeholderValue: 'Pilih Recruiter',
                searchPlaceholderValue: 'Cari Recruiter',
            });
        });
    </script>

    <script>
        document.getElementById('submit').addEventListener('click', function() {
            const tasklist = document.getElementById('tasklist');
            const selectedValues = Array.from(tasklist.selectedOptions).map(option => option.value);

            // Send the selected values to the server via AJAX
            fetch("{{ route('saveRequester', [$resourceDetail->id]) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}", // CSRF Token for Laravel
                    },
                    body: JSON.stringify({
                        tasklist: selectedValues
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Recruiters have been submitted:', data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>

    <script>
        document.getElementById('addFasilitasStageButton').addEventListener('click', function() {
            const container = document.getElementById('fasilitasStageContainer');

            const newStage = `
            <tr class="fasilitas-stage">
                  <input name="fasilitas_id[]" value="0" hidden>
                <td>
                    <select class="form-control" name="fasilitas[]" required>
                        <option value="" disabled selected>Pilih Fasilitas</option>
                        <option value="Tunjangan Makan">Tunjangan Makan</option>
                        <option value="Tunjangan Lembur">Tunjangan Lembur</option>
                        <option value="Tunjangan Cuti">Tunjangan Cuti</option>
                        <option value="Tunjangan Kesehatan">Tunjangan Kesehatan</option>
                        <option value="Tunjangan Kacamata">Tunjangan Kacamata</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control" name="ket_fasilitas[]" placeholder="Masukkan keterangan" />
                </td>
                <td>
                    <button type="button" class="btn btn-danger removeStageButton">
                        <i class="fas fa-trash-alt removeStageButton"></i>
                    </button>
                </td>
            </tr>           
        `;
            container.insertAdjacentHTML('beforeend', newStage);
        });

        // Hapus Tahapan Wawancara
        document.getElementById('fasilitasStageContainer').addEventListener('click', function(e) {
            if (e.target.classList.contains('removeStageButton')) {
                e.target.closest('.fasilitas-stage').remove();
            }
        });
    </script>

    <script>
        // Function to format number as Rupiah
        function formatRupiah(value) {
            if (!value) return '';
            return value.replace(/\D/g, '') // Remove non-numeric characters
                .replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Add periods for thousands
        }

        // Get elements
        const minimalNominal = document.getElementById('minimalNominal');
        const maximalNominal = document.getElementById('maximalNominal');
        let timeout;

        // Event listener for Minimal Nominal
        minimalNominal.addEventListener('input', function() {
            const rawValue = this.value.replace(/\D/g, '');
            const formattedValue = formatRupiah(rawValue);
            this.value = `${formattedValue}`;

            const minimalValue = parseInt(rawValue);
            maximalNominal.value = formatRupiah(minimalValue.toString());
        });

        maximalNominal.addEventListener('input', function() {
            clearTimeout(timeout); // Clear the previous timeout

            timeout = setTimeout(function() { // Set a new timeout for 5 seconds
                const rawMaxValue = maximalNominal.value.replace(/\D/g, ''); // Extract numeric value
                const rawMinValue = minimalNominal.value.replace(/\D/g,
                    ''); // Extract Minimal Nominal value

                if (rawMaxValue && rawMinValue && parseInt(rawMaxValue) <= parseInt(rawMinValue)) {
                    maximalNominal.value = formatRupiah((parseInt(rawMinValue)).toString());
                } else {
                    const formattedValue = formatRupiah(rawMaxValue);
                    maximalNominal.value = formattedValue;
                }
            }, 5000); // 5000 milliseconds = 5 seconds delay
        });
    </script>


@endsection
