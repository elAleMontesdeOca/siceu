@extends('layouts.auth')
@section('content')
<form method="POST" action="{{ route('login') }}" class="space-y-4">
  @csrf
  <div>
    <label class="block text-sm font-medium">Correo institucional</label>
    <input type="email" name="email" required autofocus
      class="mt-1 w-full border-slate-300 rounded-md shadow-sm focus:ring-siceu-500 focus:border-siceu-500">
  </div>
  <div>
    <label class="block text-sm font-medium">Contraseña</label>
    <input type="password" name="password" required
      class="mt-1 w-full border-slate-300 rounded-md shadow-sm focus:ring-siceu-500 focus:border-siceu-500">
  </div>
  <div class="flex items-center justify-between">
    <a href="{{ route('register') }}" class="text-siceu-500 text-sm hover:underline">Registrarme</a>
    <button type="submit"
      class="bg-siceu-500 text-white px-4 py-2 rounded-lg hover:bg-siceu-400 font-semibold">Ingresar</button>
  </div>
</form>
@endsection
