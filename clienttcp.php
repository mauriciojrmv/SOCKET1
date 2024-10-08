<?php
$host = 'localhost';
$port = 8080;

// SOCKET CREAMOS UN SOCKET TCP
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

// CONNECT  NOS CONECTAMOS AL SERVIDOR
if (socket_connect($socket, $host, $port) === false) {
    echo "Error al conectar: " . socket_strerror(socket_last_error($socket)) . "\n";
    exit();
}

// Pedir al usuario que ingrese un mensaje
echo "Escribe un mensaje para enviar al servidor: ";
$message = trim(fgets(STDIN)); // Leer entrada desde el teclado

// SEND ENVIAR MENSAJE AL SERVIDOR
socket_write($socket, $message, strlen($message));

// RECV LEER LA RESPUESTA DEL SERVIDOR
$response = socket_read($socket, 1024);
echo "Respuesta del servidor: $response\n";

// CLOSE CERRAMOS EL SOCKET
socket_close($socket);
?>