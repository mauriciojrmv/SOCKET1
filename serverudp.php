<?php
// Crear un socket UDP/IPv4
$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

// Verificar si el socket fue creado correctamente
if ($socket === false) {
    echo "Error al crear el socket: " . socket_strerror(socket_last_error()) . "\n";
    exit();
}

// Asociar el socket a una IP y puerto
$host = 'localhost';
$port = 8080;
if (socket_bind($socket, $host, $port) === false) {
    echo "Error al asociar el socket: " . socket_strerror(socket_last_error($socket)) . "\n";
    socket_close($socket);
    exit();
}

echo "Servidor UDP escuchando en $host:$port...\n";

// Escuchar y responder en un bucle
do {
    // Preparar las variables para almacenar los datos recibidos y la dirección del cliente
    $buf = '';
    $from = '';
    $portFrom = 0;

    // Leer mensaje del cliente
    socket_recvfrom($socket, $buf, 1024, 0, $from, $portFrom);
    echo "Mensaje recibido de $from:$portFrom: $buf\n";

    // Preparar la respuesta personalizada
    $response = "Hola, cliente! Tu mensaje fue: " . $buf;

    // Enviar la respuesta al cliente
    socket_sendto($socket, $response, strlen($response), 0, $from, $portFrom);

} while (true);

// Cerrar el socket
socket_close($socket);
?>
