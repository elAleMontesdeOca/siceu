@extends('layouts.app')
@section('title', 'Gestión de eventos')

@section('content')
<div class="flex justify-between items-center mb-6">
  <h2 class="text-2xl font-bold">Eventos registrados</h2>
  <a href="{{ route('eventos.create') }}" class="bg-siceu-500 text-white px-4 py-2 rounded-lg hover:bg-siceu-400">
    + Nuevo evento
  </a>
</div>

@if (session('success'))
  <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
    {{ session('success') }}
  </div>
@endif

<table class="min-w-full bg-white rounded-lg shadow-md overflow-hidden">
  <thead class="bg-siceu-500 text-white">
    <tr>
      <th class="px-4 py-2 text-left">Título</th>
      <th class="px-4 py-2 text-left">Fecha</th>
      <th class="px-4 py-2 text-left">Lugar</th>
      <th class="px-4 py-2 text-center">Acciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($eventos as $evento)
      <tr class="border-b hover:bg-slate-50">
        <td class="px-4 py-2 font-semibold">{{ $evento->titulo }}</td>
        <td class="px-4 py-2">{{ $evento->fecha_inicio->format('d/m/Y') }}</td>
        <td class="px-4 py-2">{{ $evento->lugar }}</td>
        <td class="px-4 py-2 text-center space-x-2">
          <a href="{{ route('eventos.edit', $evento) }}" class="text-siceu-500 hover:underline">Editar</a>
          <form action="{{ route('eventos.destroy', $evento) }}" method="POST" class="inline">
            @csrf @method('DELETE')
            <button class="text-red-500 hover:underline" onclick="return confirm('¿Eliminar este evento?')">Eliminar</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="mt-4">
  {{ $eventos->links() }}
</div>
@endsection
