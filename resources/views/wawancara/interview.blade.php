@extends('layouts.dashboardLayouts')

@section('ADIDATA', 'Interview')

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

@section('content')
    <div class="row bg-white p-3" style="border-radius: 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h5>Wawancara</h5>
        </div>

        {{-- header tabel --}}
        <div class="col-12 mt-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <select class="form-select" id="filterOption" style="width: 200px;">
                        <option value="">Filter by...</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                    </select>
                </div>
                <div>
                    <input type="text" id="searchBox" class="form-control" placeholder="Search..." style="width: 300px;">
                </div>
            </div>
        </div>

        {{-- tabel --}}
        <div class="mt-3" style="width:160vh; height: 360px; overflow: auto;">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="nowrap">No</th>
                        <th class="nowrap">Nama</th>
                        <th class="nowrap">Posisi</th>
                        <th class="nowrap">Kualifikasi</th>
                        <th class="nowrap">Proyek</th>
                        <th class="nowrap">Jenis Wawancara</th>
                        <th class="nowrap">Tanggal</th>
                        <th class="nowrap text-center">Status</th>
                        <th class="actions-column text-center bg-white" style="min-width: 20px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($interview as $key => $data)
                        <tr>
                            <td class="nowrap align-middle text-center">
                                {{ ($interview->currentPage() - 1) * $interview->perPage() + $key + 1 }}</td>
                            <td class="nowrap align-middle ">{{ $data->name }}</td>
                            <td class="nowrap align-middle">{{ $data->position }}</td>
                            <td class="nowrap align-middle">{{ $data->qualification }}</td>
                            <td class="align-middle"
                                style="max-width: 200px; break-word; word-wrap: break-word; white-space: normal;">
                                {{ $data->project }}
                            </td>
                            <td class="nowrap align-middle">{{ $data->interview_progress ?: '-' }}</td>
                            <td class="nowrap align-middle">
                                {{ $data->interview_date ? \Carbon\Carbon::parse($data->interview_date)->format('Y-m-d') : '-' }}
                            </td>
                            <th class="align-middle text-center">
                                @if ($data->status == 'Baru')
                                    <button class="btn btn-primary btn-md text-white shadow-sm"
                                        style="width: 100px; font-size: 0.875rem;">Baru</button>
                                @elseif($data->status == 'Penugasan')
                                    <button class="btn btn-warning btn-md text-white shadow-sm"
                                        style="width: 100px; font-size: 0.875rem;">Penugasan</button>
                                @elseif($data->status == 'Diproses')
                                    <button class="btn btn-warning btn-md text-white shadow-sm"
                                        style="width: 100px; font-size: 0.875rem;">Diproses</button>
                                @elseif($data->status == 'Selesai')
                                    <button class="btn btn-success btn-md text-white shadow-sm"
                                        style="width: 100px; font-size: 0.875rem;">Selesai</button>
                                @else
                                    <button class="btn btn-secondary btn-md text-white shadow-sm"
                                        style="width: 100px; font-size: 0.875rem;">Unknown</button>
                                @endif
                            </th>

                            <td class="actions-column align-middle text-center bg-white">
                                <div class="dropdown" style="position: relative;">
                                    <i class="bi bi-three-dots hover icon-behind" 
                                        id="dropdownMenuButton" 
                                        data-bs-toggle="dropdown" 
                                        aria-expanded="false" 
                                        style="cursor: pointer;"></i>
                                    <ul class="dropdown-menu" 
                                        aria-labelledby="dropdownMenuButton" 
                                        style="position: absolute; left: -100%; min-width: 200px;">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('detailInterview', [$data->id]) }}">
                                                <i class="bi bi-eye me-2"></i>Lihat data detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('updateInterview', [$data->id]) }}">
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
            {{ $interview->links('vendor.pagination.bootstrap-5') }}
        </div>


    </div>


@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
