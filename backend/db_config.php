<?php
$host = 'localhost'; // Host do banco de dados
$dbname = 'portfolio'; // Nome do banco de dados
$username = 'root'; // Usuário do banco
$password = ''; // Senha do banco (padrão vazio no XAMPP)

// Criar a conexão
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configurar o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Exibir mensagem de erro se a conexão falhar
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>
