@extends('layouts.app')

@section('title', 'Escáner de Asistencias')

@section('content')

<div class="max-w-xl mx-auto bg-white shadow-lg rounded-xl p-6">

    <h2 class="text-xl font-bold mb-4 text-center">📷 Escanear Código QR</h2>

    <div id="qr-reader" style="width: 100%;"></div>

</div>

{{-- Librerías necesarias --}}
<script src="https://unpkg.com/sweetalert2@11"></script>
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    function onScanSuccess(decodedText, decodedResult) {

        console.log("QR leído:", decodedText);

        fetch("{{ route('asistencias.validar') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ token: decodedText })
        })
        .then(res => res.json())
        .then(data => {

            // Mostrar alertas
            Swal.fire({
                icon: data.status,
                title: data.status === "success" ? "✔ Asistencia registrada" :
                       data.status === "warning" ? "⚠ Atención" : "❌ Error",
                text: data.message,
                timer: 2500,
                showConfirmButton: false
            });

            console.log("Respuesta del servidor:", data);
        })
        .catch(error => {
            console.error("Error en fetch:", error);
            Swal.fire("❌ Error", "No se pudo validar el código QR.", "error");
        });
    }

    // Escáner con cámara + upload image habilitado
    const scanner = new Html5QrcodeScanner("qr-reader", {
        fps: 10,
        qrbox: 250,
        rememberLastUsedCamera: true
    });

    scanner.render(onScanSuccess);
</script>

@endsection
