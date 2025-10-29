@extends('layouts.auth')
@section('content')
<form method="POST" action="{{ route('register') }}" class="space-y-4">
  @csrf
  <div>
    <label class="block text-sm font-medium">Nombre completo</label>
    <input type="text" name="name" required
      class="mt-1 w-full border-slate-300 rounded-md shadow-sm focus:ring-siceu-500 focus:border-siceu-500">
  </div>
  <div>
    <label class="block text-sm font-medium">Correo institucional</label>
    <input type="email" name="email" required
      class="mt-1 w-full border-slate-300 rounded-md shadow-sm focus:ring-siceu-500 focus:border-siceu-500">
  </div>
  <div>
    <label class="block text-sm font-medium">Contraseña</label>
    <input type="password" name="password" required
      class="mt-1 w-full border-slate-300 rounded-md shadow-sm focus:ring-siceu-500 focus:border-siceu-500">
  </div>
  <div>
    <label class="block text-sm font-medium">Confirmar contraseña</label>
    <input type="password" name="password_confirmation" required
      class="mt-1 w-full border-slate-300 rounded-md shadow-sm focus:ring-siceu-500 focus:border-siceu-500">
  </div>
  <button type="submit"
    class="bg-siceu-500 text-white w-full py-2 rounded-lg hover:bg-siceu-400 font-semibold">Crear cuenta</button>
</form>
@endsection
