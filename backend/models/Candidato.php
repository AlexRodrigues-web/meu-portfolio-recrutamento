<?php
class Avaliacao {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function avaliarCandidato($candidato_id, $avaliacao) {
        $sql = "INSERT INTO avaliacoes (candidato_id, avaliacao) VALUES (:candidato_id, :avaliacao)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':candidato_id', $candidato_id);
        $stmt->bindParam(':avaliacao', $avaliacao);
        $stmt->execute();
    }
}
?>
<?php
class Avaliacao {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function avaliarCandidato($candidato_id, $avaliacao) {
        $sql = "INSERT INTO avaliacoes (candidato_id, avaliacao) VALUES (:candidato_id, :avaliacao)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':candidato_id', $candidato_id);
        $stmt->bindParam(':avaliacao', $avaliacao);
        $stmt->execute();
    }
}
?>
