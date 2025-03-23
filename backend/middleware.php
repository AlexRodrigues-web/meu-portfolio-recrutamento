<?php
require 'vendor/autoload.php'; // Inclui o autoloader do Composer

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function verificaToken() {
    $headers = apache_request_headers(); // Obtém os cabeçalhos da requisição

    // Verifica se o cabeçalho de autorização está presente
    if (isset($headers['Authorization'])) {
        $authHeader = $headers['Authorization'];
        list($jwt) = sscanf($authHeader, 'Bearer %s'); // Extrai o token JWT do cabeçalho

        if ($jwt) {
            $key = "sua_chave_secreta"; // Substitua pela sua chave secreta

            try {
                $decoded = JWT::decode($jwt, new Key($key, 'HS256')); // Decodifica o token
                return $decoded; // Retorna os dados decodificados do token
            } catch (Exception $e) {
                return null; // Se houver um erro, retorna null
            }
        }
    }

    return null; // Se não houver token, retorna null
}
?>
