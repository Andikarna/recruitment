@extends('layouts.dashboardLayouts')

@section('ADIDATA', 'Global Kandidat')

@section('username', Auth::user()->name)
@section('userid', Auth::user()->id)

@section('links')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
@endsection


@section('styles')
    <style>
        .hidden {
            display: none;
        }

        .nav-link.active {
            background-color: #0d6efd;
            color: white !important;
        }

        .pointer {
            cursor: pointer;
        }

        .pointer:hover {
            color: #0d6efd
        }
    </style>
@endsection

@section('title-content', 'Global Kandidat')

@section('content')


    <div class="d-flex justify-content-start align-items-center mb-3 bg-white pt-2 pl-3 pb-2 pr-2 rounded shadow-sm">
        <i class="fas fa-arrow-left me-2 pointer" onclick="window.history.back()"></i>
        <p class="mb-0 fw-medium">Lihat Detail Data Diri</p>
    </div>

    <div class="row">
        <div class="col-md-2 ">
            <div class="p-2 bg-white shadow rounded">
                <ul class="nav flex-column nav-pills">
                    <li class="nav-item">
                        <a class="nav-link text-muted active d-flex align-items-center" style="font-size: 12px"
                            id="menu-detail" href="#">
                            <i class="fas fa-user me-2"></i>
                            Detail Data Diri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-muted d-flex align-items-center" style="font-size: 12px" id="menu-riwayat"
                            href="#">
                            <i class="fas fa-history me-2"></i>
                            Riwayat
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="col-md-10">
            <div id="container-detail" class="bg-white shadow rounded p-4">
                <h3 class="mb-2">Detail Data Diri</h3>
                <p class="text-muted">Informasi data diri kandidat</p>
                <form>
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $candidate->name }}" placeholder="Masukan nama lengkap kandidat" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="position" class="form-label">Posisi</label>
                                <input type="text" class="form-control" id="position" name="position"
                                    value="{{ $candidate->position }}" disabled placeholder="Masukan Posisi Kandidat">
                            </div>


                            <div class="mb-3">
                                <label for="experience" class="form-label">Pengalaman (tahun)</label>
                                <input type="number" class="form-control" id="experience" name="experience"
                                    placeholder="Masukan berapa lama pengalaman kandidat"
                                    value="{{ $candidate->experience }}" min="0" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="major" class="form-label">Jurusan</label>
                                <input type="text" class="form-control" id="major" name="major"
                                    placeholder="Masukan jurusan kandidat" value="{{ $candidate->major }}" disabled>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <div class="input-group">
                                    <select class="form-control" id="gender" name="gender" disabled>
                                        <option value="Laki-laki" {{ $candidate->gender == 'Laki-Laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="Perempuan" {{ $candidate->gender == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                    <span class="input-group-text">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="qualification" class="form-label">Kualifikasi</label>
                                <div class="input-group">
                                    <select class="form-control" id="qualification" name="qualification" disabled>
                                        <option value="Fresh Graduate"
                                            {{ $candidate->qualification == 'Fresh Graduate' ? 'selected' : '' }}>Fresh
                                            Graduate</option>
                                        <option value="Junior"
                                            {{ $candidate->qualification == 'Junior' ? 'selected' : '' }}>Junior
                                        </option>
                                        <option value="Middle"
                                            {{ $candidate->qualification == 'Middle' ? 'selected' : '' }}>Middle
                                        </option>
                                        <option value="Senior"
                                            {{ $candidate->qualification == 'Senior' ? 'selected' : '' }}>Senior
                                        </option>
                                    </select>
                                    <span class="input-group-text">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
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
                                            Diploma 3</option>
                                        <option value="S1" {{ $candidate->education == 'S1' ? 'selected' : '' }}>
                                            Sarjana</option>
                                        <option value="S2" {{ $candidate->education == 'S2' ? 'selected' : '' }}>
                                            Magister</option>
                                        <option value="S3" {{ $candidate->education == 'S3' ? 'selected' : '' }}>
                                            Doktor</option>
                                    </select>
                                    <span class="input-group-text">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="source" class="form-label">Sumber</label>
                                <div class="input-group">
                                    <select class="form-control" id="source" name="source" disabled>
                                        <option value="LinkedIn" {{ $candidate->source == 'LinkedIn' ? 'selected' : '' }}>
                                            LinkedIn</option>
                                        <option value="GitHub" {{ $candidate->source == 'GitHub' ? 'selected' : '' }}>
                                            GitHub</option>
                                        <option value="Website" {{ $candidate->source == 'Website' ? 'selected' : '' }}>
                                            Website</option>
                                        <option value="Referral" {{ $candidate->source == 'Referral' ? 'selected' : '' }}>
                                            Referral</option>
                                        <option value="Lainnya" {{ $candidate->source == 'Lainnya' ? 'selected' : '' }}>
                                            Lainnya</option>
                                    </select>
                                    <span class="input-group-text">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="url" class="form-label">URL</label>
                                <input type="url" class="form-control" id="url" name="url"
                                    value="{{ $candidate->url }}" placeholder="Masukkan URL (LinkedIn, GitHub, dll)"
                                    disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="numberPhone" name="numberPhone"
                                    value="{{ $candidate->mobile_phone ?? '-' }}"
                                    placeholder="Masukan nomor telepon kandidat" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ktp" class="form-label">Upload KTP</label>
                                <input type="file" class="form-control" id="ktp" name="ktp" disabled
                                    accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                            <div class="mb-3">
                                <label for="kk" class="form-label">Upload KK</label>
                                <input type="file" class="form-control" id="kk" name="kk" disabled
                                    accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ijazah" class="form-label">Upload Ijazah</label>
                                <input type="file" class="form-control" id="ijazah" name="ijazah" disabled
                                    accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                            <div class="mb-3">
                                <label for="transkrip" class="form-label">Upload Transkrip Nilai</label>
                                <input type="file" class="form-control" id="transkrip" name="transkrip" disabled
                                    accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label d-block">Khusus</label>
                                <div class="p-2 d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="special_candidate"
                                            name="special_candidate" value="yes"
                                            {{ $candidate->isSpecial == 1 ? 'checked' : '' }} disabled required>
                                        <label class="form-check-label" for="special_candidate">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="special_candidate_no"
                                            name="special_candidate" value="no"
                                            {{ $candidate->isSpecial == 0 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label" for="special_candidate_no">Tidak</label>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end">
                        <a class="btn btn-secondary" href="{{ route('candidateDatabase') }}">Kembali</a>
                    </div>
                </form>
            </div>

            <!-- Kontainer riwayat -->
            <div id="container-riwayat" class="bg-white shadow rounded p-4 hidden">
                <h3 class="mb-4">Riwayat</h3>
                <p class="text-muted">Informasi riwayat kandidat</p>
                <ul>
                    <li>Riwayat 1: Data riwayat pertama</li>
                    <li>Riwayat 2: Data riwayat kedua</li>
                    <li>Riwayat 3: Data riwayat ketiga</li>
                </ul>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuDetail = document.getElementById('menu-detail');
            const menuRiwayat = document.getElementById('menu-riwayat');
            const containerDetail = document.getElementById('container-detail');
            const containerRiwayat = document.getElementById('container-riwayat');

            // Event listener untuk menu detail
            menuDetail.addEventListener('click', function(e) {
                e.preventDefault();
                containerDetail.classList.remove('hidden');
                containerRiwayat.classList.add('hidden');
                menuDetail.classList.add('active');
                menuRiwayat.classList.remove('active');
            });

            // Event listener untuk menu riwayat
            menuRiwayat.addEventListener('click', function(e) {
                e.preventDefault();
                containerRiwayat.classList.remove('hidden');
                containerDetail.classList.add('hidden');
                menuRiwayat.classList.add('active');
                menuDetail.classList.remove('active');
            });
        });
    </script>
@endsection
