<?php
// CREAMOS EL SOCKET TCP
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

// Verificar que se creó correctamente
if ($socket === false) {
    echo "Error al crear el socket: " . socket_strerror(socket_last_error()) . "\n";
    exit();
}

// BIND ASOCIAR EL SOCKET A UNA IP Y PUERTO
$host = 'localhost';
$port = 8080;
if (socket_bind($socket, $host, $port) === false) {
    echo "Error al asociar el socket: " . socket_strerror(socket_last_error($socket)) . "\n";
    socket_close($socket);
    exit();
}

// LISTEN PONER EL SERVER EN MODO ESCUCHA
if (socket_listen($socket, 5) === false) {
    echo "Error al poner el socket en escucha: " . socket_strerror(socket_last_error($socket)) . "\n";
    socket_close($socket);
    exit();
}

echo "Servidor escuchando en $host:$port...\n";

// ACCEPT ACEPTAR CONEXIONES ENTRANTES
do {
    $client = socket_accept($socket);
    if ($client === false) {
        echo "Error al aceptar la conexión: " . socket_strerror(socket_last_error($socket)) . "\n";
        break;
    }

    // RECV LEER EL MENSAJE DEL CLIENTE
    $input = socket_read($client, 1024);
    echo "Mensaje recibido: $input\n";

    // SEND RESPONDER AL CLIENTE
    $response = "Hola, cliente! Tu mensaje fue: " . $input;
    socket_write($client, $response, strlen($response));

    // CERRAR LA CONEXION CON EL CLIENTE
    socket_close($client);
} while (true);

// CERRAR EL SOCKET PRINCIPAL
socket_close($socket);
?>
