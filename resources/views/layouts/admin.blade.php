<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Admin Panel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fc;
            overflow-x: hidden;
        }
        #wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
            min-height: 100vh;
        }
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #fff;
            color: #333;
            transition: all 0.3s;
            border-right: 1px solid #e3e6f0;
        }
        #sidebar .sidebar-brand {
            height: 4.375rem;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: 800;
            padding: 1.5rem 1rem;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: .05rem;
            color: #4e73df;
            display: block;
        }
        #sidebar ul.components {
            padding: 20px 0;
            border-bottom: 1px solid #e3e6f0;
        }
        #sidebar ul li a {
            padding: 15px 20px;
            font-size: 0.95rem;
            display: block;
            color: #6e707e;
            text-decoration: none;
            font-weight: 600;
        }
        #sidebar ul li a:hover {
            color: #2e59d9;
            background: #f8f9fc;
            text-decoration: none;
        }
        #sidebar ul li.active > a {
            color: #4e73df;
            background: #f1f3fd;
            border-left: 4px solid #4e73df;
        }
        #sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        #content-wrapper {
            width: 100%;
            display: flex;
            flex-direction: column;
        }
        #content {
            flex: 1 0 auto;
            padding: 20px;
        }
        .topbar {
            height: 4.375rem;
            background-color: #fff;
            box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            margin-bottom: 1.5rem;
        }
        .img-profile {
            height: 2rem;
            width: 2rem;
            border-radius: 50%;
            object-fit: cover;
        }
        /* Fix table responsive di mobile */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }
            #sidebar.active {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<div id="wrapper">

    <nav id="sidebar">
        <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
            Admin Panel
        </a>

        <ul class="list-unstyled components">
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i> Dashboard
                </a>
            </li>

            <li class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                <a href="{{ route('admin.orders') }}">
                    <i class="fas fa-fw fa-shopping-cart"></i> Kelola Pesanan
                </a>
            </li>

            <li class="{{ request()->routeIs('admin.menus*') ? 'active' : '' }}">
                <a href="{{ route('admin.menus') }}">
                    <i class="fas fa-fw fa-utensils"></i> Daftar Menu
                </a>
            </li>

            <li class="{{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                <a href="{{ route('admin.reviews.index') }}">
                    <i class="fas fa-fw fa-star"></i> Ulasan / Rating
                </a>
            </li>
        </ul>
    </nav>

    <div id="content-wrapper">
        
        <nav class="topbar">
            <button type="button" id="sidebarCollapse" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <h5 class="m-0 font-weight-bold text-primary">@yield('title', 'Admin Dashboard')</h5>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown no-arrow d-flex align-items-center gap-2">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Halo, {{ Auth::user()->name }}</span>
                    @if(Auth::user()->avatar)
                        <img class="img-profile" src="{{ asset('storage/' . Auth::user()->avatar) }}">
                    @else
                        <img class="img-profile" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random">
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" class="ml-2">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Keluar">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <div id="content">
            @yield('content')
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Script sederhana untuk toggle sidebar di mobile
    document.getElementById('sidebarCollapse')?.addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('active');
    });
</script>

</body>
</html>