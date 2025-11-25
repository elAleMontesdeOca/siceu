@extends('layouts.app')

@section('title', "Asistencias del Evento")

@section('content')

<div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-6">

    <h2 class="text-2xl font-bold mb-4">
        📋 Listado de Asistencias — {{ $evento->titulo }}
    </h2>

    {{-- ====================== --}}
    {{-- RESUMEN DEL EVENTO --}}
    {{-- ====================== --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

        <div class="p-4 bg-blue-100 rounded-lg">
            <p class="text-sm text-gray-500">Registrados</p>
            <p class="text-2xl font-bold">{{ $total_registrados }}</p>
        </div>

        <div class="p-4 bg-green-100 rounded-lg">
            <p class="text-sm text-gray-500">Asistencias</p>
            <p class="text-2xl font-bold">{{ $total_asistencias }}</p>
        </div>

        <div class="p-4 bg-yellow-100 rounded-lg">
            <p class="text-sm text-gray-500">% Asistencia</p>
            <p class="text-2xl font-bold">{{ $porcentaje }}%</p>
        </div>

        <div class="p-4 bg-purple-100 rounded-lg">
            <p class="text-sm text-gray-500">Cupo Ocupado</p>
            <p class="text-2xl font-bold">{{ $cupo_usado }}%</p>
        </div>

    </div>

    {{-- ====================== --}}
    {{-- BOTONES DE EXPORTACIÓN --}}
    {{-- ====================== --}}
    <div class="flex gap-3 mb-6">

        <a href="{{ route('asistencias.export.excel', $evento->id) }}"
            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            📄 Exportar Excel
        </a>

        <a href="{{ route('asistencias.export.pdf', $evento->id) }}"
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
            📰 Exportar PDF
        </a>

    </div>

    {{-- ====================== --}}
    {{-- TABLA DE ASISTENCIAS --}}
    {{-- ====================== --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 rounded-lg">
            <thead class="bg-gray-200 text-left">
                <tr>
                    <th class="p-2">Nombre</th>
                    <th class="p-2">Correo</th>
                    <th class="p-2">Fecha de Asistencia</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($asistencias as $asis)
                    <tr class="border-t">
                        <td class="p-2">{{ $asis->registro->user->name }}</td>
                        <td class="p-2">{{ $asis->registro->user->email }}</td>
                        <td class="p-2">{{ $asis->fecha_asistencia }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection
