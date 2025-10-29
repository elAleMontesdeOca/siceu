@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
  <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
    <h3 class="text-lg font-semibold text-siceu-500">Eventos activos</h3>
    <p class="text-4xl font-bold mt-2">{{ $stats['eventos'] ?? 0 }}</p>
  </div>
  <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
    <h3 class="text-lg font-semibold text-siceu-500">Registros</h3>
    <p class="text-4xl font-bold mt-2">{{ $stats['registros'] ?? 0 }}</p>
  </div>
  <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
    <h3 class="text-lg font-semibold text-siceu-500">Asistencias</h3>
    <p class="text-4xl font-bold mt-2">{{ $stats['asistencias'] ?? 0 }}</p>
  </div>
</div>

<div class="mt-10">
  <h3 class="text-xl font-bold mb-4 text-slate-700">Próximos eventos</h3>
  <div class="bg-white rounded-xl shadow-sm p-4">
    <p class="text-slate-500 text-sm">Esta sección mostrará la lista de eventos próximos registrados por los administradores.</p>
  </div>
</div>
@endsection
