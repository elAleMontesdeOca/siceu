<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'SICEU') }}</title>
  @vite('resources/css/app.css')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const btn = document.getElementById('menu-toggle');
      const sidebar = document.getElementById('sidebar');
      btn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
      });
    });
  </script>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 flex">

  {{-- Sidebar --}}
  <aside id="sidebar"
    class="fixed lg:static top-0 left-0 h-full w-64 bg-siceu-500 text-white flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40">
    
    {{-- Encabezado --}}
    <div class="p-4 flex items-center gap-3 border-b border-siceu-400/30">
      <img src="{{ asset('img/logosiceu.png') }}" alt="logo" class="w-10 h-10 rounded-full">
      <h1 class="text-lg font-bold">SICEU</h1>
    </div>

    {{-- Navegación lateral --}}
    <nav class="flex-1 px-4 py-3 space-y-2 overflow-y-auto">
      {{-- Dashboard --}}
      <a href="/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-siceu-400/30 {{ request()->is('dashboard') ? 'bg-siceu-400/50' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h8V3H3v10zm10 8h8v-6h-8v6zM3 21h8v-6H3v6zm10-8h8V3h-8v10z"/>
        </svg>
        Dashboard
      </a>

      {{-- Eventos --}}
      <a href="/eventos" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-siceu-400/30 {{ request()->is('eventos') ? 'bg-siceu-400/50' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M4 11h16M5 19h14a2 2 0 002-2V7H3v10a2 2 0 002 2z"/>
        </svg>
        Eventos
      </a>

      {{-- Usuarios --}}
      <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-siceu-400/30">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V9H2v11h5M12 12a4 4 0 100-8 4 4 0 000 8z"/>
        </svg>
        Usuarios
      </a>

      {{-- Notificaciones --}}
      <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-siceu-400/30">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        Notificaciones
      </a>
    </nav>

    {{-- Pie del sidebar --}}
    <div class="p-4 border-t border-siceu-400/30 text-sm">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="w-full flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-siceu-400/30">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m4-10V5a2 2 0 10-4 0v1"/>
          </svg>
          Cerrar sesión
        </button>
      </form>
    </div>
  </aside>

  {{-- Contenido principal --}}
  <div class="flex-1 flex flex-col min-h-screen lg:ml-0">
    
    {{-- Navbar superior --}}
    <header class="bg-white border-b border-slate-200 p-4 flex justify-between items-center sticky top-0 z-30">
      {{-- Botón menú móvil --}}
      <button id="menu-toggle" class="lg:hidden bg-siceu-500 text-white p-2 rounded-md hover:bg-siceu-400 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>

      <h2 class="text-xl font-semibold">@yield('title', 'Panel')</h2>

      {{-- Usuario --}}
      <div class="flex items-center gap-3">
        <span class="hidden sm:block text-slate-600">{{ Auth::user()->name ?? 'Invitado' }}</span>
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'U') }}&background=0B5FFF&color=fff"
             class="w-9 h-9 rounded-full border-2 border-siceu-400" alt="avatar">
      </div>
    </header>

    {{-- Contenido dinámico --}}
    <main class="flex-1 p-6">
      @yield('content')
    </main>
  </div>

</body>
</html>
