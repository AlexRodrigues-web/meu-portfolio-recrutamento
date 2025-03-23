<?php
// Adicione os cabeçalhos CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Inclua o autoload do Composer para usar a biblioteca JWT
require 'vendor/autoload.php'; // Certifique-se de que o Composer está instalado corretamente

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Verifica se o cabeçalho Authorization foi enviado
if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
    list($type, $token) = explode(" ", $authHeader, 2); // Divide o cabeçalho em tipo e token

    if (strcasecmp($type, 'Bearer') == 0) { // Verifica se o tipo é 'Bearer'
        $key = "sua_chave_secreta"; // Substitua pela mesma chave usada na geração do token

        try {
            // Decodifica o token
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            echo json_encode([
                "message" => "Token é válido",
                "data" => $decoded // Aqui você pode acessar os dados do token
            ]);
        } catch (Exception $e) {
            echo json_encode(["message" => "Token inválido: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["message" => "Tipo de autenticação não suportado."]);
    }
} else {
    echo json_encode(["message" => "Token não fornecido."]);
}
?>
