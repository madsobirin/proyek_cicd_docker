<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin | FitLife.id</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            width: 230px;
            height: 100vh;
            background: #f2f8f6;
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: .3s;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #4CAF50;
            color: #fff;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .sidebar a.logout-link {
            color: #dc3545 !important;
            transition: all 0.25s ease;
        }

        .sidebar a.logout-link i {
            color: #dc3545 !important;
            transition: all 0.25s ease;
        }

        .sidebar a.logout-link:hover,
        .sidebar a.logout-link:active {
            background-color: #f8d7da !important;
            color: #b02a37 !important;
        }

        .sidebar a.logout-link:hover i,
        .sidebar a.logout-link:active i {
            color: #b02a37 !important;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <a class="navbar-brand d-flex align-items-center fw-bold" href="#" style="color:#1fb879;">
            <img src="{{ asset('images/logo.png') }}" alt="FitLife Logo" class="me-2"
                style="width:36px; height:36px; object-fit:contain;">
            FitLife.id
        </a>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> Dashboard
        </a>

        <a href="{{ route('admin.menu.index') }}" class="{{ request()->is('admin/menu*') ? 'active' : '' }}">
            <i class="bi bi-egg-fried"></i> Menu Sehat
        </a>

        <a href="{{ route('admin.artikel.index') }}" class="{{ request()->is('admin/artikel*') ? 'active' : '' }}">
            <i class="bi bi-newspaper"></i> Artikel
        </a>

        <a href="{{ route('admin.users.index') }}" class="{{ request()->is('admin/users*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Pengguna
        </a>

        <a href="#" class="logout-link d-flex align-items-center px-3 py-2 rounded mb-2"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right me-2"></i>
            <span>Log Out</span>
        </a>

        {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form> --}}

    </div>

</body>

</html>
