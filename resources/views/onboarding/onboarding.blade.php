@extends('layouts.dashboardLayouts')

@section('ADIDATA', 'Onboarding')



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


@section('title-content', 'Onboarding')

@section('content')
    <div class="row bg-white p-3" style="border-radius: 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h5>Onboarding</h5>
        </div>

        {{-- header tabel --}}
        <div class="col-12 mt-3">
            <div class="d-flex justify-content-end align-items-center">
                <form method="GET" action="{{ route('onboarding') }}">
                    <input type="text" name="search" id="searchBox" class="form-control" placeholder="Search..."
                        style="width: 300px;" value="{{ request('search') }}" onchange="this.form.submit()">
                </form>
            </div>
        </div>

        {{-- tabel --}}
        <div class="mt-3" style="width:160vh; height: 360px; overflow: auto;">
            <table class="table table-hover">
                <thead>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Posisi</th>
                    <th class="text-center">Kualifikasi</th>
                    <th class="text-center">Proyek</th>
                    <th class="text-center">Status</th>
                    <th class="actions-column text-center bg-white" style="min-width: 20px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        use App\Models\ResourceDetail;
                    @endphp
                    @foreach ($onboarding as $key => $data)
                        <tr>
                            <td class="nowrap align-middle text-center">
                                {{ ($onboarding->currentPage() - 1) * $onboarding->perPage() + $key + 1 }}</td>
                            <td class="text-center align-middle">{{ $data->name }}</td>
                            <td class="text-center align-middle">
                                {{ $data->resourceDetail->position ?? 'Position not available' }}</td>
                            <td class="text-center align-middle">
                                {{ $data->resourceDetail->qualification ?? 'Qualification not available' }}</td>
                            <td class="text-center align-middle">{{ $data->resource->project ?? 'Project not available' }}
                            </td>
                            <td class="text-center align-middle">
                                @if ($data->status == 'Baru')
                                    <button class="btn btn-primary btn-md text-white shadow-sm"
                                        style="width: 100px; font-size: 0.875rem;">Baru</button>
                                @elseif($data->status == 'Pengecekan')
                                    <button class="btn btn-warning btn-md text-white shadow-sm"
                                        style="width: 100px; font-size: 0.875rem;">Pengecekan</button>
                                @elseif($data->status == 'Selesai')
                                    <button class="btn btn-success btn-md text-white shadow-sm"
                                        style="background-color: #155724; width: 100px; font-size: 0.875rem;">Selesai</button>
                                @else
                                    <button class="btn btn-danger btn-md text-white shadow-sm"
                                        style="width: 100px; font-size: 0.875rem;">Cancel</button>
                                @endif
                            </td>
                            <td class="actions-column align-middle text-center bg-white">
                                <div class="dropdown" style="position: relative;">
                                    <i class="bi bi-three-dots hover icon-behind" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                    <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton"
                                        style="position: absolute; left: -100%; min-width: 200px;">
                                        <li>
                                            <a class="dropdown-item fw-medium"
                                                href="{{ route('detailOnboarding', [$data->id]) }}">
                                                <i class="bi bi-eye me-2"></i>Lihat Data
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item fw-medium"
                                                href="{{ route('updateOnboarding', [$data->id]) }}">
                                                <i class="bi bi-pencil-square me-2"></i>Edit Data
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('cancelOnboarding', [$data->id]) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger fw-medium">
                                                    <i class="bi bi-x-circle me-2"></i>Cancel Onboarding
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item text-success fw-medium"
                                                style="border: none; background: none;" data-bs-toggle="modal"
                                                data-bs-target="#confirmSaveModal-{{ $data->id }}">
                                                <i class="bi bi-send me-2"></i>Send to HRM
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal for Send to HRM -->
                        <div class="modal fade" id="confirmSaveModal-{{ $data->id }}" tabindex="-1"
                            aria-labelledby="confirmSaveModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmSaveModalLabel">Konfirmasi Send To HRM</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('images/confirm.jpg') }}" alt="No Data" class="img-fluid mb-3"
                                            style="max-width: 200px; height: auto;">
                                        <p>Apakah Anda yakin ingin mengirim data ini ke HRM?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('sendHrm', [$data->id]) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Ya, Kirim</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </tbody>
            </table>



        </div>

        <div class="col-12 mt-3">
            {{ $onboarding->links('vendor.pagination.bootstrap-5') }}
        </div>


    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('special_candidate').addEventListener('change', function() {
            var specialDetails = document.getElementById('special_details');
            if (this.checked) {
                specialDetails.style.display = 'block';
            } else {
                specialDetails.style.display = 'none';
            }
        });
    </script>

    <script>
        document.getElementById('requestName').addEventListener('change', function() {
            const resourceId = this.value;
            const positionSelect = document.getElementById('position');

            positionSelect.innerHTML = '<option value="" disabled selected>Pilih Posisi</option>';

            fetch('{{ route('getPositions') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        resource_id: resourceId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Populate the position dropdown
                    for (const [id, position] of Object.entries(data)) {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = position;
                        positionSelect.appendChild(option);
                    }
                })
                .catch(error => console.error('Error fetching positions:', error));
        });

        document.addEventListener('DOMContentLoaded', function() {
            const inputModal = document.getElementById('inputModal');
            const candidateNameInput = inputModal.querySelector('input[name="candidate"]');

            document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(trigger) {
                trigger.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    if (candidateNameInput) {
                        candidateNameInput.value = id;
                    }
                });
            });
        });
    </script>
@endsection


@section('ADIDATA', 'Onboarding')

@section('username', Auth::user()->name)
@section('userid', Auth::user()->id)


@section('content')

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@endsection
