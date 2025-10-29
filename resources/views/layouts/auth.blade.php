<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'SICEU' }}</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-siceu-500/10 flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-lg rounded-2xl w-full max-w-md p-8">
    <div class="text-center mb-6">
      <h1 class="text-2xl font-bold text-siceu-500">🎓 SICEU</h1>
      <p class="text-slate-500">{{ $subtitle ?? 'Bienvenido' }}</p>
    </div>
    @yield('content')
  </div>
</body>
</html>
