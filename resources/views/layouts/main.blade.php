<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Fitlife.id</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    {{-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet"> --}}
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])



    {{-- Tambahkan vite --}}

    <style>
        :root {
            --fitlife-primary: #1fb879;
            --fitlife-primary-dark: #0da36b;
            --fitlife-accent: #f4fdf8;
            --fitlife-text: #1c2c3a;
            --fitlife-muted: #6c7d86;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f6f4;
            color: var(--fitlife-text);
            margin: 0;
        }

        a {
            text-decoration: none;
        }

        .btn-fitlife {
            background: var(--fitlife-primary);
            color: #fff;
            border-radius: 999px;
            font-weight: 600;
            padding: 10px 20px;
            border: none;
            transition: all .2s ease;
        }

        .btn-fitlife:hover {
            background: var(--fitlife-primary-dark);
            color: #fff;
            box-shadow: 0 8px 20px rgba(31, 184, 121, 0.28);
            transform: translateY(-1px);
        }
    </style>
</head>

<body>
    @include('menu.nav')

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>
    <script>
        $('.summernote').summernote({
            placeholder: 'Tulis deskripsi menu di sini...',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    </script>



</body>



</html>
