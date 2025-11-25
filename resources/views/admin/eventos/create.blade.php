@extends('layouts.app')
@section('title', 'Nuevo evento')

@section('content')
  <h2 class="text-2xl font-bold mb-6">Crear nuevo evento</h2>

  <form action="{{ route('eventos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div>
      <label class="block font-medium">Título</label>
      <input type="text" name="titulo" class="w-full border rounded-md p-2" required>
    </div>

    <div>
      <label class="block font-medium">Descripción</label>
      <textarea name="descripcion" class="w-full border rounded-md p-2" rows="4"></textarea>
    </div>

    <div class="grid sm:grid-cols-2 gap-4">
      <div>
        <label class="block font-medium">Fecha inicio</label>
        <input type="date" name="fecha_inicio" class="w-full border rounded-md p-2" required>
      </div>
      <div>
        <label class="block font-medium">Fecha fin</label>
        <input type="date" name="fecha_fin" class="w-full border rounded-md p-2">
      </div>
    </div>

    <div class="grid sm:grid-cols-2 gap-4">
      <div>
        <label class="block font-medium">Hora</label>
        <input type="time" name="hora" class="w-full border rounded-md p-2" required>
      </div>
      <div>
        <label class="block font-medium">Lugar</label>
        <input type="text" name="lugar" class="w-full border rounded-md p-2" required>
      </div>
    </div>

    <div class="grid sm:grid-cols-2 gap-4">
      <div>
        <label class="block font-medium">Cupo máximo</label>
        <input type="number" name="cupo_max" class="w-full border rounded-md p-2">
      </div>
      <div>
        <label class="block font-medium">Imagen</label>
        <input type="file" name="imagen" class="w-full border rounded-md p-2">
      </div>
    </div>

    <div>
      <label class="block font-medium">Categoría</label>
      <select name="categoria_id" class="w-full border rounded-md p-2" required>
        <option value="">Seleccione una categoría</option>
        @foreach($categorias as $cat)
          <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
        @endforeach
      </select>
    </div>

    <button class="bg-siceu-500 text-white px-6 py-2 rounded-lg hover:bg-siceu-400">Guardar</button>
  </form>
@endsection