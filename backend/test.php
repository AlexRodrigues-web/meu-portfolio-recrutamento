<?php
// Incluindo o autoload do Composer
require 'vendor/autoload.php';

// Agora você pode usar a biblioteca firebase/php-jwt
use \Firebase\JWT\JWT;

// Teste a criação de um token JWT
$payload = [
    'iss' => 'seu-issuer', // Emissor
    'aud' => 'seu-audience', // Destinatário
    'iat' => time(), // Data de emissão
    'exp' => time() + 3600, // Data de expiração (1 hora)
    'data' => [
        'id' => 1, // Exemplo de ID do usuário
        'email' => 'joao@email.com'
    ]
];

// Chave secreta
$secretKey = 'sua-chave-secreta';

// Gerar o token JWT
$jwt = JWT::encode($payload, $secretKey);
echo "Token JWT: " . $jwt;
