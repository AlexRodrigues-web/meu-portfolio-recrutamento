<?php
// auth.php

use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

function authenticate() {
    // O token deve ser passado no cabeçalho Authorization
    $headers = apache_request_headers();
    
    if (isset($headers['Authorization'])) {
        $matches = [];
        // Verifica se o cabeçalho Authorization começa com 'Bearer '
        if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
            $jwt = $matches[1];
            $secretKey = 'sua-chave-secreta'; // Use a mesma chave que você usou para gerar o token

            try {
                // Decodifica o token
                $decoded = JWT::decode($jwt, $secretKey, ['HS256']);
                // Token válido, retorna os dados decodificados
                return $decoded;
            } catch (ExpiredException $e) {
                // Token expirado
                return ['message' => 'Token expirado'];
            } catch (Exception $e) {
                // Token inválido
                return ['message' => 'Token inválido'];
            }
        }
    }
    return ['message' => 'Token não fornecido'];
}
