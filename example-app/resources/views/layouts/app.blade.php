<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Ciudades</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css">
    <link rel="stylesheet" href='./css/app.css'>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="app min-h-screen flex flex-col justify-center items-center">
        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>
