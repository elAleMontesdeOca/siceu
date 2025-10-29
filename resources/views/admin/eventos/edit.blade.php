@extends('layouts.app')
@section('title', 'Editar evento')

@section('content')
<h2 class="text-2xl font-bold mb-6">Editar evento</h2>

<form action="{{ route('eventos.update', $evento) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
  @csrf @method('PUT')

  <div>
    <label class="block font-medium">Título</label>
    <input type="text" name="titulo" class="w-full border rounded-md p-2" value="{{ $evento->titulo }}" required>
  </div>

  <div>
    <label class="block font-medium">Descripción</label>
    <textarea name="descripcion" class="w-full border rounded-md p-2" rows="4">{{ $evento->descripcion }}</textarea>
  </div>

  <div class="grid sm:grid-cols-2 gap-4">
    <div>
      <label class="block font-medium">Fecha inicio</label>
      <input type="date" name="fecha_inicio" class="w-full border rounded-md p-2" value="{{ $evento->fecha_inicio->format('Y-m-d') }}" required>
    </div>
    <div>
      <label class="block font-medium">Fecha fin</label>
      <input type="date" name="fecha_fin" class="w-full border rounded-md p-2" value="{{ optional($evento->fecha_fin)->format('Y-m-d') }}">
    </div>
  </div>

  <div class="grid sm:grid-cols-2 gap-4">
    <div>
      <label class="block font-medium">Hora</label>
      <input type="time" name="hora" class="w-full border rounded-md p-2" value="{{ $evento->hora }}" required>
    </div>
    <div>
      <label class="block font-medium">Lugar</label>
      <input type="text" name="lugar" class="w-full border rounded-md p-2" value="{{ $evento->lugar }}" required>
    </div>
  </div>

  <div class="grid sm:grid-cols-2 gap-4">
    <div>
      <label class="block font-medium">Cupo máximo</label>
      <input type="number" name="cupo_max" class="w-full border rounded-md p-2" value="{{ $evento->cupo_max }}">
    </div>
    <div>
      <label class="block font-medium">Imagen</label>
      <input type="file" name="imagen" class="w-full border rounded-md p-2">
      @if($evento->imagen)
        <img src="{{ asset('storage/'.$evento->imagen) }}" class="w-40 h-24 object-cover mt-2 rounded-lg">
      @endif
    </div>
  </div>

  <button class="bg-siceu-500 text-white px-6 py-2 rounded-lg hover:bg-siceu-400">Actualizar</button>
</form>
@endsection
