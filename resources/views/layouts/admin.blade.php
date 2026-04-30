<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Admin | FitLife.id')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 230px;
            height: 100vh;
            background: #f2f8f6;
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px;
            overflow-y: auto;
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
            margin-left: 230px;
            /* pas dengan width sidebar */
            padding: 20px;
            background: #ffffff;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>

    @stack('head')
</head>

<body>

    @include('layouts.sidebar')

    <main class="content">
        @yield('content')
    </main>

</body>

</html>