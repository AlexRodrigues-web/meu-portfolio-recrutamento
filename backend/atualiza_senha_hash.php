<?php
// Nova senha que você deseja definir
$nova_senha = '123456'; // A senha que você quer definir
$senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT); // Criptografando a senha

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "sistema_recrutamento");

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die(json_encode(["message" => "Erro na conexão com o banco de dados"]));
}

// Atualiza a senha do usuário
$stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE email = 'joao@email.com'");
$stmt->bind_param("s", $senha_hash);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["message" => "Senha atualizada com sucesso"]);
} else {
    echo json_encode(["message" => "Erro ao atualizar a senha ou usuário não encontrado"]);
}

$stmt->close();
$conn->close();
?>
