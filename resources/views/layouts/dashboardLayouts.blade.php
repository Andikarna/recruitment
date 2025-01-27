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
        .noactive{
          color: white
        }

        .nav-link.active {
            background-color: #343a40;
            color: #0D92F4 !;
            font-weight: bold;
            border-radius: 20px
        }

        .nav-link:hover,
        .nav-link:focus {
            color: #0D92F4;
            /* Ensure hover text color stays white */
        };

    </style>
    @yield('styles')
    
</head>

<body>
    <div class="d-flex bg-light">
        <div class="bg-dark text-white p-3 pt-5" style="width: 250px; height: 100vh; position: fixed;">
            {{-- logo adidata --}}
            <div class="mb-4 text-center">
                <img src="{{ asset('images/adidata.png') }}" alt="Adidata" style="width: 150px; height: auto;">
            </div>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active' : 'noactive' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-bar-chart-fill"></i>
                        <span class="ms-2">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('requester') ? 'active' : 'noactive' }}" href="{{ route('requester') }}">
                        <i class="bi bi-people-fill"></i>
                        <span class="ms-2">Permintaan SDM</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('tasklist') ? 'active' : 'noactive' }}" href="{{ route('tasklist') }}">
                        <i class="bi bi-list-check"></i>
                        <span class="ms-2">Daftar Tugas</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('candidateDatabase') ? 'active' : 'noactive' }}" 
                       href="{{ route('candidateDatabase') }}">
                        <i class="bi bi-database"></i>
                        <span class="ms-2">Database Kandidat</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('interview') ? 'active' : 'noactive' }}" href="{{ route('interview') }}">
                        <i class="bi bi-chat-left-text"></i>
                        <span class="ms-2">Wawancara</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('offering') ? 'active' : 'noactive' }}" href="{{ route('offering') }}">
                        <i class="bi bi-clipboard-data-fill"></i>
                        <span class="ms-2">Offering</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('onboarding') ? 'active' : 'noactive' }}" href="{{ route('onboarding') }}">
                        <i class="bi bi-calendar-event-fill"></i>
                        <span class="ms-2">Onboarding</span>
                    </a>
                </li>
            </ul>

        </div>

        <div class="container-fluid p-3 pt-3" style="margin-left: 300px; margin-right: 100px; min-height: 100vh;">

            <div class="row mb-4 bg-white shadow-sm rounded-lg p-2">
                <div class="col-md-12 d-flex justify-content-end align-items-center">

                    {{-- notifications --}}
                    <div class="dropdown me-3">
                        <button class="btn btn-link position-relative" type="button" id="notificationDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell-fill" style="font-size: 24px;"></i>
                            <span
                                class="position-absolute top-0 mt-2 start-60 translate-middle badge rounded-pill bg-danger">
                                3
                                <span class="visually-hidden">unread notifications</span>
                            </span>
                        </button>

                        <!-- Notification Dropdown Menu -->
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-envelope me-2"></i>New Message
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person-plus me-2"></i>New Follower
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-calendar-check me-2"></i>Event Reminder
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-center" href="#">View All</a>
                            </li>
                        </ul>
                    </div>

                    {{-- username --}}
                    <div class="me-2">
                        <h4 class="m-0 d-flex justify-content-end align-items-center">@yield('username')</h4>
                        <p class="text-muted m-0">Software Engineer</p>
                    </div>

                    {{-- photo --}}
                    <div class="">
                        <img src="https://picsum.photos/id/@yield('userid')/200/300" alt="Profile Picture"
                            class="rounded-circle" width="50" height="50">
                    </div>

                    {{-- settings --}}
                    <div class="dropdown">
                        <button class="btn btn-link" type="button" id="profileDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-gear-fill" style="font-size: 30px;"></i>
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
