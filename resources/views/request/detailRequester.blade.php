@extends('layouts.dashboardLayouts')

@section('ADIDATA', 'Requester')

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

@section('content')
    <!-- Modal Tambah Permintaan -->

    <div class="modal-content" style="height: 550px; display: flex; flex-direction: column; p-0 m-0">
        <div class="modal-header d-flex justify-content-start align-items-center gap-2">
            <a href="/requester" class="btn btn-link p-0" aria-label="Back">
                <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem;"></i>
            </a>
            <h5 class="modal-title" id="addRequestModalLabel">Detail Permintaan</h5>
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

            </ul>

            <form id="addRequestForm" action="{{ route('addResource') }}" method="POST">
                @csrf
                <div class="tab-content" id="requestTabsContent">
                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                        <div class="mb-3 mt-3">
                            <label for="name" class="form-label">Nama Permintaan</label>
                            <textarea class="form-control" id="name" name="name" disabled>{{ $resourceDetail->name }}</textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="client" class="form-label">Klien</label>
                                <input type="text" class="form-control" id="client" name="client" disabled
                                    value="{{ $resourceDetail->client }}">
                            </div>
                            <div class="col-md-6">
                                <label for="project" class="form-label">Proyek</label>
                                <input type="text" class="form-control" id="project" name="project" disabled
                                    value="{{ $resourceDetail->project }}">
                            </div>
                        </div>
                        <div class="row mb-3 mt-3">
                            <div class="col-md-4">
                                <label for="level_priority" class="form-label">Level Prioritas</label>
                                <div class="custom-select-wrapper">
                                    <select class="form-control" id="level_priority" name="level_priority" disabled>
                                        <option value="">{{ $resourceDetail->level_priority }}</option>
                                    </select>
                                    <i class="fas fa-chevron-down select-icon"></i>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="target_date" class="form-label">Tanggal Target</label>
                                <input type="date" class="form-control" disabled
                                    value="{{ $resourceDetail->target_date ? \Carbon\Carbon::parse($resourceDetail->target_date)->format('Y-m-d') : '' }}">
                            </div>
                            <div class="col-md-4">
                                <label for="requirment" class="form-label">Jenis Kebutuhan</label>
                                <div class="custom-select-wrapper">
                                    <select class="form-control" id="requirment" name="requirment" disabled>
                                        <option value="">{{ $resourceDetail->requirment }}</option>
                                    </select>
                                    <i class="fas fa-chevron-down select-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="document_file" class="form-label">Dokumen Pendukung</label>
                                <input type="file" class="form-control" id="document_file" name="document_file"
                                    accept=".pdf,.doc,.docx,.xlsx" disabled>
                            </div>

                            <div class="col-md-4">
                                <label for="requester" class="form-label">Peminta</label>
                                <input type="text" class="form-control" id="requester" name="requester" disabled
                                    value="{{ $resourceDetail->created_by }}" disabled>
                            </div>

                            <div class="col-md-4">
                                <label for="recruiter_assign" class="form-label">Recruiter</label>
                                <select class="tags form-control" id="tasklist" name="tasklist[]" multiple disabled>
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
                                    <select class="form-control" id="position" name="position" disabled>
                                        <option value="" disabled selected>{{ $positionDetail->position }}</option>
                                    </select>
                                    <i class="fas fa-chevron-down select-icon"></i>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="skill" class="form-label">Skill yang dibutuhkan</label>
                                <input type="text" class="form-control" id="skill" name="skill" disabled
                                    value="{{ $positionDetail->skill }}">
                            </div>
                            <div class="col-md-4">
                                <label for="quantity" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" disabled
                                    value="{{ $positionDetail->quantity }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="education" class="form-label">Jenjang Pendidikan</label>
                                <div class="custom-select-wrapper">
                                    <select class="form-control" id="education" name="education" disabled>
                                        <option value="" disabled selected>{{ $positionDetail->education }}</option>
                                    </select>
                                    <i class="fas fa-chevron-down select-icon"></i>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="qualification" class="form-label">Kualifikasi</label>
                                <input type="text" class="form-control" id="qualification" name="qualification"
                                    disabled value="{{ $positionDetail->qualification }}">
                            </div>
                            <div class="col-md-4">
                                <label for="experience" class="form-label">Pengalaman(tahun)</label>
                                <input type="number" class="form-control" id="experience" name="experience" disabled
                                    value="{{ $positionDetail->experience }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="contract" class="form-label">Durasi Kontrak</label>
                            <input type="number" class="form-control" id="contract" name="contract" disabled
                                value={{ (int) $positionDetail->contract }}>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="description" name="description" disabled>{{ $positionDetail->description }}</textarea>
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
                                                    value="{{ $salary->min_salary ?? '-' }}" disabled>
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
                                                    value="{{ $salary->max_salary ?? '-' }}" disabled>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center align-middle">{{ '' }}</td>
                                    <td class="text-center align-middle">
                                        <input type="text" name="ket_salary" id="ket_salary" class="form-control"
                                            placeholder="Masukan Catatan" value="{{ $salary->ket_salary ?? '' }}"
                                            disabled>
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
                                                    name="pph21" id="pph21" style="width: 50px; height: 25px;"
                                                    {{ $salary->pph21 == 1 ? 'checked' : '' }} disabled>
                                            @else
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="pph21" id="pph21" style="width: 50px; height: 25px;"
                                                    disabled>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <input type="text" class="form-control" name="ket_pph21" id="ket_pph21"
                                            placeholder="Masukan Catatan" value="{{ $salary->ket_pph21 ?? '' }}"
                                            disabled>
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
                                                    {{ $salary->bpjs_ket == 1 ? 'checked' : '' }} disabled>
                                            @else
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="bpjs_ket" id="bpjs_ket" style="width: 50px; height: 25px;" disabled>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <input type="text" class="form-control" name="ket_bpjsket" id="ket_bpjsket"
                                            placeholder="Masukan Catatan" value="{{ $salary->ket_bpjsket ?? '' }}"
                                            disabled>
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
                                                    {{ $salary->bpjs_kes == 1 ? 'checked' : '' }} disabled>
                                            @else
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="bpjs_kes" id="bpjs_kes" style="width: 50px; height: 25px;"
                                                    disabled>
                                            @endif
                                        </div>
                                    </td class="text-center align-middle">
                                    <td class="text-center align-middle">
                                        <input type="text" class="form-control" name="ket_bpjskes" id="ket_bpjskes"
                                            placeholder="Masukan Catatan" value="{{ $salary->ket_bpjskes ?? '' }}"
                                            disabled>
                                    </td>
                                </tr>
                            </tbody>

                        </table>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">Fasilitas</th>
                                    <th class="text-center align-middle">Catatan</th>
                                </tr>
                            </thead>
                            <tbody id="fasilitasStageContainer">
                                @foreach ($fasilitas as $data)
                                    <tr class="fasilitas-stage">
                                        <td class="text-center align-middle ">
                                            <select class="form-control" name="fasilitas[]" disabled>
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
                                                placeholder="Masukkan keterangan" value="{{ $data->ket_fasilitas }}"
                                                disabled />
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    <!-- Tab 3: Wawancara -->
                    <div class="tab-pane fade show" id="interview" role="tabpanel" aria-labelledby="interview-tab">

                        <div class="p-3">
                            <h3>Wawancara</h3>
                            <p>Tahapan yang akan dilalui kandidat</p>
                        </div>

                        <div class="p-3">
                            <!-- Table Header -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tahap Wawancara</th>
                                        <th>Klien</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($interviewDetail as $key => $data)
                                        <tr>
                                            <!-- Tahap Wawancara -->
                                            <td>
                                                <select class="form-select" name="interview_stage[]"
                                                    style="width: 200px;" disabled>
                                                    <option value="Wawancara Hr">
                                                        {{ $data->name_progress }}
                                                    </option>
                                                </select>
                                            </td>

                                            <!-- Klien -->
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center p-0 m-0">
                                                    <select class="form-select" name="isClient[]" style="width: 150px;"
                                                        disabled>
                                                        <option value="1"
                                                            {{ $data->isClient == 1 ? 'selected' : '' }}>Ya
                                                        </option>
                                                        <option value="0"
                                                            {{ $data->isClient == 0 ? 'selected' : '' }}>
                                                            Tidak</option>
                                                    </select>
                                                    <label class="form-check-label ms-2">Terlibat Client?</label>
                                                </div>
                                            </td>

                                            <!-- Keterangan -->
                                            <td>
                                                <input class="form-control" name="isDescription[]" rows="1"
                                                    disabled value="{{ $data->description }}" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="backButton" style="display: none;">Kembali</button>
            <button type="button" class="btn btn-primary" id="nextButton">Lanjut</button>
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
            const tasklist = new Choices('#tasklist', {
                removeItemButton: true,
                maxItemCount: 5,
            });
        });
    </script>


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
@endsection
