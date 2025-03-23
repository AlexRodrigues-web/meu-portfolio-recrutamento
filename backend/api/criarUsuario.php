<?php
// Permite o CORS para qualquer origem (substitua '*' por seu domínio específico, se necessário)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados recebidos do frontend em formato JSON
    $dados = json_decode(file_get_contents("php://input"));

    // Verifica se todos os dados obrigatórios foram enviados
    if (isset($dados->nome) && isset($dados->email) && isset($dados->senha)) {
        
        // Conecta ao banco de dados (altere com seus dados de acesso ao banco)
        $servername = "localhost";  // Host do banco
        $username = "root";         // Usuário do banco
        $password = "";             // Senha do banco (deixe vazio para XAMPP padrão)
        $dbname = "sistema_recrutamento";  // Nome do banco de dados

        // Cria a conexão
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica se a conexão foi bem-sucedida
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepara o statement para evitar SQL Injection
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $dados->nome, $dados->email, $senha); // 'sss' indica que são 3 strings

        // Criptografa a senha antes de salvar
        $senha = password_hash($dados->senha, PASSWORD_DEFAULT);

        // Executa o statement
        if ($stmt->execute()) {
            // Retorna uma resposta de sucesso para o frontend
            echo json_encode(["message" => "Usuário cadastrado com sucesso."]);
        } else {
            // Caso ocorra um erro ao inserir o usuário
            echo json_encode(["message" => "Erro ao cadastrar usuário: " . $stmt->error]);
        }

        // Fecha a conexão com o banco de dados
        $stmt->close();
        $conn->close();
    } else {
        // Retorna um erro se os dados necessários não foram enviados
        echo json_encode(["message" => "Dados incompletos. Por favor, envie nome, email e senha."]);
    }
} else {
    // Retorna um erro caso o método não seja POST
    echo json_encode(["message" => "Método inválido. Use POST."]);
}
?>
