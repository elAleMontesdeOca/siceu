@extends('layouts.app')

@section('title', 'Bienvenido a SICEU')

@section('content')
<div class="text-center py-10">
  <h1 class="text-3xl font-bold text-siceu-500 mb-4">Bienvenido a SICEU</h1>
  <p class="text-slate-600">Gracias por iniciar sesión. Aquí podrás consultar eventos y notificaciones públicas.</p>

  <a href="/eventos" class="mt-6 inline-block bg-siceu-500 text-white px-6 py-2 rounded-lg hover:bg-siceu-400">
    Ver eventos disponibles
  </a>
</div>
@endsection
