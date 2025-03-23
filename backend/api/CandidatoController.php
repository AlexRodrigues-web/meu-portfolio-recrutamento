<?php
require_once '../models/Avaliacao.php';

class AvaliacaoController {
    private $avaliacao;

    public function __construct($pdo) {
        $this->avaliacao = new Avaliacao($pdo);
    }

    public function avaliarCandidato($candidato_id, $avaliacao) {
        $this->avaliacao->avaliarCandidato($candidato_id, $avaliacao);
        echo json_encode(["message" => "Avaliação realizada com sucesso!"]);
    }
}
?>
