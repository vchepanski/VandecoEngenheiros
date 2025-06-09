<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tasks • Laravel Productivity</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-light">

    <nav class="mb-4 navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('tasks.index') }}">
                <i class="fa-solid fa-list-check me-2"></i> My Tasks
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    {{-- Adicione novos links aqui no futuro --}}
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <footer class="mt-5 mb-3 text-center text-muted">
        &copy; {{ date('Y') }} - My Personal Task Manager
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
