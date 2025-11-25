@extends('layouts.app')
@section('content')

<h2 class="text-2xl font-bold mb-6">Eventos disponibles</h2>

{{-- Filtros avanzados --}}
<form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

    {{-- Buscador --}}
    <input type="text" name="buscar"
        value="{{ request('buscar') }}"
        placeholder="Buscar evento..."
        class="border border-siceu-500 px-4 py-2 rounded-lg">

    {{-- Categorías --}}
    <select name="categoria" onchange="this.form.submit()"
        class="border border-siceu-500 px-4 py-2 rounded-lg">
        <option value="">Todas las categorías</option>
        @foreach($categorias as $cat)
            <option value="{{ $cat->id }}" 
                {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                {{ $cat->nombre }}
            </option>
        @endforeach
    </select>

    {{-- Filtro por fecha --}}
    <input type="date" name="fecha"
        value="{{ request('fecha') }}"
        class="border border-siceu-500 px-4 py-2 rounded-lg">
</form>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

  @forelse($eventos as $evento)
    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">

      {{-- Imagen --}}
      @if($evento->imagen)
        <img src="{{ asset('storage/'.$evento->imagen) }}" 
             alt="imagen evento"
             class="w-full h-40 object-cover">
      @else
        <img src="https://placehold.co/600x300?text=Sin+imagen" 
             class="w-full h-40 object-cover">
      @endif

      <div class="p-4">

        {{-- Categoría --}}
        <span class="inline-block bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">
          {{ $evento->categoria->nombre }}
        </span>

        <h3 class="text-lg font-bold text-slate-900 mt-2">
          {{ $evento->titulo }}
        </h3>

        <p class="text-sm text-slate-600 mt-1">
          {{ Str::limit($evento->descripcion, 100) }}
        </p>

        <div class="mt-3 flex justify-between items-center text-sm text-slate-500">
          <span>📅 {{ $evento->fecha_inicio->format('d M Y') }}</span>

          <a href="{{ url('/eventos/'.$evento->id) }}" 
             class="text-siceu-500 font-medium hover:underline">
            Ver más
          </a>
        </div>
      </div>

    </div>

  @empty
    <p class="text-slate-500 col-span-full">No hay eventos registrados aún.</p>
  @endforelse

</div>

{{-- Paginación --}}
<div class="mt-8">
  {{ $eventos->links() }}
</div>

@endsection
