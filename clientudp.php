<?php
$host = 'localhost';
$port = 8080;

// Crear un socket UDP
$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

// Verificar si el socket fue creado correctamente
if ($socket === false) {
    echo "Error al crear el socket: " . socket_strerror(socket_last_error()) . "\n";
    exit();
}


// Pedir al usuario que ingrese un mensaje
echo "Escribe un mensaje para enviar al servidor: ";
$message = trim(fgets(STDIN)); // Leer entrada desde el teclado

// Enviar el mensaje al servidor
socket_sendto($socket, $message, strlen($message), 0, $host, $port);

// Leer la respuesta del servidor
$buf = '';
$from = '';
$portFrom = 0;

if (socket_recvfrom($socket, $buf, 1024, 0, $from, $portFrom) === false) {
    // Manejar el error de no recibir respuesta
    echo "No se recibió respuesta del servidor. Puede que esté apagado o no disponible.\n";
} else {
    echo "Respuesta del servidor: $buf\n";
}

// Cerrar el socket
socket_close($socket);
?>
