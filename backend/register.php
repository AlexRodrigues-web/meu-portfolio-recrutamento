<?php
// Configuração do cabeçalho
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

// Verifica se o método é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados enviados
    $dados = json_decode(file_get_contents("php://input"));

    // Verifica se os campos necessários foram enviados
    if (isset($dados->nome) && isset($dados->email) && isset($dados->senha)) {
        // Configurações do banco
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sistema_recrutamento";

        // Conexão ao banco usando PDO
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Verificando se o email já existe
            $stmt = $conn->prepare("SELECT email FROM usuarios WHERE email = :email");
            $stmt->bindParam(':email', $dados->email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo json_encode(["message" => "Email já está em uso."]);
                exit;
            }

            // Criptografa a senha
            $senha_hash = password_hash($dados->senha, PASSWORD_DEFAULT);

            // Insere o usuário
            $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)");
            $stmt->bindParam(':nome', $dados->nome);
            $stmt->bindParam(':email', $dados->email);
            $stmt->bindParam(':senha', $senha_hash);
            $stmt->execute();

            echo json_encode(["message" => "Usuário cadastrado com sucesso."]);
        } catch (PDOException $e) {
            echo json_encode(["message" => "Erro ao conectar ao banco de dados: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["message" => "Dados incompletos."]);
    }
} else {
    echo json_encode(["message" => "Método inválido. Use POST."]);
}
?>
