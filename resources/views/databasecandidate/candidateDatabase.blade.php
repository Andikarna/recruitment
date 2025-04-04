@extends('layouts.dashboardLayouts')

@section('ADIDATA', 'Database Kandidat')

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

@section('title-content',"Database Kandidat")

@section('content')
    <div class="row bg-white p-3" style="border-radius: 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h5>Database Kandidat</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRequestModal">Tambah Kandidat</button>
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
                        <th class="text-center">{{ '' }}</th>
                        <th class="text-center">Kode Unik</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Posisi</th>
                        <th class="text-center">Kualifikasi</th>
                        <th class="text-center">Pendidikan</th>
                        <th class="text-center">Jurusan</th>
                        <th class="text-center">Pengalaman</th>
                        <th class="text-center">Status</th>
                        <th class="actions-column text-center bg-white" style="min-width: 20px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($candidate as $key => $data)
                        <tr>
                            <td class="text-center align-middle">
                                @if ($data->isFavoriteId != null)
                                    <img src="https://picsum.photos/id/{{ $data->isFavoriteId }}/200/300"
                                        alt="Profile Picture" class="rounded-circle shadow" width="40" height="40">
                                @endif
                            </td>
                            <td class="text-center align-middle">{{ $data->uniq_code }}</td>
                            <td class="text-center align-middle">{{ $data->name }}</td>
                            <td class="text-center align-middle">{{ $data->position }}</td>
                            <td class="text-center align-middle">{{ $data->qualification }}</td>
                            <td class="text-center align-middle">{{ $data->education }}</td>
                            <td class="text-center align-middle">{{ $data->major }}</td>
                            <td class="text-center align-middle">{{ $data->experience }} Tahun</td>
                            <th class="align-middle text-center">
                                <button class="btn btn-primary btn-md text-white shadow-sm"
                                    style="width: 100px; font-size: 0.875rem;">{{ $data->status }}</button>
                            </th>

                            <td class="actions-column align-middle text-center bg-white">
                                <div class="dropdown" style="position: relative;">
                                    <i class="bi bi-three-dots hover icon-behind" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                    <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton"
                                        style="position: absolute; left: -100%; min-width: 200px;">
                                        <li>
                                            <a class="dropdown-item fw-medium"
                                                href="{{ route('detailCandidate', [$data->id]) }}">
                                                <i class="bi bi-eye me-2"></i>Lihat Data
                                            </a>
                                        </li>
                                        @if ($data->isFavoriteId == $userId)
                                            <li>
                                                <a class="dropdown-item fw-medium"
                                                    href="{{ route('updateCandidate', [$data->id]) }}">
                                                    <i class="bi bi-pencil-square me-2"></i>Edit Data
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item text-danger fw-medium"
                                                    href="{{ route('unFavouriteCandidate', [$data->id]) }}">
                                                    <i class="bi bi-person-dash me-2"></i>Hapus Favourite
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item fw-medium" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#inputModal" data-id="{{ $data->id }}">
                                                    <i class="bi bi-chat-left-text me-2"></i>Masukan Wawancara
                                                </a>
                                            </li>
                                        @elseif ($data->isFavoriteId == null)
                                            <li>
                                                <a class="dropdown-item text-success fw-medium"
                                                    href="{{ route('inFavouriteCandidate', [$data->id]) }}">
                                                    <i class="bi bi-person-fill-add me-2"></i>Tandai Favourite
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a class="dropdown-item fw-medium text-primary"
                                                    href="{{ route('requestCandidate', [$data->id]) }}">
                                                    <i class="bi bi-person-down me-2"></i>Request Kandidat
                                                </a>
                                            </li>
                                        @endif

                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-12 mt-3">
            {{ $candidate->links('vendor.pagination.bootstrap-5') }}
        </div>

        {{-- Modal Wawancara --}}
        <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inputModalLabel">Masukan ke Wawancara</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('addInterview') }}" id="interviewForm">
                        @csrf
                        <div class="modal-body">
                            <input type="text" name="candidate" hidden>
                            <div class="mb-3">
                                <label for="requestName" class="form-label">Nama Permintaan</label>
                                <select class="form-select" id="requestName" name="requestName" required>
                                    <option value="" disabled selected>Pilih Resource</option>
                                    @foreach ($resource as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="position" class="form-label">Posisi</label>
                                <select class="form-select" name="position" id="position">
                                    <option value="" disabled selected>Pilih Posisi</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="addRequestModal" tabindex="-1" aria-labelledby="addRequestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="max-width: 900px;">
            <div class="modal-content" style="height: 600px; display: flex; flex-direction: column;">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRequestModalLabel">Tambah Kandidat Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" style="overflow-y: auto; flex: 1;">
                    <div class="modal-body" style="overflow-y: auto;">
                        <h4>Data Kandidat Baru</h4>
                        <p style="text-size=10px;">Masukan informasi data kandidat baru</p>
                        <form method="POST" action="{{ route('addCandidate') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Masukan nama lengkap kandidat" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="position" class="form-label">Posisi</label>
                                        <input type="text" class="form-control" id="position" name="position"
                                            placeholder="Masukan Posisi Kandidat">
                                    </div>


                                    <div class="mb-3">
                                        <label for="experience" class="form-label">Pengalaman (tahun)</label>
                                        <input type="number" class="form-control" id="experience" name="experience"
                                            placeholder="Masukan berapa lama pengalaman kandidat" min="0">
                                    </div>

                                    <div class="mb-3">
                                        <label for="major" class="form-label">Jurusan</label>
                                        <input type="text" class="form-control" id="major" name="major"
                                            placeholder="Masukan jurusan kandidat">
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Jenis Kelamin</label>
                                        <div class="input-group">
                                            <select class="form-control" id="gender" name="gender">
                                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                            <span class="input-group-text">
                                                <i class="bi bi-chevron-down"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="qualification" class="form-label">Kualifikasi</label>
                                        <div class="input-group">
                                            <select class="form-control" id="qualification" name="qualification"
                                                required>
                                                <option value="" disabled selected>Pilih Kualifikasi</option>
                                                <option value="Fresh Graduate">Fresh Graduate</option>
                                                <option value="Junior">Junior</option>
                                                <option value="Middle">Middle</option>
                                                <option value="Senior">Senior</option>
                                            </select>
                                            <span class="input-group-text">
                                                <i class="bi bi-chevron-down"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="education" class="form-label">Pendidikan</label>
                                        <div class="input-group">
                                            <select class="form-control" id="education" name="education">
                                                <option value="" disabled selected>Pilih Pendidikan</option>
                                                <option value="SD">SD</option>
                                                <option value="SMP">SMP</option>
                                                <option value="SMA">SMA</option>
                                                <option value="D3">Diploma 3</option>
                                                <option value="S1">Sarjana</option>
                                                <option value="S2">Magister</option>
                                                <option value="S3">Doktor</option>
                                            </select>
                                            <span class="input-group-text">
                                                <i class="bi bi-chevron-down"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="source" class="form-label">Sumber</label>
                                        <div class="input-group">
                                            <select class="form-control" id="source" name="source" required>
                                                <option value="" disabled selected>Pilih Sumber</option>
                                                <option value="LinkedIn">LinkedIn</option>
                                                <option value="GitHub">GitHub</option>
                                                <option value="Website">Website</option>
                                                <option value="Referral">Referral</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                            <span class="input-group-text">
                                                <i class="bi bi-chevron-down"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="url" class="form-label">URL</label>
                                        <input type="url" class="form-control" id="url" name="url"
                                            placeholder="Masukkan URL (LinkedIn, GitHub, dll)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ktp" class="form-label">Upload KTP</label>
                                        <input type="file" class="form-control" id="ktp" name="ktp"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kk" class="form-label">Upload KK</label>
                                        <input type="file" class="form-control" id="kk" name="kk"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ijazah" class="form-label">Upload Ijazah</label>
                                        <input type="file" class="form-control" id="ijazah" name="ijazah"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="mb-3">
                                        <label for="transkrip" class="form-label">Upload Transkrip Nilai</label>
                                        <input type="file" class="form-control" id="transkrip" name="transkrip"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label d-block">Khusus</label>
                                        <div class="p-2 d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="special_candidate"
                                                    name="special_candidate" value="yes" required>
                                                <label class="form-check-label" for="special_candidate">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="special_candidate_no"
                                                    name="special_candidate" value="no" required>
                                                <label class="form-check-label" for="special_candidate_no">Tidak</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
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
