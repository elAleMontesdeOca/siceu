<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SICEU — Sistema Integral de Control de Eventos Universitarios</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/scrollreveal"></script>
    <style>
        .hero-bg {
            background-image: url('{{ asset('img/bg-campus.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s ease;
        }
        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-white text-slate-800 overflow-x-hidden">

    {{-- NAVBAR SUPERIOR --}}
    <header class="fixed top-0 left-0 w-full bg-white/90 backdrop-blur-md shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logosiceu.png') }}" alt="Logo" class="w-12 h-12">
                <h1 class="text-2xl font-bold text-siceu-500">SICEU</h1>
            </div>
            <nav class="hidden md:flex gap-6 text-slate-700 font-medium">
                <a href="/" class="hover:text-siceu-500 transition">Inicio</a>
                <a href="/eventos" class="hover:text-siceu-500 transition">Eventos</a>
                
                <a href="{{ route('login') }}" class="bg-siceu-500 text-white px-4 py-2 rounded-lg hover:bg-siceu-400 transition">Iniciar Sesión</a>
            </nav>
            <button id="menu-toggle" class="md:hidden p-2 rounded-md border border-slate-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </header>

    {{-- MENÚ MÓVIL --}}
    <div id="mobile-menu" class="hidden fixed inset-0 bg-black/50 z-40">
        <div class="absolute top-0 right-0 bg-white w-2/3 h-full p-6 shadow-lg">
            <button id="close-menu" class="mb-6 text-siceu-500 font-bold">✕ Cerrar</button>
            <nav class="flex flex-col gap-4 text-lg">
                <a href="/" class="hover:text-siceu-500">Inicio</a>
                <a href="/eventos" class="hover:text-siceu-500">Eventos</a>
                <a href="/about" class="hover:text-siceu-500">Nosotros</a>
                <a href="/contact" class="hover:text-siceu-500">Contacto</a>
                <a href="{{ route('login') }}" class="bg-siceu-500 text-white px-4 py-2 rounded-lg mt-2 text-center">Iniciar Sesión</a>
            </nav>
        </div>
    </div>

    {{-- HERO SECTION --}}
    <section class="hero-bg h-[90vh] flex flex-col justify-center items-center text-center text-white relative">
        <div class="absolute inset-0 bg-siceu-500/70"></div>
        <div class="relative z-10 px-4 fade-in">
            <h2 class="text-4xl md:text-6xl font-bold mb-4">Sistema Integral de Control de Eventos Universitarios</h2>
            <p class="text-lg md:text-xl mb-8 max-w-2xl mx-auto">Organiza, gestiona y difunde los eventos académicos, deportivos y culturales de tu institución de forma moderna y eficiente.</p>
            <a href="/eventos" class="bg-white text-siceu-500 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-slate-100 transition">Explorar eventos</a>
        </div>
    </section>

    {{-- SECCIÓN QUIÉNES SOMOS --}}
    <section class="py-20 bg-white fade-in">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <img src="{{ asset('img/estudiantes.jpg') }}" class="rounded-2xl shadow-lg w-full" alt="Estudiantes">
            <div>
                <h3 class="text-3xl font-bold text-siceu-500 mb-4">Sobre SICEU</h3>
                <p class="text-slate-600 mb-4 leading-relaxed">
                    SICEU es una plataforma diseñada para modernizar la gestión de eventos en instituciones educativas. 
                    Permite a los administradores crear y controlar eventos mientras los estudiantes pueden registrarse, recibir notificaciones y mantenerse informados.
                </p>
                <a href="/about" class="inline-block bg-siceu-500 text-white px-6 py-2 rounded-lg hover:bg-siceu-400 transition">Conoce más</a>
            </div>
        </div>
    </section>

    {{-- SECCIÓN DE BENEFICIOS --}}
    <section class="py-20 bg-slate-50 fade-in">
        <div class="max-w-6xl mx-auto text-center px-6">
            <h3 class="text-3xl font-bold text-siceu-500 mb-8">Beneficios Principales</h3>
            <div class="grid md:grid-cols-3 gap-10">
                <div class="bg-white rounded-2xl shadow p-6 hover:-translate-y-1 transition">
                    <img src="{{ asset('img/icon1.png') }}" class="w-16 h-16 mx-auto mb-4">
                    <h4 class="text-xl font-semibold mb-2">Gestión fácil</h4>
                    <p class="text-slate-600">Controla todos los eventos desde un solo panel, con registros automáticos y estadísticas.</p>
                </div>
                <div class="bg-white rounded-2xl shadow p-6 hover:-translate-y-1 transition">
                    <img src="{{ asset('img/icon2.png') }}" class="w-16 h-16 mx-auto mb-4">
                    <h4 class="text-xl font-semibold mb-2">Participación activa</h4>
                    <p class="text-slate-600">Los estudiantes pueden explorar e inscribirse fácilmente en eventos disponibles.</p>
                </div>
                <div class="bg-white rounded-2xl shadow p-6 hover:-translate-y-1 transition">
                    <img src="{{ asset('img/icon3.png') }}" class="w-16 h-16 mx-auto mb-4">
                    <h4 class="text-xl font-semibold mb-2">Comunicación eficiente</h4>
                    <p class="text-slate-600">Difunde notificaciones y recordatorios automáticos para mantener a todos informados.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- PIE DE PÁGINA --}}
    <footer class="bg-siceu-500 text-white py-10">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-lg font-semibold">SICEU — Universidad Tecnológica</p>
            <p class="text-sm mt-2">© {{ date('Y') }} Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        // Animación de aparición
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('show');
            });
        });
        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

        // Menú móvil
        const toggle = document.getElementById('menu-toggle');
        const menu = document.getElementById('mobile-menu');
        const closeBtn = document.getElementById('close-menu');
        toggle.addEventListener('click', () => menu.classList.remove('hidden'));
        closeBtn.addEventListener('click', () => menu.classList.add('hidden'));
    </script>

</body>
</html>
