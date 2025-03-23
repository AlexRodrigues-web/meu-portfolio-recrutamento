<?php
require 'vendor/autoload.php';
require 'db_config.php'; // Assegure-se de que este arquivo exista e tenha a conexão com o banco de dados configurada

use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

// Função para obter o token do cabeçalho
function getBearerToken() {
    $headers = apache_request_headers();
    if (isset($headers['Authorization'])) {
        return str_replace('Bearer ', '', $headers['Authorization']);
    }
    return null;
}

$token = getBearerToken();
if (!$token) {
    // Adicione uma linha de depuração
    error_log(print_r(apache_request_headers(), true)); // Log dos cabeçalhos para verificação
    echo json_encode(['message' => 'Token não fornecido']);
    exit;
}

try {
    // Substitua 'sua-chave-secreta' pela sua chave secreta real
    $decoded = JWT::decode($token, 'sua-chave-secreta', ['HS256']);

    // Acessando o ID do usuário do payload do token
    $userId = $decoded->data->id;

    // Consultando o banco de dados para buscar informações do usuário
    $stmt = $pdo->prepare("SELECT id, email, name FROM users WHERE id = :id");
    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Use PDO::FETCH_ASSOC para obter um array associativo

    if ($user) {
        // Ajustar a resposta para evitar duplicação de dados
        $response = [
            'message' => 'Acesso permitido',
            'user' => [
                'id' => $user['id'], 
                'email' => $user['email'],
                'name' => $user['name']
            ],
        ];
        echo json_encode($response);
    } else {
        echo json_encode(['message' => 'Usuário não encontrado']);
    }

} catch (ExpiredException $e) {
    echo json_encode(['message' => 'Token expirado']);
} catch (Exception $e) {
    echo json_encode(['message' => 'Token inválido']);
}
?>
