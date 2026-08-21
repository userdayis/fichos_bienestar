<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Día del Aprendiz - SENA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans flex items-center justify-center min-h-screen relative">
    <div class="absolute top-0 w-full bg-sena h-3 shadow-md"></div>
    @yield('content')
</body>
</html>
