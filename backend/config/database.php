<?php
class Database {
    private $host = "localhost";
    private $db_name = "sistema_recrutamento";
    private $username = "root";  // Usuário do banco de dados
    private $password = "";      // Senha do banco de dados
    private $conn;

    // Função para obter a conexão
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Erro na conexão com o banco de dados: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
