<?php
// Adicione os cabeçalhos CORS antes de qualquer saída
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Responde a requisições OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); // Retorna um código de sucesso
    exit(); // Para a execução do script
}

require 'vendor/autoload.php'; // Biblioteca JWT (instalar via Composer)

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Define a chave secreta para decodificação
$key = "sua_chave_secreta"; // Substitua por uma chave segura

header("Content-Type: application/json; charset=UTF-8");

// Função para verificar o token JWT
function verificaToken($key) {
    $headers = apache_request_headers(); // Obtém os cabeçalhos da requisição

    // Verifica se o cabeçalho de autorização está presente
    if (isset($headers['Authorization'])) {
        $authHeader = $headers['Authorization'];
        list($jwt) = sscanf($authHeader, 'Bearer %s'); // Extrai o token JWT do cabeçalho

        if ($jwt) {
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"));
    
    if (isset($input->email) && isset($input->senha)) {
        // Configurações do banco de dados
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sistema_recrutamento";

        // Conexão ao banco usando PDO
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepara a consulta
            $stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = :email");
            $stmt->bindParam(':email', $input->email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verifica a senha
                if (password_verify($input->senha, $user['senha'])) {
                    $payload = [
                        "iss" => "localhost",
                        "aud" => "localhost",
                        "iat" => time(),
                        "exp" => time() + (60 * 60), // Token válido por 1 hora
                        "user_id" => $user['id']
                    ];

                    $jwt = JWT::encode($payload, $key, 'HS256');
                    echo json_encode([
                        "message" => "Login bem-sucedido",
                        "token" => $jwt
                    ]);
                } else {
                    echo json_encode(["message" => "Senha incorreta"]);
                }
            } else {
                echo json_encode(["message" => "Usuário não encontrado"]);
            }
        } catch (PDOException $e) {
            echo json_encode(["message" => "Erro na conexão com o banco de dados: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["message" => "Dados incompletos"]);
    }
} else {
    echo json_encode(["message" => "Método inválido. Use POST."]);
}
?>
