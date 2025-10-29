@extends('layouts.app')
@section('content')
<h2 class="text-2xl font-bold mb-6">Eventos disponibles</h2>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
  @forelse($eventos as $evento)
    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
      <img src="{{ $evento->imagen ?? 'https://placehold.co/600x300' }}" alt="evento"
           class="w-full h-40 object-cover">
      <div class="p-4">
        <h3 class="text-lg font-bold text-slate-900">{{ $evento->titulo }}</h3>
        <p class="text-sm text-slate-600 mt-1">{{ Str::limit($evento->descripcion, 100) }}</p>
        <div class="mt-3 flex justify-between items-center text-sm text-slate-500">
          <span>📅 {{ $evento->fecha_inicio->format('d M Y') }}</span>
          <a href=\"/eventos/{{ $evento->id }}\" class=\"text-siceu-500 font-medium hover:underline\">Ver más</a>
        </div>
      </div>
    </div>
  @empty
    <p class=\"text-slate-500 col-span-full\">No hay eventos registrados aún.</p>
  @endforelse
</div>
@endsection
