<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('ADIDATA')</title>
    <link rel="icon" href="{{ asset('images/adidata.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    @yield('links')

    <style>
        .noactive {
            color: white
        }

        .nav-link.active {
            background-color: #343a40;
            color: #3674B5 !;
            font-weight: bold;
            border-radius: 20px
        }

        .nav-link:hover,
        .nav-link:focus {
            color: #578FCA;
        }

        .dropdown-menu {
            max-height: 300px;
            overflow-y: auto;
        }

        .unread-notification {
            background-color: #f8f9fa;
            /* Warna latar untuk notifikasi belum dibaca */
            font-weight: bold;
            /* Teks lebih tebal untuk membedakan */
        }

        .unread-notification:hover {
            background-color: #e9ecef;
            /* Warna hover */
        }


        ;
    </style>
    @yield('styles')

</head>

@php
    use App\Models\User;
    use App\Models\UserManagement;
    use App\Models\Notifications;
    use Carbon\Carbon;

    $notification = Notifications::where('user_id', Auth::user()->id)
        ->where('type', 'Notification')
        ->where('status', 'Baru')
        ->where('created_date', '>=', Carbon::Now('Asia/Jakarta')->subDays(7))
        ->orderByDesc('created_date')
        ->get();

    $notificationRequest = Notifications::where('user_id', Auth::user()->id)
        ->where('type', 'Request')
        ->where('status', 'Baru')
        ->where('created_date', '>=', Carbon::Now('Asia/Jakarta')->subDays(7))
        ->orderByDesc('created_date')
        ->get();

    $countNotification = Notifications::where('user_id', Auth::user()->id)
        ->where('status', 'Baru')
        ->where('isRead', false)
        ->where('created_date', '>=', Carbon::Now('Asia/Jakarta')->subDays(7))
        ->get()
        ->count();
@endphp

<body>
    <div class="d-flex bg-light">
        <div class="bg-dark text-white p-3 pt-5" style="width: 250px; height: 100vh; position: fixed;">
            {{-- logo adidata --}}
            <div class="mb-4 text-center">
                <img src="{{ asset('images/adidata.png') }}" alt="Adidata" style="width: 150px; height: auto;">
            </div>

            <div class="bg-danger text-center pt-2 pr-6 pb-2 rounded">
                <p class="mb-0 text-md text-lg">Rekrutmen</p>
            </div>

            <ul class="nav flex-column" style="margin-top: 20px">


                @if (UserManagement::where('role_id', auth()->user()->role_id)->where('menu_id', 1)->exists())
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active' : 'noactive' }}"
                            href="{{ route('dashboard') }}">
                            <i class="bi bi-bar-chart-fill"></i>
                            <span class="ms-2">Dashboard</span>
                        </a>
                    </li>
                @endif

                @if (UserManagement::where('role_id', auth()->user()->role_id)->where('menu_id', 2)->exists())
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('dashboardmanagement') ? 'active' : 'noactive' }}"
                            href="{{ route('dashboardmanagement') }}">
                            <i class="bi bi-bar-chart-fill"></i>
                            <span class="ms-2">Dashboard</span>
                        </a>
                    </li>
                @endif

                @if (UserManagement::where('role_id', auth()->user()->role_id)->where('menu_id', 3)->exists())
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('dashboardrecruiter') ? 'active' : 'noactive' }}"
                            href="{{ route('dashboardrecruiter') }}">
                            <i class="bi bi-bar-chart-fill"></i>
                            <span class="ms-2">Dashboard</span>
                        </a>
                    </li>
                @endif

                @if (UserManagement::where('role_id', auth()->user()->role_id)->where('menu_id', 4)->exists())
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('requester') ? 'active' : 'noactive' }}"
                            href="{{ route('requester') }}">
                            <i class="bi bi-people-fill"></i>
                            <span class="ms-2">Permintaan SDM</span>
                        </a>
                    </li>
                @endif

                @if (UserManagement::where('role_id', auth()->user()->role_id)->where('menu_id', 5)->exists())
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('tasklist') ? 'active' : 'noactive' }}"
                            href="{{ route('tasklist') }}">
                            <i class="bi bi-list-check"></i>
                            <span class="ms-2">Daftar Tugas</span>
                        </a>
                    </li>
                @endif

                @if (UserManagement::where('role_id', auth()->user()->role_id)->where('menu_id', 6)->exists())
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('globalCandidate') ? 'active' : 'noactive' }}"
                            href="{{ route('globalCandidate') }}">
                            <i class="bi bi-globe"></i>
                            <span class="ms-2">Global Kandidat</span>
                        </a>
                    </li>
                @endif

                @if (UserManagement::where('role_id', auth()->user()->role_id)->where('menu_id', 6)->exists())
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('candidateDatabase') ? 'active' : 'noactive' }}"
                            href="{{ route('candidateDatabase') }}">
                            <i class="bi bi-database"></i>
                            <span class="ms-2">Database Kandidat</span>
                        </a>
                    </li>
                @endif

                @if (UserManagement::where('role_id', auth()->user()->role_id)->where('menu_id', 7)->exists())
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('interview') ? 'active' : 'noactive' }}"
                            href="{{ route('interview') }}">
                            <i class="bi bi-chat-left-text"></i>
                            <span class="ms-2">Wawancara</span>
                        </a>
                    </li>
                @endif

                @if (UserManagement::where('role_id', auth()->user()->role_id)->where('menu_id', 8)->exists())
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('offering') ? 'active' : 'noactive' }}"
                            href="{{ route('offering') }}">
                            <i class="bi bi-clipboard-data-fill"></i>
                            <span class="ms-2">Offering</span>
                        </a>
                    </li>
                @endif

                @if (UserManagement::where('role_id', auth()->user()->role_id)->where('menu_id', 10)->exists())
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('offeringManagement') ? 'active' : 'noactive' }}"
                            href="{{ route('offeringManagement') }}">
                            <i class="bi bi-clipboard-data-fill"></i>
                            <span class="ms-2">Offering Approval</span>
                        </a>
                    </li>
                @endif

                @if (UserManagement::where('role_id', auth()->user()->role_id)->where('menu_id', 9)->exists())
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('onboarding') ? 'active' : 'noactive' }}"
                            href="{{ route('onboarding') }}">
                            <i class="bi bi-calendar-event-fill"></i>
                            <span class="ms-2">Onboarding</span>
                        </a>
                    </li>
                @endif

            </ul>

        </div>

        <div class="container-fluid p-3 pt-3" style="margin-left: 300px; margin-right: 100px; min-height: 100vh;">

            <div class="row mb-4 bg-white shadow-sm rounded-lg p-2">
                <div class="col-md-6 d-flex justify-content-start align-items-center">
                    <h5 class="text-muted">@yield('title-content')</h5>
                </div>

                <div class="col-md-6 d-flex justify-content-end align-items-center">

                    {{-- notifications --}}
                    <div class="dropdown me-3">
                        <button class="btn btn-link position-relative" type="button" id="notificationDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false" style="color: #578FCA">
                            <i class="bi bi-bell-fill" style="font-size: 20px;"></i>
                            @if ($countNotification >= 1)
                                <span
                                    class="position-absolute top-0 mt-2 start-60 translate-middle badge rounded-pill bg-danger">
                                    {{ $countNotification }}
                                    <span class="visually-hidden">unread notifications</span>
                                </span>
                            @endif
                        </button>

                        <!-- Notification Dropdown Menu -->
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="notificationDropdown">
                            <!-- Information Notifications -->
                            @if ($notification->count() + $notificationRequest->count() >= 1)
                                <li>
                                    @if ($notification->isNotEmpty())
                                        <h6 class="dropdown-header">Informasi</h6>
                                        @foreach ($notification as $data)
                                            @if ($data->title == 'Permintaan SDM')
                                                <a href="{{ route('updateRequester', [$data->action_id]) }}"
                                                    class="dropdown-item d-flex align-items-start @if (!$data->isRead) unread-notification @endif">
                                                @elseif ($data->title == 'General' || $data->title == 'Request Kandidat')
                                                    <a
                                                        class="dropdown-item d-flex align-items-start @if (!$data->isRead) unread-notification @endif">
                                                    @elseif ($data->title == 'TaskList')
                                                        <a href="{{ route('candidateDatabase') }}"
                                                            class="dropdown-item d-flex align-items-start @if (!$data->isRead) unread-notification @endif">
                                                        @elseif ($data->title == 'Interview')
                                                            <a href="{{ route('updateInterview', [$data->action_id]) }}"
                                                                class="dropdown-item d-flex align-items-start @if (!$data->isRead) unread-notification @endif">
                                                            @elseif ($data->title == 'Offering')
                                                                <a href="{{ route('updateOffering', [$data->action_id]) }}"
                                                                    class="dropdown-item d-flex align-items-start @if (!$data->isRead) unread-notification @endif">
                                                                @elseif ($data->title == 'Offering Management')
                                                                    <a href="{{ route('updateOfferingManagement', [$data->action_id]) }}"
                                                                        class="dropdown-item d-flex align-items-start @if (!$data->isRead) unread-notification @endif">
                                                @endif
                                            <div class="me-3">
                                                @if (
                                                    $data->title == 'Permintaan SDM' ||
                                                        $data->title == 'Offering' ||
                                                        $data->title == 'TaskList' ||
                                                        $data->title == 'General' ||
                                                        $data->title == 'Offering Management' ||
                                                        $data->title == 'Request Kandidat')
                                                    <i class="bi bi-envelope fs-5 text-primary"></i>
                                                @elseif ($data->title == 'Interview')
                                                    <i class="bi bi-calendar-check fs-5 text-success"></i>
                                                @endif
                                            </div>
                                            <div>
                                                @if (
                                                    $data->title == 'Permintaan SDM' ||
                                                        $data->title == 'TaskList' ||
                                                        $data->title == 'General' ||
                                                        $data->title == 'Request Kandidat' ||
                                                        $data->title == 'Offering Management' ||
                                                        $data->title == 'Offering')
                                                    <p class="mb-0 fw-bold">{{ $data->title }}</p>
                                                    <small class="text-muted">{{ $data->description }}</small>
                                                @elseif ($data->title == 'Interview')
                                                    <p class="mb-0 fw-bold">{{ $data->title }}</p>
                                                    <small class="text-muted">{{ $data->description }}</small>
                                                @endif
                                            </div>
                                            </a>
                                        @endforeach
                                    @endif
                                </li>

                                <hr class="dropdown-divider">
                                <li>
                                    @if ($notificationRequest->isNotEmpty())
                                        <h6 class="dropdown-header">Permintaan</h6>
                                        @foreach ($notificationRequest as $data)
                                            <div
                                                class="dropdown-item d-flex align-items-start justify-content-between">
                                                <div class="me-3">
                                                    @if ($data->title == 'Request Kandidat')
                                                        <i class="bi bi-person-check fs-5 text-success"></i>
                                                    @elseif ($data->title == 'Global Kandidat')
                                                        <i class="bi bi-people fs-5 text-warning"></i>
                                                    @endif

                                                </div>
                                                <div class="me-3">
                                                    <p class="mb-0 fw-bold">{{ $data->title }}</p>
                                                    <small class="text-muted">{{ $data->description }}</small>
                                                </div>

                                                <div class="ms-auto d-flex gap-2 align-middle text-center">
                                                    <form id="accept"
                                                        action="{{ route('acceptNotification', [$data->action_id]) }}"
                                                        method="POST">
                                                        @method('put')
                                                        @csrf
                                                        <button type="submit" form="accept"
                                                            class="btn btn-sm btn-success">Terima</button>
                                                    </form>
                                                    <form id="reject"
                                                        action="{{ route('rejectNotification', [$data->action_id]) }}"
                                                        method="POST">
                                                        @method('put')
                                                        @csrf
                                                        <button class="btn btn-sm btn-danger">Tolak</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </li>

                                <hr class="dropdown-divider">

                                <!-- View All Notifications -->
                                @if ($countNotification >= 1)
                                    <li>
                                        <form id="readAll" action="{{ route('readAllNotification') }}"
                                            method="POST">
                                            @method('put')
                                            @csrf
                                            <button type="submit" form="readAll"
                                                class="dropdown-item text-end text-primary"
                                                style="font-size: 14px">Baca
                                                Semua
                                                Notifikasi</button>
                                        </form>

                                    </li>
                                @endif
                            @else
                                <div class="dropdown-item d-flex align-items-start">
                                    <div>
                                        <p class="mb-0 p-2 fw-medium d-flex text-center"
                                            style="font-size: 12px; color: #818C78;">
                                            Tidak ada notifikasi hari ini</p>
                                    </div>
                                </div>

                                <li>
                                    <a class="dropdown-item text-end text-primary" style="font-size: 12px"
                                        href="#">Lihat Semua Notifikasi</a>
                                </li>
                            @endif

                        </ul>
                    </div>

                    {{-- username --}}
                    <div class="me-2">
                        <p class="m-0 d-flex justify-content-end fs-6 align-items-center">@yield('username')</p>
                        <p class="text-muted m-0" style="font-size: smaller">{{ Auth::user()->role->name_role }}</p>
                    </div>

                    {{-- photo --}}
                    <div class="">
                        <img src="https://picsum.photos/id/@yield('userid')/200/300" alt="Profile Picture"
                            class="rounded-circle" width="40" height="40">
                    </div>

                    {{-- settings --}}
                    <div class="dropdown">
                        <button class="btn btn-link" type="button" id="profileDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-gear-fill shadow-md shadow-black"
                                style="font-size: 20px; color: #578FCA;"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person-circle me-2"></i>Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href=""
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            @yield('content')
        </div>

    </div>

    @yield('scripts') <!-- Optional Section for Scripts -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>


</body>

</html>
