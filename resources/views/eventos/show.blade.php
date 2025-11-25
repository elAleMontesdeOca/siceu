@extends('layouts.app')

@section('content')

    {{-- Hero con imagen --}}
    <div class="relative w-full h-72 md:h-96 rounded-2xl overflow-hidden shadow-lg">

        @if($evento->imagen)
            <img src="{{ asset('storage/' . $evento->imagen) }}" class="w-full h-full object-cover">
        @else
            <img src="https://placehold.co/1200x500?text=Sin+imagen" class="w-full h-full object-cover">
        @endif

        {{-- Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>

        {{-- Título hero --}}
        <div class="absolute bottom-6 left-6 text-white">
            <span class="inline-block bg-siceu-500/90 text-white text-xs px-3 py-1 rounded-full shadow">
                {{ $evento->categoria->nombre }}
            </span>

            <h1 class="text-3xl md:text-4xl font-extrabold mt-3 drop-shadow-lg">
                {{ $evento->titulo }}
            </h1>

            <p class="text-sm md:text-base text-gray-200 mt-1">
                {{ $evento->fecha_inicio->format('d M Y') }} • {{ $evento->hora }}
            </p>
        </div>
    </div>

    {{-- Contenedor principal --}}
    <div class="mt-10 grid lg:grid-cols-3 gap-8">

        {{-- Columna izquierda: descripción --}}
        <div class="lg:col-span-2 bg-white shadow-xl rounded-2xl p-8">

            <h2 class="text-xl font-semibold mb-4 text-siceu-500">
                📘 Descripción del Evento
            </h2>

            <p class="text-slate-700 leading-relaxed whitespace-pre-line">
                {{ $evento->descripcion }}
            </p>

            {{-- Información adicional en tarjetas --}}
            <div class="grid sm:grid-cols-2 gap-4 mt-8">

                <div class="bg-slate-50 p-4 rounded-xl border">
                    <h3 class="text-sm text-slate-500">📍 Lugar</h3>
                    <p class="font-semibold text-slate-800">{{ $evento->lugar }}</p>
                </div>

                @if($evento->cupo_max)
                    <div class="bg-slate-50 p-4 rounded-xl border">
                        <h3 class="text-sm text-slate-500">👥 Cupo máximo</h3>
                        <p class="font-semibold text-slate-800">{{ $evento->cupo_max }}</p>
                    </div>
                @endif

                <div class="bg-slate-50 p-4 rounded-xl border">
                    <h3 class="text-sm text-slate-500">📅 Fecha de inicio</h3>
                    <p class="font-semibold text-slate-800">{{ $evento->fecha_inicio->format('d M Y') }}</p>
                </div>

                @if($evento->fecha_fin)
                    <div class="bg-slate-50 p-4 rounded-xl border">
                        <h3 class="text-sm text-slate-500">🏁 Fecha de fin</h3>
                        <p class="font-semibold text-slate-800">{{ $evento->fecha_fin->format('d M Y') }}</p>
                    </div>
                @endif

            </div>
        </div>

        {{-- Columna derecha: tarjeta flotante --}}
        <div>
            <div class="bg-white shadow-xl rounded-2xl p-6 sticky top-10">

                <h3 class="text-lg font-semibold mb-4 text-slate-800">
                    Información rápida
                </h3>

                <ul class="space-y-3 text-slate-700">
                    <li>🗂 <strong>Categoría:</strong> {{ $evento->categoria->nombre }}</li>
                    <li>⏰ <strong>Hora:</strong> {{ $evento->hora }}</li>
                    <li>📌 <strong>Lugar:</strong> {{ $evento->lugar }}</li>
                    <li></li>
                </ul>


                @auth
                    @php
                        $registro = \App\Models\Registro::where('evento_id', $evento->id)
                            ->where('user_id', auth()->id())
                            ->first();

                        $inscrito = $registro && $registro->estado === 'inscrito';
                        $cancelado = $registro && $registro->estado === 'cancelado';
                    @endphp

                    {{-- Si el evento ya pasó --}}
                    @if($evento->estaFinalizado())
                        <div class="w-full bg-gray-300 text-gray-700 py-2 rounded-lg text-center">
                            ❌ Este evento ya finalizó
                        </div>

                        {{-- Si el usuario está inscrito --}}
                    @elseif($inscrito)
                        <form method="POST" action="{{ route('eventos.cancelar', $evento) }}">
                            @csrf
                            <button class="w-full bg-gray-300 text-gray-800 py-2 rounded-lg hover:bg-gray-400">
                                Cancelar inscripción
                            </button>
                        </form>

                        {{-- Si canceló y puede volver --}}
                    @elseif($cancelado)
                        <form method="POST" action="{{ route('eventos.registrarse', $evento) }}">
                            @csrf
                            <button class="w-full bg-yellow-500 text-white py-2 rounded-lg hover:bg-yellow-600">
                                Volver a registrarme
                            </button>
                        </form>

                        {{-- Nuevo registro --}}
                    @else
                        <form method="POST" action="{{ route('eventos.registrarse', $evento) }}">
                            @csrf
                            <button class="w-full bg-siceu-500 text-white py-2 rounded-lg hover:bg-siceu-600">
                                Registrarse al evento
                            </button>
                        </form>
                    @endif
                @endauth




                <a href="{{ url('/eventos') }}" class="mt-6 block text-center bg-siceu-500 hover:bg-siceu-600 
                                  text-white py-3 rounded-xl font-semibold transition shadow">
                    ← Regresar a eventos
                </a>

            </div>
        </div>

    </div>

@endsection