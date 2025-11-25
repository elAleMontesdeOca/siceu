<h2>Reporte de Asistencia</h2>

<p><strong>Evento:</strong> {{ $evento->titulo }}</p>
<p><strong>Fecha:</strong> {{ $evento->fecha_inicio }}</p>

<table width="100%" border="1" cellspacing="0" cellpadding="4">
    <thead>
        <tr>
            <th>ID Usuario</th>
            <th>Nombre</th>
            <th>Fecha Asistencia</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($asistencias as $asis)
        <tr>
            <td>{{ $asis->registro->user->id }}</td>
            <td>{{ $asis->registro->user->name }}</td>
            <td>{{ $asis->fecha_asistencia }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
