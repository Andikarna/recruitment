@extends('layouts.dashboardLayouts')

@section('ADIDATA', 'Interview')

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

        #tasklist {
            padding: 10px;
            transform: translateX(200px) min-height: 38px;
        }

        .table input[type="checkbox"] {
            width: auto;
        }

        .section-line {
            border-bottom: 2px solid #ddd;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .timeline {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .timeline-item {
            display: flex;
            align-items: center;
            padding: 0.6rem;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            background-color: #f8f9fa;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .timeline-item:hover {
            background-color: #e9f7ef;
        }

        .timeline-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .timeline-title {
            font-size: 0.8rem;
            font-weight: bold;
            color: #333;
        }

        .text-muted {
            color: #6c757d;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }

        .bg-secondary {
            background-color: #6c757d !important;
        }

        .text-white {
            color: #fff !important;
        }

        .text-dark {
            color: #343a40 !important;
        }
    </style>
@endsection

@section('title-content',"Wawancara Kandidat")

@section('content')
    <div class="row bg-white p-3" style="border-radius: 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
        <form id="addRequestForm" action="{{ route('saveInterview', [$interview->id]) }}" method="POST">
            @csrf
            <div style="display: flex; flex-direction: column; p-0 m-0">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <a href="/interview" class="btn btn-link p-0" aria-label="Back">
                            <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem;"></i>
                        </a>
                        <h5 class="modal-title" id="addRequestModalLabel">Update Interview</h5>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <ul class="timeline d-flex  gap-3">
                            @foreach ($interviewDetail as $data)
                                <li class="timeline-item d-flex align-items-center gap-2">
                                    <span
                                        class="timeline-icon 
                                        @if ($data->interview_status == 'Diterima') bg-success text-white 
                                        @elseif ($data->interview_status == 'Baru') 
                                            bg-warning text-dark 
                                        @else 
                                            bg-secondary text-white @endif">
                                        <i
                                            class="
                                            @if ($data->interview_status == 'Diterima') bi bi-check-circle-fill 
                                            @elseif ($data->interview_status == 'Baru') 
                                                bi bi-hourglass-split 
                                            @else 
                                                bi bi-circle @endif"></i>
                                    </span>
                                    <div>
                                        <h6 class="timeline-title mb-0">{{ $data->name_progress }}</h6>
                                        <small
                                            class="text-muted">{{ $data->interview_date ? \Carbon\Carbon::parse($data->interview_date)->format('d F y') : 'Tanggal tidak tersedia' }}</small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
                <div class="modal-body" style="overflow-y: auto; flex: 1;">

                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs" id="requestTabs" role="tablist">

                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                                type="button" role="tab" aria-controls="details" aria-selected="true">Kandidat</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="salary-tab" data-bs-toggle="tab" data-bs-target="#salary"
                                type="button" role="tab" aria-controls="salary" aria-selected="true">Gaji & Fasilitas
                                Posisi</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="interview-tab" data-bs-toggle="tab" data-bs-target="#interview"
                                type="button" role="tab" aria-controls="interview"
                                aria-selected="true">Wawancara</button>
                        </li>
                    </ul>



                    <!-- Tab -->
                    <div class="tab-content" id="requestTabsContent">
                        {{-- Tab 1: Informasi Kandidat --}}
                        <div class="tab-pane fade show active p-2" id="details" role="tabpanel"
                            aria-labelledby="details-tab">

                            <h3 class="pt-4">Informasi Kandidat</h3>
                            <p>Informasi mengenai kandidat yang akan direkrut</p>

                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nama</label>
                                    <input class="form-control" type="text" id="name" name="name" disabled
                                        value="{{ $interview->name }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <div class="custom-select-wrapper">
                                        <select class="form-control" id="gender" name="gender" disabled>
                                            <option value="Laki Laki"
                                                {{ $candidate->gender == 'Laki Laki' ? 'selected' : '' }}>
                                                Laki
                                                Laki</option>
                                            <option value="Perempuan"
                                                {{ $candidate->gender == 'Perempuan' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                        <i class="fas fa-chevron-down select-icon"></i>
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label for="project" class="form-label">Pengalaman (Tahun)</label>
                                    <input type="text" class="form-control" id="experience" name="experience"
                                        disabled value="{{ $candidate->experience }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="education" class="form-label">Pendidikan</label>
                                    <div class="input-group">
                                        <select class="form-control" id="education" name="education" disabled>
                                            <option value="SD" {{ $candidate->education == 'SD' ? 'selected' : '' }}>
                                                SD</option>
                                            <option value="SMP" {{ $candidate->education == 'SMP' ? 'selected' : '' }}>
                                                SMP</option>
                                            <option value="SMA" {{ $candidate->education == 'SMA' ? 'selected' : '' }}>
                                                SMA</option>
                                            <option value="D3" {{ $candidate->education == 'D3' ? 'selected' : '' }}>
                                                D3</option>
                                            <option value="S1" {{ $candidate->education == 'S1' ? 'selected' : '' }}>
                                                S1</option>
                                            <option value="S2" {{ $candidate->education == 'S2' ? 'selected' : '' }}>
                                                S2</option>
                                            <option value="S3" {{ $candidate->education == 'S3' ? 'selected' : '' }}>
                                                S3</option>
                                        </select>
                                        <i class="fas fa-chevron-down select-icon"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label for="major" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" id="major" name="major" disabled
                                        value="{{ $candidate->major }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="source" class="form-label">Sumber</label>
                                    <input type="text" class="form-control" id="source" name="source" disabled
                                        value="{{ $candidate->source }}">
                                </div>
                            </div>

                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label for="project" class="form-label">Proyek</label>
                                    <input type="text" class="form-control" id="project" name="project" disabled
                                        value="{{ $resource->project }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="position" class="form-label">Posisi</label>
                                    <input type="text" class="form-control" id="position" name="position" disabled
                                        value="{{ $resourceDetail->position }}">
                                </div>

                            </div>

                            <div class="row mb-3">

                                <div class="col-md-12">
                                    <label for="url" class="form-label">Url</label>
                                    <input type="text" class="form-control" id="url" name="url" disabled
                                        value="{{ $candidate->url }}">
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label d-block">Khusus</label>
                                        <div class="p-2 d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="special_candidate"
                                                    name="special_candidate" value="yes"
                                                    {{ $candidate->isSpecial === 1 ? 'checked' : '' }} disabled required>
                                                <label class="form-check-label" for="special_candidate">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="special_candidate_no"
                                                    name="special_candidate" value="no"
                                                    {{ $candidate->isSpecial === 0 ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="special_candidate_no">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="uniq_code" class="form-label">Kode Unik</label>
                                    <input type="text" class="form-control" id="uniq_code" name="uniq_code" disabled
                                        value="{{ $candidate->uniq_code ?? "-" }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="recruiter" class="form-label">Recruiter</label>
                                    <input type="text" class="form-control" id="recruiter" name="recruiter" disabled
                                        value="{{ $interview->created_by }}">
                                </div>
                            </div>

                        </div>

                        <!-- Tab 2: Salary -->
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
                                                        disabled name="min_salary" placeholder="Minimal Nominal"
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
                                                        name="max_salary" placeholder="Maximal Nominal" disabled
                                                        value="{{ $salary->max_salary ?? '' }}">
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center align-middle">{{ '' }}</td>
                                        <td class="text-center align-middle">
                                            <input type="text" name="ket_salary" id="ket_salary" class="form-control"
                                                disabled placeholder="Masukan Catatan"
                                                value="{{ $salary->ket_salary ?? '' }}">
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
                                                        disabled {{ $salary->pph21 == 1 ? 'checked' : '' }}
                                                        style="width: 50px; height: 25px;" name="pph21" id="pph21">
                                                @else
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        disabled name="pph21" id="pph21"
                                                        style="width: 50px; height: 25px;">
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <input type="text" class="form-control" name="ket_pph21" id="ket_pph21"
                                                disabled placeholder="Masukan Catatan"
                                                value="{{ $salary->ket_pph21 ?? '' }}">
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
                                                        disabled name="bpjs_ket" id="bpjs_ket"
                                                        style="width: 50px; height: 25px;"
                                                        {{ $salary->bpjs_ket == 1 ? 'checked' : '' }}>
                                                @else
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        disabled name="bpjs_ket" id="bpjs_ket"
                                                        style="width: 50px; height: 25px;">
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <input type="text" class="form-control" name="ket_bpjsket"
                                                id="ket_bpjsket" disabled placeholder="Masukan Catatan"
                                                value="{{ $salary->ket_bpjsket ?? '' }}">
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
                                                        disabled {{ $salary->bpjs_kes == 1 ? 'checked' : '' }}>
                                                @else
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        disabled name="bpjs_kes" id="bpjs_kes"
                                                        style="width: 50px; height: 25px;">
                                                @endif
                                            </div>
                                        </td class="text-center align-middle">
                                        <td class="text-center align-middle">
                                            <input type="text" class="form-control" name="ket_bpjskes"
                                                id="ket_bpjskes" disabled placeholder="Masukan Catatan"
                                                value="{{ $salary->ket_bpjskes ?? '' }}">
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
                                            <input name="fasilitas_id[]" value="{{ $data->id }}" hidden>
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
                                                    disabled placeholder="Masukkan keterangan"
                                                    value="{{ $data->ket_fasilitas }}" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                        </div>

                        <!-- Tab 3: Wawancara -->
                        <div class="tab-pane fade show" id="interview" role="tabpanel" aria-labelledby="interview-tab">
                            <div class="p-3">
                                <h3 class="pt-4">Wawancara</h3>
                                <p>Tahapan yang akan dilalui oleh kandidat</p>

                                @foreach ($interviewDetail as $data)
                                    @if ($data->interview_status == 'Baru' || $data->interview_status == 'Diterima')
                                        <input type="text" id="interviewDetailId" name="interviewDetailId"
                                            value="{{ $data->id }}" hidden>
                                        <input type="text" id="interviewId" name="interviewId"
                                            value="{{ $interview->id }}" hidden>

                                        <h5 class="pt-2">{{ $data->name_progress }}</h5>
                                        <div class="section-line"></div>
                                        <div class="row mb-3">

                                            <div class="col-md-4">
                                                <label for="interview_date" class="form-label">Tanggal Wawancara</label>
                                                <input class="form-control" type="date" id="interview_date" 
                                                    {{ $data->interview_status == 'Diterima' ? 'disabled' : '' }}
                                                    {{ $offering != 'Approve' && $interview->interview_progress == 'Wawancara Final' ? 'disabled' : '' }}
                                                    name="interview_date"
                                                    value="{{ $data->interview_date ? \Carbon\Carbon::parse($data->interview_date)->format('Y-m-d') : '' }}">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="interview_time" class="form-label">Jam Wawancara</label>
                                                <input class="form-control" type="time" id="interview_time" disabled
                                                    {{ $data->interview_status == 'Diterima' ? 'disabled' : '' }}
                                                    {{ $offering != 'Approve' && $interview->interview_progress == 'Wawancara Final' ? 'disabled' : '' }}
                                                    name="interview_time" value="{{ $data->interview_time }}">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="interview_user" class="form-label">User</label>
                                                <input class="form-control" type="text" id="interview_user" disabled
                                                    {{ $data->interview_status == 'Diterima' ? 'disabled' : '' }}
                                                    {{ $offering != 'Approve' && $interview->interview_progress == 'Wawancara Final' ? 'disabled' : '' }}
                                                    name="interview_user" placeholder="Masukan nama user"
                                                    value="{{ $data->user }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">

                                            <div class="col-md-4">
                                                <label for="interview_file" class="form-label">Dokumen</label>
                                                <input class="form-control" type="file" id="interview_file" disabled
                                                    {{ $data->interview_status == 'Diterima' ? 'disabled' : '' }}
                                                    {{ $offering != 'Approve' && $interview->interview_progress == 'Wawancara Final' ? 'disabled' : '' }}
                                                    name="interview_file" value="{{ $data->file }}">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="interview_client" class="form-label">Klien</label>
                                                <input class="form-control" type="text" id="interview_client" disabled
                                                    name="interview_client"
                                                    value="{{ $data->name_progress == 1 ? 'Ya' : 'Tidak' }}">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="interview_link" class="form-label">Url Link</label>
                                                <input class="form-control" type="text" id="interview_link" disabled
                                                    {{ $data->interview_status == 'Diterima' ? 'disabled' : '' }}
                                                    {{ $offering != 'Approve' && $interview->interview_progress == 'Wawancara Final' ? 'disabled' : '' }}
                                                    name="interview_link" placeholder="Masukan Link Url"
                                                    value="{{ $data->url }}">
                                            </div>
                                        </div>

                                        @if ($data->interview_date != null)
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="interview_status" class="form-label">Status
                                                        Wawancara</label>
                                                    <div class="custom-select-wrapper">
                                                        <select class="form-control" id="interview_status" disabled
                                                            name="interview_status"
                                                            {{ $data->interview_status == 'Diterima' ? 'disabled' : '' }}>
                                                            <option value="Pilih status wawancara" selected>Pilih status
                                                                wawancara
                                                            </option>
                                                            <option value="Ditolak"
                                                                {{ $data->interview_status == 'Ditolak' ? 'selected' : '' }}>
                                                                Ditolak</option>
                                                            <option value="Reschedule"
                                                                {{ $data->interview_status == 'Reschedule' ? 'selected' : '' }}>
                                                                Reschedule</option>

                                                            @if ($data->id !== $lastInterviewDetail->id)
                                                                <option value="Setuju"
                                                                    {{ $data->interview_status == 'Setuju' ? 'selected' : '' }}>
                                                                    Setuju</option>
                                                            @endif
                                                            <option value="Diterima"
                                                                {{ $data->interview_status == 'Diterima' ? 'selected' : '' }}>
                                                                Diterima</option>
                                                        </select>
                                                        <i class="fas fa-chevron-down select-icon"></i>
                                                    </div>
                                                </div>

                                                <div class="col-md-4" style="display: none;" id="value_wrapper">
                                                    <label for="interview_value" class="form-label">Nilai</label>
                                                    <input class="form-control" type="text" id="interview_value"
                                                        name="interview_value" value="" disabled>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="interview_ket" class="form-label">Keterangan</label>
                                                <input class="form-control" type="text" id="interview_ket"
                                                    name="interview_ket" disabled value="{{ $data->description }}">
                                            </div>
                                        </div>
                                    @endif


                                @endforeach
                            </div>
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

                    var verifikasiInterviewDates = document.querySelectorAll('[id^="verifikasi_interview_date"]');

                    verifikasiInterviewDates.forEach(function(element) {
                        element.value = document.getElementById('interview_date').value;
                    });


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
        document.getElementById("interview_status").addEventListener("change", function() {
            const valueWrapper = document.getElementById("value_wrapper");
            if (this.value === "Diterima") {
                valueWrapper.style.display = "block"; // Tampilkan form nilai
            } else {
                valueWrapper.style.display = "none"; // Sembunyikan form nilai
            }
        });
    </script>

@endsection
