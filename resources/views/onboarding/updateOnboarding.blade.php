@extends('layouts.dashboardLayouts')

@section('ADIDATA', 'Onboarding')

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
            font-size: 0.7rem;
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

@section('content')
    <div class="row bg-white p-3" style="border-radius: 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
        <form id="saveOnboarding" action="{{ route('saveOnboarding', $onboarding->id) }}" method="POST">
            @csrf
            @method('put')

            <div style="display: flex; flex-direction: column; p-0 m-0">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <a href="/offering" class="btn btn-link p-0" aria-label="Back">
                            <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem;"></i>
                        </a>
                        <h5 class="modal-title" id="addRequestModalLabel">Update Onboarding</h5>
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
                            <button class="nav-link" id="additional-tab" data-bs-toggle="tab" data-bs-target="#additional"
                                type="button" role="tab" aria-controls="additional" aria-selected="false">Verifikasi
                                Informasi</button>
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
                                        value="{{ $onboarding->name }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <div class="custom-select-wrapper">
                                        <select class="form-control" id="gender" name="gender" disabled>
                                            <option value="Laki Laki"
                                                {{ $onboarding->gender == 'Laki Laki' ? 'selected' : '' }}>
                                                Laki
                                                Laki</option>
                                            <option value="Perempuan"
                                                {{ $onboarding->gender == 'Perempuan' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                        <i class="fas fa-chevron-down select-icon"></i>
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="address" class="form-label">Alamat Rumah</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ $onboarding->address }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="country" class="form-label">Negara</label>
                                    <input type="text" class="form-control" id="country" name="country"
                                        value="{{ $onboarding->country }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="province" class="form-label">Provinsi</label>
                                    <input type="text" class="form-control" id="province" name="province"
                                        value="{{ $onboarding->province }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="city" class="form-label">Kota</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        value="{{ $onboarding->city }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="zipcode" class="form-label">Kode Pos</label>
                                    <input type="text" class="form-control" id="zipcode" name="zipcode"
                                        value="{{ $onboarding->zipcode }}">
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="place_of_birth" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="place_of_birth" name="place_of_birth"
                                        value="{{ $onboarding->place_of_birth }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                        value="{{ $onboarding->date_of_birth ? \Carbon\Carbon::parse($onboarding->date_of_birth)->format('Y-m-d') : '' }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="country" class="form-label">Golongan Darah</label>
                                    <div class="input-group">
                                        <select class="form-control" id="blood_type" name="blood_type">
                                            <option selected>Pilih Golongan Darah</option>
                                            <option value="A" {{ $onboarding->blood_type == 'A' ? 'selected' : '' }}>
                                                A</option>
                                            <option value="B" {{ $onboarding->blood_type == 'B' ? 'selected' : '' }}>
                                                B</option>
                                            <option value="AB"
                                                {{ $onboarding->blood_type == 'AB' ? 'selected' : '' }}>
                                                AB</option>
                                            <option value="O" {{ $onboarding->blood_type == 'O' ? 'selected' : '' }}>
                                                O</option>
                                        </select>
                                        <i class="fas fa-chevron-down select-icon"></i>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="religion" class="form-label">Agama</label>
                                    <input type="text" class="form-control" id="religion" name="religion"
                                        value="{{ $onboarding->religion }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="home_phone" class="form-label">Telepon Rumah</label>
                                    <input type="text" class="form-control" id="home_phone" name="home_phone"
                                        value="{{ $onboarding->home_phone }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="mobile_phone" class="form-label">Nomor Handphone</label>
                                    <input type="text" class="form-control" id="mobile_phone" name="mobile_phone"
                                        value="{{ $onboarding->mobile_phone }}">
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="number_id" class="form-label">Nomor ID</label>
                                    <input type="text" class="form-control" id="number_id" name="number_id"
                                        value="{{ $onboarding->number_id }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="number_tax" class="form-label">Nomor Tax </label>
                                    <input type="text" class="form-control" id="number_tax" name="number_tax"
                                        value="{{ $onboarding->number_tax }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="experience" class="form-label">Pengalaman(tahun)</label>
                                    <input type="text" class="form-control" id="experience" name="experience"
                                        disabled value="{{ $candidate->experience }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="education" class="form-label">Pendidikan</label>
                                    <input type="text" class="form-control" id="education" name="education" disabled
                                        value="{{ $candidate->education }}">
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
                                        value="{{ $candidate->position }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="url" class="form-label">URL Link</label>
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
                                                <input disabled class="form-check-input" type="radio"
                                                    id="special_candidate" name="special_candidate" value="yes"
                                                    {{ $candidate->isSpecial == 1 ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="special_candidate">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="radio"
                                                    id="special_candidate_no" name="special_candidate" value="no"
                                                    {{ $candidate->isSpecial == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="special_candidate_no">Tidak</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="uniqCode" class="form-label">Kode Unik</label>
                                    <input type="text" class="form-control" id="uniqCode" name="uniqCode" disabled
                                        value="{{ $candidate->uniq_code }}">
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="uniqCode" class="form-label">Recruiter</label>
                                    <input type="text" class="form-control" id="uniqCode" name="uniqCode" disabled
                                        value="{{ $onboarding->created_by }}">
                                </div>
                            </div>

                            <h3 class="pt-4">Kontak Darurat</h3>
                            <p>Informasi mengenai Kontak Darurat yang dapat dihubungi direkrut</p>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name_emergency" class="form-label">Nama Kontak</label>
                                    <input type="text" class="form-control" id="name_emergency" name="name_emergency"
                                        placeholder="Masukan nama kontak darurat"
                                        value="{{ $candidate->emergencyContact->name ?? '' }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="number_emergency" class="form-label">Nomor Kontak</label>
                                    <input type="text" class="form-control" id="number_emergency"
                                        placeholder="Masukan nomor kontak darurat" name="number_emergency"
                                        value="{{ $candidate->emergencyContact->number ?? '' }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="relation_emergency" class="form-label">Hubungan</label>
                                    <input type="text" class="form-control" id="relation_emergency"
                                        placeholder="Masukan hubungan untuk kontak darurat" name="relation_emergency"
                                        value="{{ $candidate->emergencyContact->relation ?? '' }}">
                                </div>

                            </div>

                            <div class="pt-4 d-flex justify-content-between">
                                <div>
                                    <h3>Data Keluarga</h3>
                                    <p>Informasi mengenai Data Keluarga Kandidat</p>
                                </div>

                                <div class="p-3">
                                    <button type="button" class="btn btn-primary" id="add-family-member">Tambah
                                        Anggota</button>

                                </div>
                            </div>

                            <div id="family-container">
                                @foreach ($family as $data)
                                    <div class="family-member row mb-3 bordered rounded-lg shadow pt-3 pb-3">
                                        <input type="text" hidden name="familiId[]" id="familiId[]"
                                            value="{{ $data->id }}">
                                        <div class="col-md-6">
                                            <label for="name_family" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="name_family"
                                                name="name_family[]" placeholder="Nama" value="{{ $data->name }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="gender_family" class="form-label">Jenis Kelamin</label>
                                            <select class="form-control" id="gender_family" name="gender_family[]">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="Laki-laki"
                                                    {{ $data->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="Perempuan"
                                                    {{ $data->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label for="work_family" class="form-label">Pekerjaan</label>
                                            <input type="text" class="form-control" id="work_family"
                                                name="work_family[]" placeholder="Pekerjaan"
                                                value="{{ $data->working }}">
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label for="education_family" class="form-label">Pendidikan</label>
                                            <select class="form-control" id="education_family" name="education_family[]">
                                                <option value="">Pilih Pendidikan</option>
                                                <option value="SD" {{ $data->education == 'SD' ? 'selected' : '' }}>SD
                                                </option>
                                                <option value="SMP" {{ $data->education == 'SMP' ? 'selected' : '' }}>
                                                    SMP</option>
                                                <option value="SMA" {{ $data->education == 'SMA' ? 'selected' : '' }}>
                                                    SMA</option>
                                                <option value="D3" {{ $data->education == 'D3' ? 'selected' : '' }}>D3
                                                </option>
                                                <option value="S1" {{ $data->education == 'S1' ? 'selected' : '' }}>S1
                                                </option>
                                                <option value="S2" {{ $data->education == 'S2' ? 'selected' : '' }}>S2
                                                </option>
                                                <option value="S3" {{ $data->education == 'S3' ? 'selected' : '' }}>S3
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <button type="button" id="remove-member"
                                                class="btn btn-danger remove-member">Hapus Anggota</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="pt-4 d-flex justify-content-between">
                                <div>
                                    <h3>Pendidikan Formal</h3>
                                    <p>Informasi mengenai pendidikan formal & pendidikan non-formal kandidat</p>
                                </div>


                                <div class="p-3">
                                    <button type="button" class="btn btn-primary" id="add-educationformal">Tambah
                                        Pendidikan</button>
                                </div>
                            </div>

                            <div id="educationformal-container">
                                @foreach ($education_formal as $data)
                                    <div class="educationformal-member row mb-3 bordered rounded-lg shadow pt-3 pb-3"
                                        id="educationformal-member">
                                        <input type="text" hidden name="educationformalId[]" id="educationformalId[]"
                                            value="{{ optional($data)->id }}">
                                        <div class="col-md-6">
                                            <label for="name_institusi_educationformal" class="form-label">Nama
                                                Institusi</label>
                                            <input type="text" class="form-control"
                                                id="name_institusi_educationformal"
                                                name="name_institusi_educationformal[]" placeholder="Nama Institusi"
                                                value="{{ $data->name }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="city_educationformal" class="form-label">Kota</label>
                                            <input type="text" class="form-control" id="city_educationformal"
                                                name="city_educationformal[]" placeholder="Nama Kota"
                                                value="{{ $data->city }}
                                            ">
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label for="major_educationformal" class="form-label">Jurusan</label>
                                            <input type="text" class="form-control" id="major_educationformal"
                                                name="major_educationformal[]" placeholder="Jurusan"
                                                value="{{ $data->major }}">
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label for="gpa_educationformal" class="form-label">GPA</label>
                                            <input type="text" class="form-control" id="gpa_educationformal"
                                                name="gpa_educationformal[]" placeholder="GPA"
                                                value="{{ $data->gpa }}">
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label for="start_educationformal" class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="start_educationformal"
                                                name="start_educationformal[]"
                                                value="{{ $data->start_date ? \Carbon\Carbon::parse($data->start_date)->format('Y-m-d') : '' }}">
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label for="end_educationformal" class="form-label">Tanggal Selesai</label>
                                            <input type="date" class="form-control" id="end_educationformal"
                                                name="end_educationformal[]"
                                                value="{{ $data->end_date ? \Carbon\Carbon::parse($data->end_date)->format('Y-m-d') : '' }}">
                                        </div>

                                        <div class="col-12 mt-3">
                                            <button type="button" id="remove-educationformal"
                                                class="btn btn-danger remove-educationformal">Hapus</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="pt-4 d-flex justify-content-between">
                                <h3>Pendidikan Non Formal</h3>

                                <div class="p-3">
                                    <button type="button" class="btn btn-primary" id="add-educationNonformal">Tambah
                                    </button>
                                </div>

                            </div>

                            <div id="educationNonformal-container">
                                @foreach ($education_nonformal as $data)
                                    <div class="educationNonformal-member row mb-3 bordered rounded-lg shadow pt-3 pb-3"
                                        id="educationNonformal-member">
                                        <input type="text" hidden name="educationNonformalId[]"
                                            id="educationNonformalId[]" value="{{ optional($data)->id }}">
                                        <div class="col-md-6">
                                            <label for="name_educationNonformal" class="form-label">Nama
                                                Pendidikan</label>
                                            <input type="text" class="form-control" id="name_educationNonformal"
                                                name="name_educationNonformal[]" placeholder="Nama Pendidikan"
                                                value="{{ $data->name }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="year_educationNonformal" class="form-label">Tahun</label>
                                            <input type="text" class="form-control" id="year_educationNonformal"
                                                name="year_educationNonformal[]" placeholder="Tahun Pendidikan"
                                                value="{{ $data->year }}
                                            ">
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label for="duration_educationNonformal"
                                                class="form-label">Durasi(bulan)</label>
                                            <input type="text" class="form-control" id="duration_educationNonformal"
                                                name="duration_educationNonformal[]" placeholder="Durasi Pendidikan"
                                                value="{{ $data->duration }}">
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label for="certificate_educationNonformal"
                                                class="form-label">Sertifikat</label>
                                            <input type="text" class="form-control"
                                                id="certificate_educationNonformal"
                                                name="certificate_educationNonformal[]"
                                                placeholder="Sertifikat Pendidikan" value="{{ $data->certificate }}">
                                        </div>

                                        <div class="col-12 mt-3">
                                            <button type="button" id="remove-educationNonformal"
                                                class="btn btn-danger remove-educationNonformal">Hapus</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="pt-4 d-flex justify-content-between">
                                <div>
                                    <h3>Skill & Keahlian</h3>
                                    <p>Informasi mengenai skill & keahlian yang dimiliki oleh kandidat</p>
                                </div>

                                <div class="p-3">
                                    <button type="button" class="btn btn-primary" id="add-skill">Tambah Skill
                                    </button>
                                </div>

                            </div>

                            <div id="skill-container">
                                @foreach ($skill as $data)
                                    <div class="skill-member row mb-3 bordered rounded-lg shadow pt-3 pb-3"
                                        id="skill-member">
                                        <input type="text" hidden name="skillId[]" id="skillId[]"
                                            value="{{ optional($data)->id }}">
                                        <div class="col-md-6">
                                            <label for="name_skill" class="form-label">Nama Keahlian</label>
                                            <input type="text" class="form-control" id="name_skill"
                                                name="name_skill[]" placeholder="Nama Keahlian"
                                                value="{{ $data->name }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="level_skill" class="form-label">Level</label>
                                            <div class="input-group">
                                                <select class="form-control" id="level_skill" name="level_skill[]">
                                                    <option selected disabled>Pilih Level Skill</option>
                                                    <option value="Advance"
                                                        {{ $data->level == 'Advance' ? 'selected' : '' }}>Advance</option>
                                                    <option value="Good" {{ $data->level == 'Good' ? 'selected' : '' }}>
                                                        Good</option>
                                                    <option value="Very Good"
                                                        {{ $data->level == 'Very Good' ? 'selected' : '' }}>Very Good
                                                    </option>
                                                </select>
                                                <span class="input-group-text"><i class="fas fa-chevron-down"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <button type="button" id="remove-skill"
                                                class="btn btn-danger remove-skill">Hapus</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="pt-4 d-flex justify-content-between">

                                <h3>Bahasa</h3>

                                <div class="p-3">
                                    <button type="button" class="btn btn-primary" id="add-languange">Tambah Bahasa
                                    </button>
                                </div>

                            </div>

                            <div id="languange-container">
                                @foreach ($languange as $data)
                                    <div class="languange-member row mb-3 bordered rounded-lg shadow pt-3 pb-3"
                                        id="languange-member">
                                        <input type="text" hidden name="langaungeId[]" id="langaungeId[]"
                                            value="{{ optional($data)->id }}">

                                        <div class="col-md-6">
                                            <label for="name_languange" class="form-label">Bahasa yang dikuasai</label>
                                            <input type="text" class="form-control" id="name_languange"
                                                name="name_languange[]" placeholder="Nama Keahlian"
                                                value="{{ $data->name_languange }}">
                                        </div>

                                        <div class="col-md-3 align-items-end d-flex">
                                            <button type="button" id="remove-languange"
                                                class="btn btn-danger remove-languange">Hapus</button>
                                        </div>

                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-4">
                                                <label for="write_skill" class="form-label">Tertulis</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="write_languange[]"
                                                        name="write_languange[]">
                                                        <option selected disabled>Pilih Tingkat Kemampuan</option>
                                                        <option value="Beginner"
                                                            {{ $data->write == 'Beginner' ? 'selected' : '' }}>Beginner
                                                        </option>
                                                        <option value="Intermediate"
                                                            {{ $data->write == 'Intermediate' ? 'selected' : '' }}>
                                                            Intermediate</option>
                                                        <option value="Advanced"
                                                            {{ $data->write == 'Advanced' ? 'selected' : '' }}>Advanced
                                                        </option>
                                                    </select>
                                                    <span class="input-group-text"><i
                                                            class="fas fa-chevron-down"></i></span>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="speak_skill" class="form-label">Berbicara</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="speak_languange[]"
                                                        name="speak_languange[]">
                                                        <option selected disabled>Pilih Tingkat Kemampuan</option>
                                                        <option value="Beginner"
                                                            {{ $data->speak == 'Beginner' ? 'selected' : '' }}>Beginner
                                                        </option>
                                                        <option value="Intermediate"
                                                            {{ $data->speak == 'Intermediate' ? 'selected' : '' }}>
                                                            Intermediate</option>
                                                        <option value="Advanced"
                                                            {{ $data->speak == 'Advanced' ? 'selected' : '' }}>Advanced
                                                        </option>
                                                    </select>
                                                    <span class="input-group-text"><i
                                                            class="fas fa-chevron-down"></i></span>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="read_skill" class="form-label">Membaca</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="read_languange[]"
                                                        name="read_languange[]">
                                                        <option selected disabled>Pilih Tingkat Kemampuan</option>
                                                        <option value="Beginner"
                                                            {{ $data->read == 'Beginner' ? 'selected' : '' }}>Beginner
                                                        </option>
                                                        <option value="Intermediate"
                                                            {{ $data->read == 'Intermediate' ? 'selected' : '' }}>
                                                            Intermediate</option>
                                                        <option value="Advanced"
                                                            {{ $data->read == 'Advanced' ? 'selected' : '' }}>Advanced
                                                        </option>
                                                    </select>
                                                    <span class="input-group-text"><i
                                                            class="fas fa-chevron-down"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="pt-4 d-flex justify-content-between">

                                <h3>Pengalaman Bekerja</h3>

                                <div class="p-3">
                                    <button type="button" class="btn btn-primary" id="add-workingExperience">Tambah
                                        Pengalaman
                                    </button>
                                </div>

                            </div>

                            <div id="working-container">
                                @foreach ($working_experience as $data)
                                    <div class="working-member row mb-3 bordered rounded-lg shadow pt-3 pb-3"
                                        id="working-member">
                                        <input type="text" hidden name="workingId[]" id="workingId[]"
                                            value="{{ optional($data)->id }}">

                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-6">
                                                <label for="company_name_working" class="form-label">Nama
                                                    Perusahaan</label>
                                                <input type="text" class="form-control" id="company_name_working"
                                                    name="company_name_working[]" placeholder="Nama Perusahaan" value="{{ $data->name }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="industry_working" class="form-label">Industri</label>
                                                <input type="text" class="form-control" id="industry_working"
                                                    name="industry_working[]" placeholder="Industri" value="{{ $data->industry }}">
                                            </div>
                                        </div>

                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-12">
                                                <label for="address_working" class="form-label">Alamat Perusahan</label>
                                                <input type="text" class="form-control" id="address_working"
                                                    name="address_working[]" placeholder="Alamat Perusahaan" value="{{ $data->address }}">
                                            </div>
                                        </div>

                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-6">
                                                <label for="status_working" class="form-label">Status</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="status_working[]"
                                                        name="status_working[]">
                                                        <option selected disabled>Pilih Status</option>
                                                        <option value="Bekerja"
                                                            {{ $data->status == 'Bekerja' ? 'selected' : '' }}>Bekerja
                                                        </option>
                                                        <option value="Selesai"
                                                            {{ $data->status== 'Selesai' ? 'selected' : '' }}>Selesai
                                                        </option>
                                                    </select>
                                                    <span class="input-group-text"><i
                                                            class="fas fa-chevron-down"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-6 mt-3">
                                                <label for="start_working" class="form-label">Tanggal
                                                    Mulai Kerja</label>
                                                <input type="date" class="form-control" id="start_working"
                                                    name="start_working[]" value="{{ $data->start_date ? \Carbon\Carbon::parse($data->start_date)->format('Y-m-d') : '' }}">
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="end_working" class="form-label">Tanggal
                                                    Selesai Kerja</label>
                                                <input type="date" class="form-control" id="end_working"
                                                    name="end_working[]" value="{{ $data->end_date ? \Carbon\Carbon::parse($data->end_date)->format('Y-m-d') : '' }}">
                                            </div>
                                        </div>


                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-12">
                                                <label for="description_working" class="form-label">Deskripsi
                                                    Pekerjaan</label>
                                                <textarea class="form-control" name="description_working[]" id="description_working[]">{{ $data->description }}</textarea>
                                            </div>
                                        </div>

                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-6">
                                                <label for="allowance_working" class="form-label">Allowance</label>
                                                <input type="text" class="form-control" id="allowance_working"
                                                    name="allowance_working[]" placeholder="Masukan Allowance" value="{{ $data->allowance }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="salary_working" class="form-label">Gaji</label>
                                                <input type="text" class="form-control" id="salary_working"
                                                    name="salary_working[]" placeholder="Masukan Gaji" value="{{ $data->salary }}">
                                            </div>
                                        </div>

                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-12">
                                                <label for="project_working" class="form-label">Project</label>
                                                <textarea class="form-control" name="project_working[]" id="project_working[]">{{ $data->project }}</textarea>
                                            </div>
                                        </div>

                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-12">
                                                <label for="reason_working" class="form-label">Alasan Keluar
                                                    Perusahaan</label>
                                                <input type="text" class="form-control" id="reason_working"
                                                    name="reason_working[]" placeholder="Masukan Alasan" value="{{ $data->reason }}">
                                            </div>
                                        </div>


                                        <div class="col-12 mt-3">
                                            <button type="button" id="remove-working"
                                                class="btn btn-danger remove-working">Hapus</button>
                                        </div>


                                    </div>
                                @endforeach
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
                                        <td class="d-flex align-items-center justify-content-center align-middle">
                                            <div class="nominal-container">
                                                <div class="input-group w-100">
                                                    <span class="input-group-text">Rp</span>
                                                    <input required type="text" id="offeringSalary"
                                                        class="form-control" name="offeringSalary"
                                                        placeholder="Gaji Pokok" disabled
                                                        value="{{ $offeringSalary->salary ?? '' }}">
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td class="text-center align-middle">
                                            <input type="text" name="ket_salary" id="ket_offeringSalary"
                                                class="form-control" placeholder="Masukan Catatan" disabled
                                                value="{{ $offeringSalary->ket_salary ?? '' }}">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="align-middle">PPH 21</td>
                                        <td>{{ '' }}</td>
                                        <td class="text-center align-middle">
                                            <div class="form-check form-switch d-flex justify-content-center"
                                                style="gap: 10px;">
                                                @if (isset($offeringSalary) && $offeringSalary->pph21 !== null)
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        role="switch" {{ $offeringSalary->pph21 == 1 ? 'checked' : '' }}
                                                        style="width: 50px; height: 25px;" name="pph21" id="pph21">
                                                @else
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="pph21" id="pph21" style="width: 50px; height: 25px;">
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <input disabled type="text" class="form-control" name="ket_pph21"
                                                id="ket_pph21" placeholder="Masukan Catatan"
                                                value="{{ $offeringSalary->ket_pph21 ?? '' }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle">BPJS Ketenagakerjaan</td>
                                        <td class="text-center align-middle">{{ '' }}</td>
                                        <td class="text-center align-middle">
                                            <div class="form-check form-switch d-flex justify-content-center"
                                                style="gap: 10px;">
                                                @if (isset($offeringSalary) && $offeringSalary->bpjs_ket !== null)
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        role="switch" name="bpjs_ket" id="bpjs_ket"
                                                        style="width: 50px; height: 25px;"
                                                        {{ $offeringSalary->bpjs_ket == 1 ? 'checked' : '' }}>
                                                @else
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        role="switch" name="bpjs_ket" id="bpjs_ket"
                                                        style="width: 50px; height: 25px;">
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <input disabled type="text" class="form-control" name="ket_bpjsket"
                                                id="ket_bpjsket" placeholder="Masukan Catatan"
                                                value="{{ $offeringSalary->ket_bpjsket ?? '' }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle">BPJS Kesehatan</td>
                                        <td>{{ '' }}</td>
                                        <td class="text-center align-middle">
                                            <div class="form-check form-switch d-flex justify-content-center"
                                                style="gap: 10px;">
                                                @if (isset($offeringSalary) && $offeringSalary->bpjs_kes !== null)
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        role="switch" name="bpjs_kes" id="bpjs_kes"
                                                        style="width: 50px; height: 25px;"
                                                        {{ $offeringSalary->bpjs_kes == 1 ? 'checked' : '' }}>
                                                @else
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        role="switch" name="bpjs_kes" id="bpjs_kes"
                                                        style="width: 50px; height: 25px;">
                                                @endif
                                            </div>
                                        </td class="text-center align-middle">
                                        <td class="text-center align-middle">
                                            <input disabled type="text" class="form-control" name="ket_bpjskes"
                                                id="ket_bpjskes" placeholder="Masukan Catatan"
                                                value="{{ $offeringSalary->ket_bpjskes ?? '' }}">
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
                                    @foreach ($offeringFasilitas as $data)
                                        <tr class="fasilitas-stage">
                                            <input name="fasilitas_id[]" value="{{ $data->id }}" hidden>
                                            <td class="text-center align-middle ">
                                                <select class="form-control" name="fasilitas[]">
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
                                                    placeholder="Masukkan keterangan"
                                                    value="{{ $data->ket_fasilitas }}" />
                                            </td>
                                            <td class="text-center align-middle">
                                                <button type="button" class="btn btn-danger removeStageButton">
                                                    <i class="fas fa-trash-alt removeStageButton"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                        </div>

                        {{-- Tab Verifikasi --}}
                        <div class="tab-pane fade show" id="additional" role="tabpanel"
                            aria-labelledby="additional-tab">

                            <h3 class="pt-4">Informasi Kandidat</h3>
                            <p>Informasi mengenai kandidat yang akan direkrut</p>

                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nama</label>
                                    <input class="form-control" type="text" id="name" name="name" disabled
                                        value="{{ $onboarding->name }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <div class="custom-select-wrapper">
                                        <select class="form-control" id="gender" name="gender" disabled>
                                            <option value="Laki Laki"
                                                {{ $onboarding->gender == 'Laki Laki' ? 'selected' : '' }}>
                                                Laki
                                                Laki</option>
                                            <option value="Perempuan"
                                                {{ $onboarding->gender == 'Perempuan' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                        <i class="fas fa-chevron-down select-icon"></i>
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="address" class="form-label">Alamat Rumah</label>
                                    <input disabled type="text" class="form-control" id="verifikasi_address">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="country" class="form-label">Negara</label>
                                    <input disabled type="text" class="form-control" id="verifikasi_country"
                                        name="country" value="{{ $onboarding->country }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="province" class="form-label">Provinsi</label>
                                    <input disabled type="text" class="form-control" id="verifikasi_province"
                                        name="province" value="{{ $onboarding->province }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="city" class="form-label">Kota</label>
                                    <input disabled type="text" class="form-control" id="verifikasi_city"
                                        name="verifikasi_city" value="{{ $onboarding->city }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="zipcode" class="form-label">Kode Pos</label>
                                    <input disabled type="text" class="form-control" id="verifikasi_zipcode"
                                        name="zipcode" value="{{ $onboarding->zipcode }}">
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="place_of_birth" class="form-label">Tempat Lahir</label>
                                    <input disabled type="text" class="form-control" id="verifikasi_place_of_birth"
                                        name="place_of_birth" value="{{ $onboarding->place_of_birth }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                                    <input disabled type="date" class="form-control" id="verifikasi_date_of_birth"
                                        name="date_of_birth" value="{{ $onboarding->date_of_birth }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="country" class="form-label">Golongan Darah</label>
                                    <div class="input-group">
                                        <select disabled class="form-control" name="blood_type"
                                            id="verifikasi_blood_type">
                                            <option selected>Pilih Golongan Darah</option>
                                            <option value="A"
                                                {{ $onboarding->blood_type == 'A' ? 'selected' : '' }}>
                                                A</option>
                                            <option value="B"
                                                {{ $onboarding->blood_type == 'B' ? 'selected' : '' }}>
                                                B</option>
                                            <option value="AB"
                                                {{ $onboarding->blood_type == 'AB' ? 'selected' : '' }}>
                                                AB</option>
                                            <option value="O"
                                                {{ $onboarding->blood_type == 'O' ? 'selected' : '' }}>
                                                O</option>
                                        </select>
                                        <i class="fas fa-chevron-down select-icon"></i>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="religion" class="form-label">Agama</label>
                                    <input disabled type="text" class="form-control" id="verifikasi_religion"
                                        name="religion" value="{{ $onboarding->religion }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="home_phone" class="form-label">Telepon Rumah</label>
                                    <input disabled type="text" class="form-control" id="verifikasi_home_phone"
                                        name="home_phone" value="{{ $onboarding->home_phone }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="mobile_phone" class="form-label">Nomor Handphone</label>
                                    <input disabled type="text" class="form-control" id="verifikasi_mobile_phone"
                                        name="mobile_phone" value="{{ $onboarding->mobile_phone }}">
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="number_id" class="form-label">Nomor ID</label>
                                    <input disabled type="text" class="form-control" id="verifikasi_number_id"
                                        name="number_id" value="{{ $onboarding->number_id }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="number_tax" class="form-label">Nomor Tax </label>
                                    <input disabled type="date" class="form-control" id="verifikasi_number_tax"
                                        name="number_tax" value="{{ $onboarding->number_tax }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="experience" class="form-label">Pengalaman(tahun)</label>
                                    <input type="text" class="form-control" id="experience" name="experience"
                                        disabled value="{{ $candidate->experience }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="education" class="form-label">Pendidikan</label>
                                    <input type="text" class="form-control" id="education" name="education" disabled
                                        value="{{ $candidate->education }}">
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
                                    <input type="text" class="form-control" id="project" name="project"
                                        disabled value="{{ $resource->project }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="position" class="form-label">Posisi</label>
                                    <input type="text" class="form-control" id="position" name="position"
                                        disabled value="{{ $candidate->position }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="url" class="form-label">URL Link</label>
                                    <input type="text" class="form-control" id="url" name="url"
                                        disabled value="{{ $candidate->url }}">
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label d-block">Khusus</label>
                                        <div class="p-2 d-flex gap-3">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="radio"
                                                    {{ $candidate->isSpecial == 1 ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="special_candidate">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="radio"
                                                    {{ $candidate->isSpecial == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="special_candidate_no">Tidak</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="uniqCode" class="form-label">Kode Unik</label>
                                    <input type="text" class="form-control" id="uniqCode" name="uniqCode"
                                        disabled value="{{ $candidate->uniq_code }}">
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="uniqCode" class="form-label">Recruiter</label>
                                    <input type="text" class="form-control" id="uniqCode" name="uniqCode"
                                        disabled value="{{ $onboarding->created_by }}">
                                </div>
                            </div>

                            <h3 class="pt-4">Kontak Darurat</h3>
                            <p>Informasi mengenai Kontak Darurat yang dapat dihubungi direkrut</p>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name_emergency" class="form-label">Nama Kontak</label>
                                    <input type="text" class="form-control" id="verifikasi_name_emergency" disabled
                                        name="name_emergency"">
                                </div>

                                <div class="col-md-6">
                                    <label for="number_emergency" class="form-label">Nomor Kontak</label>
                                    <input type="text" class="form-control" id="verifikasi_number_emergency"
                                        disabled name="number_emergency">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="relation_emergency" class="form-label">Hubungan</label>
                                    <input type="text" class="form-control" id="verifikasi_relation_emergency"
                                        disabled name="relation_emergency"">
                                </div>

                            </div>

                            <h3 class="pt-4">Data Keluarga</h3>
                            <p>Informasi mengenai Data Keluarga Kandidat</p>

                            <div id="verifikasi_family_container">
                            </div>

                            <h3 class="pt-4">Pendidikan Formal</h3>
                            <p>Informasi mengenai pendidikan formal & pendidikan non-formal kandidat</p>

                            <div id="verifikasi_educationformal-container">
                            </div>

                            <h3 class="pt-4">Pendidikan Non Formal</h3>
                            <div id="verifikasi_educationNonformal-container">
                            </div>

                        </div>

                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="backButton"
                        style="display: none;">Kembali</button>
                    <button type="button" class="btn btn-primary" id="nextButton">Lanjut</button>
                    <button type="submit" class="btn btn-success" form="saveOnboarding" id="saveButton"
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


            const familyStages = document.getElementsByClassName('family-member');
            const familyContainer = document.getElementById('verifikasi_family_container');

            const educationformalStages = document.getElementsByClassName('educationformal-member');
            const educationformalContainer = document.getElementById('verifikasi_educationformal-container');

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

                    //informasi Kandidat
                    document.getElementById('verifikasi_address').value = document.getElementById('address').value;

                    document.getElementById('verifikasi_country').value = document.getElementById(
                            'country')
                        .value;

                    document.getElementById('verifikasi_province').value = document.getElementById(
                            'province')
                        .value;


                    document.getElementById('verifikasi_city').value = document.getElementById(
                            'city')
                        .value;

                    document.getElementById('verifikasi_zipcode').value = document.getElementById(
                            'zipcode')
                        .value;

                    document.getElementById('verifikasi_place_of_birth').value = document.getElementById(
                            'place_of_birth')
                        .value;

                    document.getElementById('verifikasi_date_of_birth').value = document.getElementById(
                            'date_of_birth')
                        .value;

                    document.getElementById('verifikasi_blood_type').value = document.getElementById(
                            'blood_type')
                        .value;

                    document.getElementById('verifikasi_religion').value = document.getElementById(
                            'religion')
                        .value;

                    document.getElementById('verifikasi_home_phone').value = document.getElementById(
                            'home_phone')
                        .value;

                    document.getElementById('verifikasi_mobile_phone').value = document.getElementById(
                            'mobile_phone')
                        .value;

                    document.getElementById('verifikasi_number_id').value = document.getElementById(
                            'number_id')
                        .value;

                    document.getElementById('verifikasi_number_tax').value = document.getElementById(
                            'number_tax')
                        .value;

                    document.getElementById('verifikasi_name_emergency').value = document.getElementById(
                            'name_emergency')
                        .value;

                    document.getElementById('verifikasi_number_emergency').value = document.getElementById(
                            'number_emergency')
                        .value;

                    document.getElementById('verifikasi_relation_emergency').value = document.getElementById(
                            'relation_emergency')
                        .value;

                    //family
                    if (familyStages.length === 2) {
                        familyContainer.innerHTML = '<p>Tidak ada fasilitas yang tersedia.</p>';
                    }
                    familyContainer.innerHTML = '';
                    Array.from(familyStages).forEach((familyStages, index) => {

                        const family_name = familyStages.querySelector('input[name="name_family[]"]').value;
                        const family_gender = familyStages.querySelector('select[name="gender_family[]"]')
                            .value;
                        const family_work = familyStages.querySelector('input[name="work_family[]"]').value;
                        const family_education = familyStages.querySelector(
                            'select[name="education_family[]"]').value;

                        familyContainer.insertAdjacentHTML('beforeend', `
                            <div class="family-member row mb-3 bordered rounded-lg shadow pt-3 pb-3">
                                    <div class="col-md-6">
                                        <label for="name_family" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="name_family" name="name_family[]"  value="${family_name}" disabled
                                            placeholder="Nama">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="gender_family" class="form-label">Jenis Kelamin</label>
                                        <select disabled class="form-control" id="gender_family" name="gender_family[]">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" ${family_gender === 'Laki-laki' ? 'selected' : ''}>Laki-laki</option>
                                            <option value="Perempuan" ${family_gender === 'Perempuan' ? 'selected' : ''}>Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="work_family" class="form-label">Pekerjaan</label>
                                        <input disabled type="text" class="form-control" id="work_family" name="work_family[]" value="${family_work}"
                                            placeholder="Pekerjaan">
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="education_family" class="form-label">Pendidikan</label>
                                        <select disabled class="form-control" id="education_family" name="education_family[]">
                                            <option value="">Pilih Pendidikan</option>
                                            <option value="SD" ${family_education === 'SD' ? 'selected' : ''}>SD</option>
                                            <option value="SMP"  ${family_education === 'SMP' ? 'selected' : ''}>SMP</option>
                                            <option value="SMA"  ${family_education === 'SMA' ? 'selected' : ''}>SMA</option>
                                            <option value="D3"  ${family_education === 'D3' ? 'selected' : ''}>D3</option>
                                            <option value="S1"  ${family_education === 'S1' ? 'selected' : ''}>S1</option>
                                            <option value="S2"  ${family_education === 'S2' ? 'selected' : ''}>S2</option>
                                            <option value="S3"  ${family_education === 'S3' ? 'selected' : ''}>S3</option>
                                        </select>
                                    </div>
                                </div>           
                    `);
                    });

                    //educationformal
                    educationformalContainer.innerHTML = '';
                    Array.from(educationformalStages).forEach((educationformalStages, index) => {

                        // const name_institusi = educationformalStages.querySelector('input[name="name_institusi_educationformal[]"]').value;
                        // const city = educationformalStages.querySelector('select[name="city_educationformal[]"]')
                        // const major = educationformalStages.querySelector('input[name="major_educationformal[]"]').value;
                        // const gpa = educationformalStages.querySelector('input[name="gpa_educationformal[]"]').value;
                        // const start = educationformalStages.querySelector('input[name="start_educationformal[]"]').value;
                        // const end = educationformalStages.querySelector('input[name="end_institusi_educationformal[]"]').value;

                        educationformalContainer.insertAdjacentHTML('beforeend', `
                            <div class="educationformal-member row mb-3 bordered rounded-lg shadow pt-3 pb-3">
                                        <div class="col-md-6">
                                            <label for="name_institusi_educationformal" class="form-label">Nama Institusi</label>
                                            <input type="text" class="form-control"
                                                 placeholder="Nama Institusi" value="${ name_institusi }">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="city_educationformal" class="form-label">Kota</label>
                                            <input type="text" class="form-control"
                                                 placeholder="Nama Kota" value="${ city }
                                            ">
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label for="major_educationformal" class="form-label">Jurusan</label>
                                            <input type="text" class="form-control" id="major_educationformal"
                                                name="major_educationformal[]" placeholder="Jurusan"
                                                value="${ major }">
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label for="gpa_educationformal" class="form-label">GPA</label>
                                            <input type="text" class="form-control"
                                                placeholder="GPA"
                                                value="${ gpa }">
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label for="start_educationformal" class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control"
                                                value="${ start }">
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label for="end_educationformal" class="form-label">Tanggal Selesai</label>
                                            <input type="date" class="form-control"
                                                value="${ end }">
                                        </div>

                                    </div>           
                    `);
                    });



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

                    document.getElementById('verifikasi_offeringSalary').value = document.getElementById(
                            'offeringSalary')
                        .value;

                    document.getElementById('verifikasi_ket_offeringSalary').value = document.getElementById(
                            'ket_offeringSalary')
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
            <td class="text-center align-middle">
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
        function formatRupiah(value) {
            if (!value) return '';
            return value.replace(/\D/g, '') // Remove non-numeric characters
                .replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Add periods for thousands
        }

        document.getElementById('offeringSalary').addEventListener('input', function() {
            const minSalary = parseInt(document.getElementById('minimalNominal').value || 0, 10);
            const maxSalary = parseInt(document.getElementById('maximalNominal').value || 0, 10);

            let offeringSalary = this.value.replace(/\D/g, ''); // Hanya angka
            const formattedValue = formatRupiah(offeringSalary);
            this.value = `${formattedValue}`;

            offeringSalary = parseInt(offeringSalary || 0, 10); // Hanya angka

            const errorElement = document.getElementById('offeringSalaryError');

            this.classList.remove('is-invalid');
            errorElement.classList.add('d-none');
            errorElement.textContent = '';

            if (offeringSalary < minSalary) {
                this.classList.add('is-invalid');
                errorElement.classList.remove('d-none');
                errorElement.textContent = 'Offering salary tidak boleh kurang dari minimal salary.';
            } else if (offeringSalary > maxSalary) {
                this.classList.add('is-invalid');
                errorElement.classList.remove('d-none');
                errorElement.textContent = 'Offering salary tidak boleh lebih dari maximal salary.';
            }
        });
    </script>

    <script>
        document.getElementById('add-family-member').addEventListener('click', function() {
            const container = document.getElementById('family-container');

            const newStage = `
        <div class="family-member row mb-3 bordered rounded-lg shadow pt-3 pb-3">
                                    <input type="text" hidden name="familiId[]" id="familiId[]" value="0">
                                    <div class="col-md-6">
                                        <label for="name_family" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="name_family" name="name_family[]"
                                            placeholder="Nama">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="gender_family" class="form-label">Jenis Kelamin</label>
                                        <select class="form-control" id="gender_family" name="gender_family[]">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="work_family" class="form-label">Pekerjaan</label>
                                        <input type="text" class="form-control" id="work_family" name="work_family[]"
                                            placeholder="Pekerjaan">
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="education_family" class="form-label">Pendidikan</label>
                                        <select class="form-control" id="education_family" name="education_family[]">
                                            <option value="">Pilih Pendidikan</option>
                                            <option value="SD">SD</option>
                                            <option value="SMP">SMP</option>
                                            <option value="SMA">SMA</option>
                                            <option value="D3">D3</option>
                                            <option value="S1">S1</option>
                                            <option value="S2">S2</option>
                                            <option value="S3">S3</option>
                                        </select>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <button type="button" id="remove-member" class="btn btn-danger remove-member">Hapus Anggota</button>
                                    </div>
                                </div>           
    `;
            container.insertAdjacentHTML('beforeend', newStage);
        });

        document.getElementById('family-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-member')) {
                e.target.closest('.family-member').remove();
            }
        });

        document.getElementById('add-educationformal').addEventListener('click', function() {
            const container = document.getElementById('educationformal-container');

            const newStage = `
            <div class="educationformal-member row mb-3 bordered rounded-lg shadow pt-3 pb-3">
                <input type="text" hidden name="educationformalId[]" id="educationformalId[]"
                    value="0">
                <div class="col-md-6">
                    <label for="name_institusi_educationformal" class="form-label">Nama Institusi</label>
                    <input type="text" class="form-control" id="name_institusi_educationformal"
                        name="name_institusi_educationformal[]" placeholder="Nama Institusi">
                </div>

                <div class="col-md-6">
                    <label for="city_educationformal" class="form-label">Kota</label>
                    <input type="text" class="form-control" id="city_educationformal"
                        name="city_educationformal[]" placeholder="Nama Kota"">
                </div>

                <div class="col-md-6 mt-3">
                    <label for="major_educationformal" class="form-label">Jurusan</label>
                    <input type="text" class="form-control" id="major_educationformal"
                        name="major_educationformal[]" placeholder="Jurusan">
                </div>

                <div class="col-md-6 mt-3">
                    <label for="gpa_educationformal" class="form-label">GPA</label>
                    <input type="text" class="form-control" id="gpa_educationformal"
                        name="gpa_educationformal[]" placeholder="GPA">
                </div>

                <div class="col-md-6 mt-3">
                    <label for="start_educationformal" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_educationformal" name="start_educationformal[]" >
                </div>

                <div class="col-md-6 mt-3">
                    <label for="end_educationformal" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="end_educationformal" name="end_educationformal[]" >
                </div>

                <div class="col-12 mt-3">
                        <button type="button" id="remove-educationformal"
                        class="btn btn-danger remove-educationformal">Hapus</button>
                </div>
            </div>
            `;
            container.insertAdjacentHTML('beforeend', newStage);
        });

        document.getElementById('educationNonformal-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-educationNonformal')) {
                e.target.closest('.educationNonformal-member').remove();
            }
        });

        document.getElementById('add-educationNonformal').addEventListener('click', function() {
            const container = document.getElementById('educationNonformal-container');

            const newStage = `
            <div class="educationNonformal-member row mb-3 bordered rounded-lg shadow pt-3 pb-3"
                id="educationNonformal-member">
                <input type="text" hidden name="educationNonformalId[]" id="educationNonformalId[]"
                    value="0">
                <div class="col-md-6">
                    <label for="name_educationNonformal" class="form-label">Nama Pendidikan</label>
                    <input type="text" class="form-control" id="name_educationNonformal"
                        name="name_educationNonformal[]" placeholder="Nama Pendidikan" ">
                </div>

                <div class="col-md-6">
                    <label for="year_educationNonformal" class="form-label">Tahun</label>
                    <input type="text" class="form-control" id="year_educationNonformal"
                        name="year_educationNonformal[]" placeholder="Tahun Pendidikan">
                </div>

                <div class="col-md-6 mt-3">
                    <label for="duration_educationNonformal" class="form-label">Durasi(bulan)</label>
                        <input type="text" class="form-control" id="duration_educationNonformal"
                            name="duration_educationNonformal[]" placeholder="Durasi Pendidikan">
                </div>

                <div class="col-md-6 mt-3">
                    <label for="certificate_educationNonformal" class="form-label">Sertifikat</label>
                    <input type="text" class="form-control" id="certificate_educationNonformal"
                        name="certificate_educationNonformal[]" placeholder="Sertifikat Pendidikan">
                </div>

                <div class="col-12 mt-3">
                    <button type="button" id="remove-educationNonformal"
                        class="btn btn-danger remove-educationNonformal">Hapus</button>
                </div>
            </div>
            `;
            container.insertAdjacentHTML('beforeend', newStage);
        });

        document.getElementById('skill-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-skill')) {
                e.target.closest('.skill-member').remove();
            }
        });

        document.getElementById('add-skill').addEventListener('click', function() {
            const container = document.getElementById('skill-container');

            const newStage = `
            <div class="skill-member row mb-3 bordered rounded-lg shadow pt-3 pb-3"
                id="skill-member">
                <input type="text" hidden name="skillId[]" id="skillId[]" value="0">
                <div class="col-md-6">
                    <label for="name_skill" class="form-label">Nama Keahlian</label>
                        <input type="text" class="form-control" id="name_skill"
                        name="name_skill[]" placeholder="Nama Keahlian">
                </div>

                <div class="col-md-6">
                    <label for="level_skill" class="form-label">Level</label>
                    <div class="input-group">
                    <select class="form-control" id="level_skill" name="level_skill[]">
                        <option selected disabled>Pilih Level Skill</option>
                        <option value="Advance" >Advance</option>
                        <option value="Good">Good</option>
                        <option value="Very Good">Very Good</option>
                    </select>
                    <span class="input-group-text"><i class="fas fa-chevron-down"></i></span>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <button type="button" id="remove-skill"
                        class="btn btn-danger remove-skill">Hapus</button>
                </div>
             </div>
            `;
            container.insertAdjacentHTML('beforeend', newStage);
        });

        document.getElementById('languange-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-languange')) {
                e.target.closest('.languange-member').remove();
            }
        });

        document.getElementById('add-languange').addEventListener('click', function() {
            const container = document.getElementById('languange-container');

            const newStage = `
            <div class="languange-member row mb-3 bordered rounded-lg shadow pt-3 pb-3"
                                        id="languange-member">
                                        <input type="text" hidden name="langaungeId[]" id="langaungeId[]"
                                            value="0">

                                        <div class="col-md-6">
                                            <label for="name_languange" class="form-label">Bahasa yang dikuasai</label>
                                            <input type="text" class="form-control" id="name_languange"
                                                name="name_languange[]" placeholder="Nama Keahlian">
                                        </div>

                                        <div class="col-md-3 align-items-end d-flex">
                                            <button type="button" id="remove-languange"
                                                class="btn btn-danger remove-languange">Hapus</button>
                                        </div>

                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-4">
                                                <label for="write_skill" class="form-label">Tertulis</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="write_languange[]" name="write_languange[]">
                                                        <option selected disabled>Pilih Tingkat Kemampuan</option>
                                                        <option value="Beginner">Beginner</option>
                                                        <option value="Intermediate">Intermediate</option>
                                                        <option value="Advanced">Advanced</option>
                                                    </select>
                                                    <span class="input-group-text"><i
                                                            class="fas fa-chevron-down"></i></span>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="speak_skill" class="form-label">Berbicara</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="speak_languange[]" name="speak_languange[]">
                                                        <option selected disabled>Pilih Tingkat Kemampuan</option>
                                                        <option value="Beginner">Beginner</option>
                                                        <option value="Intermediate">Intermediate</option>
                                                        <option value="Advanced">Advanced</option>
                                                    </select>
                                                    <span class="input-group-text"><i
                                                            class="fas fa-chevron-down"></i></span>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="read_skill" class="form-label">Membaca</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="read_languange[]" name="read_languange[]">
                                                        <option selected disabled>Pilih Tingkat Kemampuan</option>
                                                        <option value="Beginner">Beginner</option>
                                                        <option value="Intermediate">Intermediate</option>
                                                        <option value="Advanced">Advanced</option>
                                                    </select>
                                                    <span class="input-group-text"><i
                                                            class="fas fa-chevron-down"></i></span>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
            `;
            container.insertAdjacentHTML('beforeend', newStage);
        });

        document.getElementById('languange-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-languange')) {
                e.target.closest('.languange-member').remove();
            }
        });

        document.getElementById('add-workingExperience').addEventListener('click', function() {
            const container = document.getElementById('working-container');

            const newStage = `
            <div class="working-member row mb-3 bordered rounded-lg shadow pt-3 pb-3"
                                        id="working-member">
                                        <input type="text" hidden name="workingId[]" id="workingId[]"
                                            value="0">

                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-6">
                                                <label for="company_name_working" class="form-label">Nama
                                                    Perusahaan</label>
                                                <input type="text" class="form-control" id="company_name_working"
                                                    name="company_name_working[]" placeholder="Nama Perusahaan">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="industry_working" class="form-label">Industri</label>
                                                <input type="text" class="form-control" id="industry_working"
                                                    name="industry_working[]" placeholder="Industri">
                                            </div>
                                        </div>

                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-12">
                                                <label for="address_working" class="form-label">Alamat Perusahan</label>
                                                <input type="text" class="form-control" id="address_working"
                                                    name="address_working[]" placeholder="Alamat Perusahaan">
                                            </div>
                                        </div>

                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-6">
                                                <label for="status_working" class="form-label">Status</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="status_working[]"
                                                        name="status_working[]">
                                                        <option selected disabled>Pilih Status</option>
                                                        <option value="Bekerja"
                                                            {{ $data->write == 'Bekerja' ? 'selected' : '' }}>Bekerja
                                                        </option>
                                                        <option value="Selesai"
                                                            {{ $data->write == 'Selesai' ? 'selected' : '' }}>Selesai
                                                        </option>
                                                    </select>
                                                    <span class="input-group-text"><i
                                                            class="fas fa-chevron-down"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-6 mt-3">
                                                <label for="start_working" class="form-label">Tanggal
                                                    Mulai Kerja</label>
                                                <input type="date" class="form-control" id="start_working"
                                                    name="start_working[]" {{-- value="{{ $data->start_date ? \Carbon\Carbon::parse($data->start_date)->format('Y-m-d') : '' }}" --}}>
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="end_working" class="form-label">Tanggal
                                                    Selesai Kerja</label>
                                                <input type="date" class="form-control" id="end_working"
                                                    name="end_working[]" {{-- value="{{ $data->end_date ? \Carbon\Carbon::parse($data->end_date)->format('Y-m-d') : '' }}" --}}>
                                            </div>
                                        </div>


                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-12">
                                                <label for="description_working" class="form-label">Deskripsi
                                                    Pekerjaan</label>
                                                <textarea class="form-control" name="description_working[]" id="description_working[]"></textarea>
                                            </div>
                                        </div>

                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-6">
                                                <label for="allowance_working" class="form-label">Allowance</label>
                                                <input type="text" class="form-control" id="allowance_working"
                                                    name="allowance_working[]" placeholder="Masukan Allowance">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="salary_working" class="form-label">Gaji</label>
                                                <input type="text" class="form-control" id="salary_working"
                                                    name="salary_working[]" placeholder="Masukan Gaji">
                                            </div>
                                        </div>

                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-12">
                                                <label for="project_working" class="form-label">Project</label>
                                                <textarea class="form-control" name="project_working[]" id="project_working[]"></textarea>
                                            </div>
                                        </div>

                                        <div class="row pt-3 pb-3">
                                            <div class="col-md-12">
                                                <label for="reason_working" class="form-label">Alasan Keluar
                                                    Perusahaan</label>
                                                <input type="text" class="form-control" id="reason_working"
                                                    name="reason_working[]" placeholder="Masukan Alasan">
                                            </div>
                                        </div>

                                         <div class="col-12 mt-3">
                                            <button type="button" id="remove-working"
                                                class="btn btn-danger remove-working">Hapus</button>
                                        </div>

                                    </div>
            `;
            container.insertAdjacentHTML('beforeend', newStage);
        });

        document.getElementById('working-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-working')) {
                e.target.closest('.working-member').remove();
            }
        });
    </script>


@endsection
