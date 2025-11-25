@extends('layouts.app')

@section('title', 'Mis notificaciones')

@section('content')
<h2 class="text-2xl font-bold mb-4">Notificaciones</h2>

@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="space-y-4">
    @forelse($notificaciones as $notificacion)
        <div class="bg-white p-4 rounded-xl shadow flex justify-between items-center">
            
            <div>
                <h3 class="font-semibold text-siceu-600">
                    {{ $notificacion->titulo }}
                </h3>
                <p class="text-slate-700">{{ $notificacion->mensaje }}</p>
                <span class="text-xs text-slate-500">
                    {{ $notificacion->created_at->diffForHumans() }}
                </span>
            </div>

            <form action="{{ route('notificaciones.eliminar', $notificacion) }}" method="POST">
                @csrf @method('DELETE')
                <button class="text-red-500 hover:underline">Eliminar</button>
            </form>

        </div>
    @empty
        <p class="text-slate-500">No tienes notificaciones.</p>
    @endforelse
</div>
@endsection
