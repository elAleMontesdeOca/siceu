@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Mi código QR</h2>

    <div class="bg-white p-6 rounded-xl shadow text-center w-full md:w-1/2 mx-auto">

        <p class="text-gray-700 mb-4">
            Evento: <strong>{{ $registro->evento->titulo }}</strong>
        </p>

        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode($registro->qr_token) }}"
            alt="QR Code" class="mx-auto" />


        <p class="text-sm text-gray-500 mt-4">
            Presenta este código el día del evento para registrar tu asistencia.
        </p>

        <a href="{{ route('miCuenta.registros') }}" class="mt-6 inline-block bg-siceu-500 text-white px-4 py-2 rounded-lg">
            ← Regresar
        </a>

    </div>
@endsection