<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "sistema_recrutamento");

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die(json_encode(["message" => "Erro na conexão com o banco de dados"]));
}

// Obtém os dados enviados
$dados = json_decode(file_get_contents("php://input"));

// Exibe os dados recebidos para debugging
var_dump($dados); // Para depuração, pode ser removido após teste

// Verifica se os campos necessários foram enviados
if (isset($dados->email) && isset($dados->senha_atual) && isset($dados->nova_senha)) {
    // Verifica se o usuário existe e se a senha atual está correta
    $stmt = $conn->prepare("SELECT senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $dados->email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifica a senha atual
        if (password_verify($dados->senha_atual, $user['senha'])) {
            // Criptografando a nova senha
            $senha_hash = password_hash($dados->nova_senha, PASSWORD_DEFAULT);

            // Atualiza a senha do usuário
            $stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
            $stmt->bind_param("ss", $senha_hash, $dados->email);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo json_encode(["message" => "Senha atualizada com sucesso"]);
            } else {
                echo json_encode(["message" => "Erro ao atualizar a senha"]);
            }
        } else {
            echo json_encode(["message" => "Senha atual incorreta"]);
        }
    } else {
        echo json_encode(["message" => "Usuário não encontrado"]);
    }

    $stmt->close();
} else {
    // Exibe um aviso detalhado sobre quais dados estão faltando
    $faltando = [];
    if (!isset($dados->email)) $faltando[] = "email";
    if (!isset($dados->senha_atual)) $faltando[] = "senha_atual";
    if (!isset($dados->nova_senha)) $faltando[] = "nova_senha";

    echo json_encode(["message" => "Dados incompletos", "faltando" => $faltando]);
}

$conn->close();
?>
