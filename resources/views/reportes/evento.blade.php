@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-6">

    <h2 class="text-xl font-bold mb-4">
        📊 Reporte del Evento: {{ $evento->titulo }}
    </h2>

    <p><strong>Inscritos:</strong> {{ $inscritos }}</p>
    <p><strong>Asistentes:</strong> {{ $asistentes }}</p>
    <p><strong>Porcentaje de Asistencia:</strong> {{ $porcentaje }}%</p>

    @if ($cupoUsado !== null)
        <p><strong>Cupo Occupado:</strong> {{ $cupoUsado }}%</p>
    @endif

    <a href="{{ route('asistencias.excel', $evento) }}" class="btn btn-success mt-4">📥 Exportar Excel</a>

    <a href="{{ route('asistencias.pdf', $evento) }}" class="btn btn-danger mt-4 ml-2">📄 Exportar PDF</a>

</div>
@endsection
