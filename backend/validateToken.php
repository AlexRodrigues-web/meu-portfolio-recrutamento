<?php
require 'vendor/autoload.php'; // Certifique-se de que o Composer foi instalado corretamente

use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzZXUtaXNzdWVyIiwiYXVkIjoic2V1LWF1ZGllbmNlIiwiaWF0IjoxNzMzMjYzOTEzLCJleHAiOjE3MzMyNjc1MTMsImRhdGEiOnsiaWQiOjEsImVtYWlsIjoiam9hb0BlbWFpbC5jb20ifX0.xPMlGc_jrI_wsMMR99eNtFUiyrOemAE7aoGkvyiK6yg"; // Insira o token aqui

// Chave secreta
$secretKey = 'sua-chave-secreta'; // Use a mesma chave secreta usada para gerar o token

try {
    // Decodificar o token
    $decoded = JWT::decode($token, $secretKey, ['HS256']);
    // Token válido
    echo json_encode(['message' => 'Token válido', 'data' => $decoded]);
} catch (ExpiredException $e) {
    // Token expirado
    echo json_encode(['message' => 'Token expirado', 'error' => $e->getMessage()]);
} catch (Exception $e) {
    // Token inválido
    echo json_encode(['message' => 'Token inválido', 'error' => $e->getMessage()]);
}
