<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="antialiased">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6" id="app">
                <!-- Asegúrate de usar kebab-case para el nombre del componente -->
                <notas-component
                    title="Mi Nota"
                    description="Esta es la descripción de la nota."
                    creation-date="2024-09-30"
                    user="Juan Pérez"
                    :tags="['trabajo', 'importante']"
                    expiration-date="2024-10-05"
                    image="https://via.placeholder.com/150"
                />
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
