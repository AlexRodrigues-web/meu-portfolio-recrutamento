<?php
require 'vendor/autoload.php';

use \Firebase\JWT\JWT;

// Chave secreta que deve ser mantida em segredo
$secretKey = 'sua-chave-secreta'; // Substitua pela sua chave secreta real

// Dados do token (payload)
$data = [
    'iss' => 'seu-issuer', // Issuer
    'aud' => 'seu-audience', // Audience
    'iat' => time(), // Data de criação
    'exp' => time() + 3600, // Expiração em 1 hora
    'data' => [
        'id' => 1, // ID do usuário
        'email' => 'joao@email.com' // Email do usuário
    ]
];

// Gerando o token
$jwt = JWT::encode($data, $secretKey);

// Exibindo o token
echo "Token JWT: " . $jwt;
?>
