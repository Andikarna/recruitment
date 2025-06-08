@extends('layouts.dashboardLayouts')

@section('ADIDATA', 'Daftar Tugas')

@section('username', Auth::user()->name)
@section('userid', Auth::user()->id)

@section('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
        }
    </style>
@endsection

@section('title-content',"Daftar Tugas")


@section('content')
    <div class="row bg-white p-3" style="border-radius: 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h5>Daftar Tugas</h5>
        </div>

        {{-- header tabel --}}
        <div class="col-12 mt-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-12 mt-3">
                    <div class="d-flex justify-content-end align-items-center">
                        <form method="GET" action="{{ route('tasklist') }}">
                            <input type="text" name="search" id="searchBox" class="form-control" placeholder="Search..."
                                style="width: 300px;" value="{{ request('search') }}" onchange="this.form.submit()">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- tabel --}}
        <div class="mt-3" style="width:160vh; height: 360px; overflow: auto;">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Permintaan</th>
                        <th class="text-center">Peminta</th>
                        <th class="text-center">Klien</th>
                        <th class="text-center">Proyek</th>
                        <th class="text-center">Jumlah Permintaan</th>
                        <th class="text-center">Deadline</th>
                        <th class="text-center">Status</th>
                        <th class="actions-column text-center bg-white" style="min-width: 20px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasklist as $key => $data)
                        <tr>
                            <td class="text-center align-middle text-center">
                                {{ ($tasklist->currentPage() - 1) * $tasklist->perPage() + $key + 1 }}</td>
                            <td class="align-middle ">{{ $data->resource->name ?? "" }}</td>
                            <td class="text-center align-middle text-center">{{ $data->resource->created_by ?? ""  }}</td>
                            <td class="text-center align-middle text-wrap">{{ $data->resource->client ?? "" }}</td>
                            <td class="align-middle"
                                style="max-width: 200px; break-word; word-wrap: break-word; white-space: normal;">
                                {{ $data->resource->project ?? "" }}
                            </td>
                            <td class="text-center align-middle text-center">{{ $data->resource_detail->quantity ?? "" }}</td>
                            <td class="text-center align-middle text-center">
                                {{ optional($data->resource->target_date ?? "")->format('d M y') ?: '-' }}</td>
                            <th class="align-middle text-center">
                                @if ($data->status == 'Baru')
                                    <button class="btn btn-primary btn-md text-white shadow-sm"
                                        style="width: 100px; font-size: 0.875rem;">Baru</button>
                                @elseif($data->status == 'Penugasan')
                                    <button class="btn btn-warning btn-md text-white shadow-sm"
                                        style="width: 100px; font-size: 0.875rem;">Penugasan</button>
                                @elseif($data->status == 'Diproses' && $data->resource_detail?->quantity == $data->resource_detail?->fulfilled)
                                    <button class="btn btn-success btn-md text-white shadow-sm"
                                        style="background-color: #155724; width: 100px; font-size: 0.875rem;">Selesai</button>
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
                                    <i class="bi bi-three-dots hover icon-behind" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                        style="position: absolute; left: -100%; min-width: 200px;">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('detailRequester', [$data->resource->id]) }}">
                                                <i class="bi bi-eye me-2"></i>Lihat data detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('globalCandidate') }}">
                                                <i class="bi bi-search me-2"></i>Cari Kandidat
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
            {{ $tasklist->links('vendor.pagination.bootstrap-5') }}
        </div>


    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@endsection
