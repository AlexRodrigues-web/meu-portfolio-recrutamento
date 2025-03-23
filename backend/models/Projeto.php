<?php
class Candidato {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function candidatarProjeto($usuario_id, $projeto_id) {
        $sql = "INSERT INTO candidatos (usuario_id, projeto_id) VALUES (:usuario_id, :projeto_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':projeto_id', $projeto_id);
        $stmt->execute();
    }
}
?>
