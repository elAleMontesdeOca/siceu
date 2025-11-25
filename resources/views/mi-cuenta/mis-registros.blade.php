@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Mis registros</h2>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

    @forelse($registros as $reg)
        <div class="bg-white border rounded-xl shadow p-4">

            <h3 class="font-bold text-lg text-siceu-500">
                {{ $reg->evento->titulo }}
            </h3>

            <p class="text-sm text-slate-600 mt-2">
                Fecha: {{ $reg->evento->fecha_inicio->format('d M Y') }}
            </p>

            <p class="text-sm mt-1">
                Estado: 
                <span class="font-semibold">
                    {{ ucfirst($reg->estado) }}
                </span>
            </p>

            <div class="mt-4 flex gap-2">
                <a href="{{ route('miCuenta.qr', $reg) }}" 
                   class="px-3 py-1 bg-siceu-500 text-white rounded-lg text-sm">
                    Ver QR
                </a>

                @if($reg->estado === 'inscrito')
                <form method="POST"
                      action="{{ route('eventos.cancelar', $reg->evento) }}">
                    @csrf
                    <button class="px-3 py-1 bg-red-500 text-white rounded-lg text-sm">
                        Cancelar
                    </button>
                </form>
                @endif
            </div>

        </div>
    @empty
        <p class="text-gray-500 col-span-full">Aún no tienes registros.</p>
    @endforelse

</div>
@endsection
